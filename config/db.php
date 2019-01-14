<?php

return [
    'class' => 'yii\db\Connection',
    'driverName' => 'pgsql',
    'dsn' => 'pgsql:host=localhost;port=5432;dbname=battleship',
    'username' => 'www-data',
    'password' => '5621',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
