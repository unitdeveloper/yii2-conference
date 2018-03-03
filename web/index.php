<?php

use codemix\yii2confload\Config;

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
Config::initEnv(__DIR__.'/../');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();