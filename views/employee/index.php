<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userprofile */
/* @var $form yii\widgets\ActiveForm */
/* @var $this yii\web\View */
$this->title = "Update your today's status";
$css = '.employee-status-form { display: flex;justify-content: center;min-height: 70vh;align-items: center; border: 100px solid gray; background-color: light-gray; }'
        . '.box {text-align: center}';
$this->registerCss($css);
if ($model->isNewRecord) {
    $model->status = 1;
}

$cs = \app\models\EmployeeStatus::GetCurrentStatus(Yii::$app->user->id, date('Y-m-d'));
$currentStatus = '';
if ($cs && $cs['status']==1) {
    $currentStatus = Html::img(yii\helpers\Url::to(['/images/greenCircle.png'], true)) . ' On seat';
} else {
    $currentStatus = Html::img(yii\helpers\Url::to(['/images/redCircle.png'], true)) . ' Not on seat';
}
?>


<div class="employee-status-form">
    <div class="box">
        <h1><?= $this->title ?></h1>

        <?php
        if ($currentStatus != "") {
            ?>
            <p>Your current status: <?= $currentStatus ?></p>
            <?php
        }
        $form = ActiveForm::begin();
        ?>
        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'status')->radioList(['1' => 'Yes', '0' => 'No'])->label("Are you on seat?") ?>

        <div class="form-group">

            <?= Html::submitButton($model->isNewRecord ? 'Update' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

