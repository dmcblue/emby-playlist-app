<?php

require_once 'vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$db_adapter = getenv('DB_ADAPTER') === false ? die('Missing .env variable "DB_ADAPTER"') : getenv('DB_ADAPTER');
$db_dsn = getenv('DB_DSN') === false ? die('Missing .env variable "DB_DSN"') : getenv('DB_DSN');
$db_username = getenv('DB_USER') === false ? die('Missing .env variable "DB_USER"') : getenv('DB_USER');
$db_password = getenv('DB_PASSWORD') === false ? die('Missing .env variable "DB_PASSWORD"') : getenv('DB_PASSWORD');
$db_charset = getenv('DB_CHARSET') === false ? 'utf8mb4' : getenv('DB_CHARSET');


$config = [
    'propel' => [
        'paths' => [
            // The directory where Propel expects to find your `schema.xml` file.
            'schemaDir' => 'c:\www\personal\emby-playlist-app',

            // The directory where Propel should output generated object model classes.
            'phpDir' => 'c:\www\personal\emby-playlist-app\src',
        ],
        'database' => [
            'connections' => [
                'default' => [
                    'adapter' => $db_adapter,
                    'dsn' => $db_dsn,
                    'user' => $db_username,
                    'password' => $db_password,
                    'settings' => [
                        'charset' => $db_charset
                    ]
                ]
            ]
        ],
        'generator' => [
            'schema' => [
                'autoPackage' => true
            ]
        ]
    ]
];
// var_dump($config);
return $config;
