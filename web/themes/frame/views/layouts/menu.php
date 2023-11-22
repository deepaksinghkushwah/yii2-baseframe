<?php

/* @var $this yii\web\View */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->registerCss("#login-form{padding: 15px; min-width:300px;}");
$this->beginBlock('login');
echo "<div class='dropdown-menu'><div class='row'>
                            <div class='container-fluid'>";
$model = new app\models\LoginForm();
$form = ActiveForm::begin(['id' => 'login-form', 'action' => yii\helpers\Url::to(['/site/login'], true)]);
echo $form->field($model, 'username');
echo $form->field($model, 'password')->passwordInput();
echo $form->field($model, 'code')->textInput(['placeholder' => 'Secret Key']);
echo $form->field($model, 'rememberMe')->checkbox();
echo '<div style="color:#999;margin:1em 0"> 
                    If you forgot your password you can ' . Html::a('reset it', ['site/request-password-reset']) . '
                </div>
                <div class="form-group">
                    ' . Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) . ' <a class="btn btn-success" href="'.yii\helpers\Url::to(['/site/signup'],true).'">Sigup</a>
                </div>';
/* echo yii\authclient\widgets\AuthChoice::widget([
  'baseAuthUrl' => ['site/auth'],
  'popupMode' => false,
  ]); */
ActiveForm::end();
echo "</div></div></div>";
$this->endBlock();

$this->beginBlock('dynamic_menu');
echo app\components\MenuWidget::widget(['location' => 'top']);
$this->endBlock();
$theme = \app\models\Theme::findOne(['default' => 1]);
yii\bootstrap\NavBar::begin([
    'brandLabel' => Yii::$app->params['settings']['application_name'],
    'brandUrl' => Yii::$app->homeUrl,
    'renderInnerContainer' => false,
    'options' => [
        'class' => 'navbar-default navbar-fixed-top navbar-'.$theme->inverse,
    ],
]);
$path = Yii::$app->controller->id.'/'.Yii::$app->controller->action->id;
$pageAlias = Yii::$app->request->get('alias');
echo "<div class='container-fluid'>";
echo \yii\bootstrap\Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => [
        ['label' => 'Home', 'url' => Yii::$app->homeUrl,'active' => $path == "site/search"],
        //['label' => 'Latest News', 'url' => ['/news']],
        ['label' => 'About Us', 'url' => ['/pages/general/about-us'],'active' => $path == 'site/page' && $pageAlias == 'about-us'],
        ['label' => 'Contact Us', 'url' => ['/contact'],'active' => $path == 'site/contact'],
        
        $this->blocks['dynamic_menu'],
    ],
]);

echo \yii\bootstrap\Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        // ['label' => 'Signup', 'url' => array('/signup'), 'visible' => Yii::$app->user->isGuest],
        Yii::$app->user->isGuest ?
                [
            'label' => 'Login',
            'url' => 'javascript:void(0)',
            'items' => $this->blocks['login']
                ] :
                [
            'label' => ucfirst(Yii::$app->user->identity->username),
            'visible' => !Yii::$app->user->isGuest,
            'url' => ['#'],
            'items' => [
                ['label' => 'My Profile', 'url' => ['/userprofile/index'], 'visible' => !Yii::$app->user->isGuest],
                ['label' => 'Change Password', 'url' => ['/userprofile/changepassword'], 'visible' => !Yii::$app->user->isGuest],
                //['label' => 'User Rights', 'url' => ['/admin/assignment'], 'visible' => key_exists("Super Admin", Yii::$app->getAuthManager()->getRolesByUser(Yii::$app->user->identity->id))],
                ['label' => 'Backend', 'url' => ['/backend/default/index'], 'visible' => key_exists("Super Admin", Yii::$app->getAuthManager()->getRolesByUser(Yii::$app->user->identity->id))],
                //['label' => 'GII', 'url' => ['/gii'], 'visible' => key_exists("Super Admin", Yii::$app->getAuthManager()->getRolesByUser(Yii::$app->user->identity->id))],
                ['label' => 'Logout', 'url' => ['/logout'], 'linkOptions' => ['data-method' => 'post']],
            ],
                ],
    ],
]);

echo "</div>";
yii\bootstrap\NavBar::end();
?>