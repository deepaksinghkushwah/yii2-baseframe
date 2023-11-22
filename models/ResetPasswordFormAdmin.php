<?php

namespace app\models;

use app\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class ResetPasswordFormAdmin extends Model {

    public $password;

    /**
     * @var \app\models\User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param  int id                               
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($id, $config = []) {
        $this->_user = User::findOne($id);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong user id.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword() {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save();
    }

}
