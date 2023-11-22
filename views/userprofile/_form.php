<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userprofile */
/* @var $form yii\widgets\ActiveForm */



$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/frontend/signup.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
echo Html::hiddenInput("getCountyUrl", yii\helpers\Url::to(['/site/get-counties'], true), ['id' => 'getCountyUrl']);
echo Html::hiddenInput("getCityUrl", yii\helpers\Url::to(['/site/get-cities'], true), ['id' => 'getCityUrl']);

if ($model->isNewRecord) {
    $country = yii\helpers\ArrayHelper::map(\app\models\GeoCountry::find()->all(), 'id', 'name');
    $states = [];
    $cities = [];
} else {
    $country = yii\helpers\ArrayHelper::map(\app\models\GeoCountry::find()->all(), 'id', 'name');
    $states = yii\helpers\ArrayHelper::map(\app\models\GeoState::find()->where("country_id = '" . $model->country_id . "'")->all(), 'id', 'name');
    $cities = yii\helpers\ArrayHelper::map(\app\models\GeoCity::find()->where("state_id = '" . $model->state_id . "'")->all(), 'id', 'name');
}
?>

<div class="userprofile-form">

    <?php
    $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
    ]);
    ?>
    <?= $form->errorSummary($model); ?>
    <table class="table table-striped">
        <tbody>
            <tr>
                <td width="50%"><?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?></td>
                <td width="50%"><?= $form->field($model, 'contact_mobile')->textInput(['maxlength' => true])->label("Contact No.") ?></td>
            </tr>
            <tr>
                <td><?= $form->field($model, 'address_line1')->textInput(['tabindex' => 6]) ?></td>
                <td><?= $form->field($model, 'address_line2')->textInput(['tabindex' => 6]) ?></td>
            </tr>
            <tr>
                <td><?= $form->field($model, 'postcode')->textInput(['tabindex' => 10]) ?></td>
                <td><?= $form->field($model, 'country_id')->dropDownList($country, ['prompt' => 'Select Any', 'tabindex' => 7]) ?></td>
            </tr>
            <tr>
                <td><?= $form->field($model, 'state_id')->dropDownList($states, ['prompt' => 'Select Any', 'tabindex' => 8]) ?></td>
                <td><?= $form->field($model, 'city_id')->dropDownList($cities, ['prompt' => 'Select Any', 'tabindex' => 9]) ?></td>
            </tr>
            <tr>
                <td>
                    <?= $form->field($model, 'twofa_enabled')->dropDownList(['1' => 'Yes', '0' => 'No'], ['class' => 'form-control'])->label("Two Factor Authentication") ?> <br/>
                    <div class="row">
                        <div class="col-md-3">Scan this image if you want to eanble "Two Factor Authentication" with your authenticator app.<br/></div>
                        <div class="col-md-9">
                            <?php
                            // first we need to create our time-based one time password secret uri
                            $totpUri = (new Da\TwoFA\Service\TOTPSecretKeyUriGeneratorService(Yii::$app->name, $model->user->email, $model->twofa_secret))->run();
                            $uri = (new Da\TwoFA\Service\QrCodeDataUriGeneratorService($totpUri))->run();
                            ?>
                            <img src="<?= $uri ?>" alt="" />
                        </div>
                    </div>
                </td>
                <td style="text-align: left">
                    <?= $form->field($model, 'image')->fileInput(['class' => 'form-control'])->label("Profile Image") ?><br/>
                    <?php
                    if ($model && $model->image != '') {
                        
                        echo Html::img(\yii\helpers\Url::to(['/images/profile/' . $model->image], true), ['class' => 'img-thumbnail', 'width' => 100]) . '<br/>';
                        
                    }
                    ?>
                </td>
            </tr>


        </tbody>
    </table>

    <div class="form-group">
        <?= "<div class='row'><div class='col-lg-2'></div><div class='col-lg-10'>"; ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <a href="<?= \yii\helpers\Url::to(['index'], true) ?>" class="btn btn-danger">Cancel</a>
        <?= "</div></div>"; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
