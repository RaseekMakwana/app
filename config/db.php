<?php

if ($_SERVER['SERVER_NAME'] == 'app.gujaratparixa.com') {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=facebook_app_v1',
        'username' => 'facebook_app',
        'password' => 'snAqSW]C-zM*',
        'charset' => 'utf8',
    ];
} else if ($_SERVER['SERVER_NAME'] == 'demo.siliconithub.us') {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=demo',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ];
} else {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=app_v1',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ];
}
