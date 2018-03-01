<?php

$db = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=',
    'username' => '',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

$dbConfig = (file_exists(__DIR__ .'/db-local.php')) ?  require(__DIR__ .'/db-local.php') : $db;

return $dbConfig;
