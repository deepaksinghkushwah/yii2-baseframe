<?php
if ($pageModel->allow_rating == 1 && isset(Yii::$app->user->id)) {
    $rating = app\components\PageHelper::getPageRating($pageModel->id)
    ?>
    <h4>Rating <span class="badge"><?= 'User(s): ' . $rating['totalNumberOfUsers']; ?></span><Br/><?= $rating['img']; ?></h4>
    <span class="help-block">Rate from 1 (poor) to 10 (excellent)</span>
    <div class="row">
        <div class="col-md-5">
            <div class=" panel panel-default">
                <div class="panel-body">
                    <?php
                    $form = \yii\widgets\ActiveForm::begin(['id' => 'rating-form', 'enableAjaxValidation' => true,]);
                    echo $form->field($newRatingModel, 'page_id', ['template' => '{input}'])->hiddenInput(['value' => $pageModel->id]);
                    for ($i = 0; $i <= 10; $i++) {
                        $option[$i] = $i;
                    }
                    //echo $form->field($newRatingModel, 'rating', ['template' => '{input}'])->radioList($option, ['value' => '0']);
                    echo $form->field($newRatingModel, 'rating')->widget(\kartik\rating\StarRating::classname(), [
                        'pluginOptions' => [
                            //'size' => 'lg',
                            'showClear' => false,
                            'showCaption' => false,
                            'stars' => 10,
                            'step' => 1,
                            'min' => 0,
                            'max' => 10
                        ]
                    ]);
                    //echo yii\helpers\Html::submitButton('Rate', ['class' => 'btn btn-primary btn-xs']);
                    \yii\widgets\ActiveForm::end();
                    ?>
                </div>
            </div>
        </div>        
    </div>
    <p></p>
    <hr/>
    <?php
}

