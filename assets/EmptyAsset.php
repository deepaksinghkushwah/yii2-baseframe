<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class EmptyAsset extends AssetBundle
{
    public $basePath = '@web/themes/frame';
    public $baseUrl = '@web';
    public $css = [
        '/css/fontawesome/css/font-awesome.min.css',
        '/css/bootstrap-social.css',
        'themes/frame/views/files/css/site.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
