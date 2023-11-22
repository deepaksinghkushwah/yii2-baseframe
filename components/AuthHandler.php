<?php

namespace app\components;

use app\models\Auth;
use app\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * AuthHandler handles successful authentification via Yii auth component
 */
class AuthHandler {

    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client) {
        $this->client = $client;
    }

    public function handle() {
        $attributes = $this->client->getUserAttributes();
        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $nickname = ArrayHelper::getValue($attributes, 'email');

        /** @var Auth $auth */
        $auth = Auth::find()->where([
                    'source' => $this->client->getId(),
                    'source_id' => $id,
                ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                /** @var User $user */
                $user = $auth->user;
                $this->updateUserInfo($user);
                Yii::$app->user->login($user, 3600);
            } else { // signup
                
                if ($email !== null && User::find()->where(['email' => $email])->exists()) {
                    $xuser = User::find()->where(['email' => $email])->one();
                    Yii::$app->getSession()->setFlash('danger', [
                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it (Last login source: {lls}). Login using email first to link it.", ['client' => $this->client->getTitle(), 'lls' => Auth::findOne(['user_id' => $xuser->id])->source]),
                    ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'username' => $nickname,
                        /* 'github' => $nickname, */
                        'email' => $email,
                    ]);
                    $user->generateAuthKey();
                    $user->setPassword($password);
                    $user->generatePasswordResetToken();
                    $user->role = 10;


                    $transaction = User::getDb()->beginTransaction();

                    if ($user->save()) {

                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $this->client->getId(),
                            'source_id' => (string) $id,
                        ]);
                        if ($auth->save()) {
                            $profile = new \app\models\Userprofile;
                            $profile->user_id = $user->id;
                            $profile->fullname = $user->username;
                            $profile->image = 'noimg.jpg';
                            $profile->save();
                            Yii::$app->authManager->assign(Yii::$app->authManager->getRole('Registered'), $user->id);

                            $mail = Yii::$app->mailer->compose(['html' => 'registermail'], ['user' => $user,'password' => $password]);
                            $sub = Yii::$app->name . ' user registration';
                            $mail->setTo($user->email);
                            $mail->setFrom(Yii::$app->params['adminEmail']);
                            $mail->setSubject($sub);
                            $data = $mail->send();

                            if ($data == true) {
                                Yii::$app->session->setFlash('success', 'Thank you for register with us! Login details with an activation link has been sent to your mail id to activate your account.');
                            } else {
                                Yii::$app->session->setFlash('danger', 'Error at sending mail please try again.');
                            }



                            $transaction->commit();

                            Yii::$app->user->login($user, 3600);
                        } else {
                            Yii::$app->getSession()->setFlash('danger', [
                                Yii::t('app', 'Unable to save {client} account: {errors}', [
                                    'client' => $this->client->getTitle(),
                                    'errors' => json_encode($auth->getErrors()),
                                ]),
                            ]);
                        }
                    } else {
                        Yii::$app->getSession()->setFlash('danger', [
                            Yii::t('app', 'Unable to save user: {errors}', [
                                'client' => $this->client->getTitle(),
                                'errors' => json_encode($user->getErrors()),
                            ]),
                        ]);
                    }
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $this->client->getId(),
                    'source_id' => (string) $attributes['id'],
                ]);
                if ($auth->save()) {
                    /** @var User $user */
                    $user = $auth->user;
                    $this->updateUserInfo($user);
                    Yii::$app->getSession()->setFlash('success', [
                        Yii::t('app', 'Linked {client} account.', [
                            'client' => $this->client->getTitle()
                        ]),
                    ]);
                } else {
                    Yii::$app->getSession()->setFlash('danger', [
                        Yii::t('app', 'Unable to link {client} account: {errors}', [
                            'client' => $this->client->getTitle(),
                            'errors' => json_encode($auth->getErrors()),
                        ]),
                    ]);
                }
            } else { // there's existing auth
                Yii::$app->getSession()->setFlash('danger', [
                    Yii::t('app', 'Unable to link {client} account. There is another user using it.', ['client' => $this->client->getTitle()]),
                ]);
            }
        }
    }

    /**
     * @param User $user
     */
    private function updateUserInfo(User $user) {
        $attributes = $this->client->getUserAttributes();
        $user->save();
        /*$github = ArrayHelper::getValue($attributes, 'login');
        if ($user->github === null && $github) {
            $user->github = $github;
            $user->save();
        }*/
    }

}
