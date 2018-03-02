<?php

use codemix\yii2confload\Config;

return [
    'class' => 'yii\db\Connection',
    'dsn' => Config::env('DB_DSN', 'mysql:host=db;dbname=web'),
    'username' => Config::env('DB_USER', 'web'),
    'password' => Config::env('DB_PASSWORD', 'web'),
    'charset' => Config::env('DB_CHARSET','utf8'),

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
