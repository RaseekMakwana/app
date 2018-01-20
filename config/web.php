<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'Demo',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'pages/index',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '3Vf9jfTexBvemyy9v-X8cUEKIO723tlu',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Users',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_frontendUser', // unique for frontend
            ],
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
        'db' => require(__DIR__ . '/db.php'),
        ///*
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'canapp' => 'canvas/app',
                'html_generate' => 'canvas/html_generate',
                'canvas_images_save' => 'canvas/canvas_images_save',
                'share_post' => 'sharemaster/index',
                'fb_login_generate' => 'canvas/login_status',
                
                
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'common' => [
            'class' => 'app\components\Common',
        ],
        'resize' => [
            'class' => 'app\components\Resize',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
                    'clientId' => '727081760799378',
                    'clientSecret' => '0e11e28d03b71fe3a0063f53e4368c7f',
                    'attributeNames' => ['name', 'email', 'first_name', 'last_name'],
                ],
            ],
        ],
    //*/
    ],
    'params' => $params,
];

$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
if (strpos($url, 'admin') !== false) {
    $config['components']['user'] = [
        'identityClass' => 'app\models\Admin',
        'enableAutoLogin' => true,
        'identityCookie' => [
            'name' => '_backendUser', // unique for frontend
        ],
    ];
}

if (YII_ENV_DEV) {

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;

