<?php

namespace app\controllers;

class TestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionMenu()
    {
        return $this->render('menu');
    }

}
