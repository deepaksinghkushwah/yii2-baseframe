<?php

namespace app\controllers;

use Yii;

class EmployeeController extends \yii\web\Controller {

    public function actionIndex() {
        $model = \app\models\EmployeeStatus::find()->where("DATE_FORMAT(created_at,'%Y-%m-%d') AND user_id = '" . Yii::$app->user->id . "'")->orderBy(['id' => SORT_DESC])->one();
        if (!$model) {
            $model = new \app\models\EmployeeStatus();            
        }

        
        if ($model->load(Yii::$app->request->post()) ) {
            $nm = new \app\models\EmployeeStatus();
            $nm->user_id = Yii::$app->user->id;
            $nm->status = $model->status;                    
            $nm->save();
            $status = $nm->status == 1 ? 'On Seat' : 'Not on seat';
            Yii::$app->session->setFlash("success", "You have updated your status to $status");
            return $this->refresh();
        }
        return $this->render('index', ['model' => $model]);
    }

}
