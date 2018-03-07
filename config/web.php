<?php

use \codemix\yii2confload\Config;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'language' => 'uk-UA',
    'sourceLanguage' => 'uk-UA',
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'name' => 'Актуальні проблеми автоматизації та управління',
    'bootstrap' => ['log', 'queue'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@yiister/gentelella/assets/src' => __DIR__.'/../vendor/yiister/yii2-gentelella/assets/src',
    ],
    'components' => [
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
            'redis' => 'redis', // Компонент подключения к Redis или его конфиг
            'channel' => 'queue', // Ключ канала очереди
        ],
        'converter'=>[
            'class' => 'app\components\Converter'
        ],
        'config'=>[
            'class' => 'app\components\DConfig'
        ],
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD',  //GD or Imagick
        ],
        'request' => [
            'baseUrl'=> '',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'WjltwNDx7pO2l-UYAywhNVz8SlZLjKbZ',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => Config::env('TRANSPORT_CLASS', 'class'),
                'host' => Config::env('TRANSPORT_HOST', 'host'),
                'username' => Config::env('TRANSPORT_USERNAME', 'username'),
                'password'=> Config::env('TRANSPORT_PASSWORD', 'password'),
                'port' => Config::env('TRANSPORT_PORT', 'port'),
                'encryption' => Config::env('TRANSPORT_ENCRYPTION', 'encryption'),
            ],
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
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
//                '<_a:error>' => 'site/<_a>',
//                '<_a:(admin|test|captcha|about|contact|login|logout|signup|email-confirm|password-reset-request|password-reset)>' => 'site/<_a>',
//                '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/<_a>',
//                '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/view',
//                '<_m:[\w\-]+>' => '<_m>/site/index',
//                '<_m:[\w\-]+>/<_c:[\w\-]+>' => '<_m>/<_c>/index',
//                'about' => 'site/about',
//                'login' => 'site/login',
//                'catalog' => 'catalog/index',
            ],
        ],

    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
