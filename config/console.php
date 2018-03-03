<?php

use codemix\yii2confload\Config;

Config::initEnv('/home/max/dev/diplom_git/');

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'name' => 'Актуальні проблеми автоматизації та управління',
    'bootstrap' => ['log', 'queue'],
    'controllerNamespace' => 'app\commands',
    'components' => [
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
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'config'=>[
            'class' => 'app\components\DConfig'
        ],
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
            'redis' => 'redis', // Компонент подключения к Redis или его конфиг
            'channel' => 'queue', // Ключ канала очереди
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
