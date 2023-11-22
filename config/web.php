<?php

Yii::setAlias('@themes', dirname(__DIR__) . '/web/themes');
$config = [
    'id' => 'yii2-baseframe-new',
    'name' => 'Baseframe New',
    'timeZone' => 'Asia/Calcutta',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'app\components\Settings'],
    'defaultRoute' => '/site/index',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'mainLayout' => '@themes/admin/views/layouts/main.php',
            'menus' => [
                /* 'assignment' => [
                  'label' => 'Grand Access' // change label
                  ], */
                //'route' => null, // disable menu route
                'user' => null
            ]
        ],
        'backend' => [
            'class' => 'app\modules\backend\backend',
        ],
    ],
    'container' => [
        'definitions' => [
            'yii\widgets\LinkPager' => [
                'firstPageLabel' => '<i class="fa fa-long-arrow-left"></i>',
                'lastPageLabel' => '<i class="fa fa-long-arrow-right"></i>',
                'nextPageLabel' => 'Next',
                'prevPageLabel' => 'Prev',
            ]
        ]
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@themes/frame/views',
                    '@app/modules' => '@themes/admin',
                    'baseUrl' => '@public_html',
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'GZQgOhkJ5phiedXFwlrtWkjkbU75hiWh',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'on afterLogin' => function ($event) {                
                $profile = \app\models\Userprofile::findOne(['user_id' => $event->identity->id]);
                //echo "<pre>";print_r($profile);exit;
                if ($profile->twofa_secret == '' || $profile->twofa_secret == "NULL") {
                    $twoFA = (new \Da\TwoFA\Manager())->generateSecretKey();                    
                    Yii::$app->db->createCommand("UPDATE `userprofile` SET twofa_secret = '" . $twoFA . "' WHERE `user_id` = '" . $event->identity->id . "'")->execute();
                }
            }
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //'/news' => 'site/news',
                '/contact' => 'site/contact',
                '/signup' => 'site/signup',
                '/login' => 'site/login',
                '/logout' => 'site/logout',
                '/pages/<category>/<alias>' => 'site/page',
            /* '<category:\w+>/<subcategory:\w+>/<alias>' => 'site/page',
              '<category:\w+>/<subcategory:\w+>/<sub2category:\w+>/<alias>' => 'site/page',
              '<category:\w+>/<subcategory:\w+>/<sub2category:\w+>/<sub3category:\w+>/<alias>' => 'site/page',
              '<category:\w+>/<subcategory:\w+>/<sub2category:\w+>/<sub3category:\w+>/<sub4category:\w+>/<alias>' => 'site/page',
              '<category:\w+>/<subcategory:\w+>/<sub2category:\w+>/<sub3category:\w+>/<sub4category:\w+>/<sub5category:\w+>/<alias>' => 'site/page', */
            ],
        ],
        'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true,
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*', // add or remove allowed actions to this list            
            'debug/*',
            'gii/*'
        ]
    ],
];
//var_dump($_SERVER['REMOTE_ADDR']);
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment    
    /* $config['bootstrap'][] = 'debug';
      $config['modules']['debug'] = [
      'class' => 'yii\debug\Module',
      // uncomment the following to add your IP if you are not connecting from localhost.
      'allowedIPs' => ['127.0.0.1', '::1', '172.16.238.1'],
      ]; */

    /* $config['bootstrap'][] = 'gii';
      $config['modules']['gii'] = [
      'class' => 'yii\gii\Module',
      // uncomment the following to add your IP if you are not connecting from localhost.
      'allowedIPs' => ['127.0.0.1', '::1', '172.16.238.1'],
      ]; */
    $config['components']['assetManager']['forceCopy'] = true;

    $config['components']['mailer'] = require(__DIR__ . '/mailer.php');
    $config['components']['db'] = require(__DIR__ . '/db.php');
    $config['params'] = require(__DIR__ . '/params.php');
    $config['components']['reCaptcha'] = require(__DIR__ . '/recaptcha.php');
} else {

    $config['components']['mailer'] = require(__DIR__ . '/live_mailer.php');
    $config['components']['db'] = require(__DIR__ . '/live_db.php');
    $config['components']['reCaptcha'] = require(__DIR__ . '/live_recaptcha.php');
    $config['params'] = require(__DIR__ . '/params.php');
}

return $config;
