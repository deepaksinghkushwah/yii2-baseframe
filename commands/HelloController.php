<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller {

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world') {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionGenFixture() {
        // user

        for ($i = 1000; $i < 2000; $i++) {
            // create user
            $user = new \app\models\User();
            $user->username = "test" . $i;
            $user->email = "test" . $i . "@localhost.com";
            $user->status = 10;
            $user->setPassword('123456');
            $user->generateAuthKey();
            if ($user->save()) {
                $profile = new \app\models\Userprofile();
                $profile->fullname = "Test " . $i;
                $profile->image = "noimg.jpg";
                $profile->department_id = (int) range(0, 3, 1);
                $profile->position_id = (int) range(0, 5, 1);
                $profile->role = "Registered";
                $profile->contact_mobile = '1234567890';
                $profile->user_id = $user->id;
                $profile->image = 'noimg.jpg';
                if (!$profile->save()) {
                    echo \app\components\GeneralHelper::getErrorAsString($profile);
                    exit;
                }
                \Yii::$app->authManager->assign(\Yii::$app->authManager->getRole($profile->role), $user->id);
            }
        }
    }

}
