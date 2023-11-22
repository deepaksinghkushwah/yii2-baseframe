<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/frontend/signup.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
echo Html::hiddenInput("getCountyUrl", yii\helpers\Url::to(['/site/get-counties'], true), ['id' => 'getCountyUrl']);
echo Html::hiddenInput("getCityUrl", yii\helpers\Url::to(['/site/get-cities'], true), ['id' => 'getCityUrl']);

if ($profile->isNewRecord) {
    $country = yii\helpers\ArrayHelper::map(\app\models\GeoCountry::find()->all(), 'id', 'name');
    $states = [];
    $cities = [];
} else {
    $country = yii\helpers\ArrayHelper::map(\app\models\GeoCountry::find()->all(), 'id', 'name');
    $states = yii\helpers\ArrayHelper::map(\app\models\GeoState::find()->where("country_id = '" . $profile->country_id . "'")->all(), 'id', 'name');
    $cities = yii\helpers\ArrayHelper::map(\app\models\GeoCity::find()->where("state_id = '" . $profile->state_id . "'")->all(), 'id', 'name');
}
?>

<div class="user-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'signup-create-form',
                'options' => ['enctype' => 'multipart/form-data'],
                    /* 'fieldConfig' => [
                      'template' => "<div class='row'>"
                      . "<div class='col-md-2'>"
                      . "{label}&nbsp;"
                      . "</div>"
                      . "<div class='col-md-10'>"
                      . "{input}{error}"
                      . "</div>"
                      . "</div>",
                      ] */
    ]);
    ?>

    <?= $form->errorSummary([$model, $profile]); ?>


    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'username')->textInput(['tabindex' => 1]) ?>
            <?= $form->field($model, 'email')->textInput(['tabindex' => 3]) ?>        
            <?php if ($profile->isNewRecord) { ?>
                <?= $form->field($model, 'password')->passwordInput(['tabindex' => 5]); ?>     
            
            
            <?php } ?>



<div class="form-group field-userprofile-roles">
                <label class="control-label" for="userprofile-country_id">Roles</label><br>
                <?php
                $roles = app\components\GeneralHelper::getAllRoles();
                foreach ($roles as $rolename => $val) {
                    $isChecked = false;
                    if(!Yii::$app->user->isGuest){
                        $userRoles = app\components\GeneralHelper::getUserRole($profile->user_id);
                        if(in_array($rolename, $userRoles)){
                            $isChecked = true;
                        }
                    } 
                    ?>
                    <input <?=$isChecked == true ? 'checked="checked"' : ''?> 
                        type="checkbox" 
                        name="Userprofile[roles][]" 
                        value="<?=$rolename?>"/> <?= $rolename ?>
                    <?php
                    $isChecked = false;
                }
                ?>
            </div>


            

            <?= $form->field($profile, 'country_id')->dropDownList($country, ['prompt' => 'Select Any', 'tabindex' => 7]) ?>
            <?= $form->field($profile, 'state_id')->dropDownList($states, ['prompt' => 'Select Any', 'tabindex' => 8]) ?>
            <?= $form->field($profile, 'city_id')->dropDownList($cities, ['prompt' => 'Select Any', 'tabindex' => 9]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($profile, 'fullname')->textInput(['tabindex' => 2]) ?>
            <?= $form->field($profile, 'contact_mobile')->textInput(['tabindex' => 4]) ?>
            <?= $form->field($profile, 'address_line1')->textInput(['tabindex' => 6]) ?>
            <?= $form->field($profile, 'address_line2')->textInput(['tabindex' => 6]) ?>
            <?= $form->field($profile, 'postcode')->textInput(['tabindex' => 10]) ?>

            <?= $form->field($profile, 'image')->fileInput(['class' => 'form-control', 'tabindex' => 12]) ?>
            <?php
            if ($profile && $profile->image != '') {
                echo "<div class='row'><div class='col-lg-2'></div><div class='col-lg-10'>";
                echo Html::img(\yii\helpers\Url::to(['/images/profile/' . $profile->image], true), ['class' => 'img-thumbnail', 'width' => 100]) . '<br/><br/>';
                echo "</div></div>";
            }
            ?>
        </div>
    </div>


    <div class="form-group">
        <?= "<div class='row'><div class='col-lg-2'></div><div class='col-lg-10'>"; ?>
        <?= Html::submitButton($profile->isNewRecord ? 'Create' : 'Update', ['class' => $profile->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'tabindex' => 13]) ?>
        <?= Html::button('Cancel', ['class' => 'btn btn-danger', 'onclick' => 'window.location.href="' . \yii\helpers\Url::to(['/backend/user/index'], true) . '"']) ?>
        <?= "</div></div>"; ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
