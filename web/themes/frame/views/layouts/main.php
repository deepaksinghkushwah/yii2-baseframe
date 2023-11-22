<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\debug\Toolbar;

/* @var $this yii\web\View */
\app\assets\FrameAsset::register($this);
app\components\ThemeWidget::widget();

$mainDivWidth = 12;
$leftDivWidth = 0;
$rightDivWidth = 0;
$leftMenu = \app\models\Menu::findOne(['location' => 'left', 'status' => 1]);
$rightMenu = \app\models\Menu::findOne(['location' => 'right', 'status' => 1]);
if ($leftMenu && !$rightMenu) {
    $mainDivWidth = 10;
    $leftDivWidth = 2;
} elseif ($rightMenu && !$leftMenu) {
    $mainDivWidth = 10;
    $rightDivWidth = 2;
} elseif ($leftMenu && $rightMenu) {
    $mainDivWidth = 8;
    $leftDivWidth = 2;
    $rightDivWidth = 2;
} else {
    $mainDivWidth = 12;
    $leftDivWidth = 0;
    $rightDivWidth = 0;
}
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
        <title><?php echo Html::encode($this->title); ?></title>
        <?= Html::csrfMetaTags() ?>
        <meta property='og:site_name' content='<?php echo Html::encode($this->title); ?>' />
        <meta property='og:title' content='<?php echo Html::encode($this->title); ?>' />
        <meta property='og:description' content='<?php echo Html::encode($this->title); ?>' />


        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php $this->head(); ?>                        
    </head>

    <body>
        <?php $this->beginBody(); ?>

        <?php include(dirname(__FILE__) . '/menu.php'); ?>
        <div class="<?= $leftMenu || $rightMenu ? 'container-fluid' : 'container' ?>">
            <div class="row">
                <?= $leftMenu ? '<div class="col-md-' . $leftDivWidth . '">' . \app\components\MenuWidget::widget(['location' => 'left']) . '</div>' : ''; ?>

                <div class="col-md-<?= $mainDivWidth ?>">
                    <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) { ?>
                        <div class="alert alert-<?php echo $key; ?> ">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php
                            if (is_array($message)) {
                                foreach ($message as $row) {
                                    echo $row . "<Br/>";
                                }
                            } else {
                                echo $message;
                            }
                            ?>                            

                        </div>
                        <?php
                    }
                    ?>
                    <?php echo $content; ?>
                </div>
                <?= $rightMenu ? '<div class="col-md-' . $rightDivWidth . '">' . \app\components\MenuWidget::widget(['location' => 'right']) . '</div>' : ''; ?>
            </div>

        </div>



        <footer class="footer">

            <div class="panel">
                <div class="panel-body">



                    <?php
                    $footMenu = \app\models\Menu::findOne(['location' => 'bottom', 'status' => 1]);
                    if ($footMenu) {
                        ?>
                        <div class="<?= $leftMenu || $rightMenu ? 'container-fluid' : 'container' ?>">
                            <div class="row">
                                <?= \app\components\MenuWidget::widget(['location' => 'bottom', 'bottomMenuWidth' => ($leftMenu || $rightMenu ? 3 : 4)]); ?>
                            </div>
                        </div>

                        <?php
                    }
                    ?>






                    <div class="copyright text-center">
                        &copy; <?= Yii::$app->params['settings']['application_name']; ?><sup>&reg;</sup> <?= date('Y') ?>    
                        <div>
                            <?= Html::a('Privacy & Policy', \yii\helpers\Url::to(['/pages/system/privacy-policy'], true)); ?>
                            | <?= Html::a('Terms & Conditions', \yii\helpers\Url::to(['/pages/system/terms-and-conditions'], true)); ?>
                            | Powered By: YII v<?= Yii::getVersion(); ?>
                        </div>
                    </div>
                </div>

            </div>




        </footer>
        <div class="loading-gif" style="display: none;"><?= Html::img(yii\helpers\Url::to(['/images/loader.gif'], true)) ?></div>
        <?php $this->endBody(); ?>

    </body>
</html>
<?php $this->endPage(); ?>