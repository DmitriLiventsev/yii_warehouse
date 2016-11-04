<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'r4MpJcwAbiD7cKVzzr8gtWoi7ysQUVOe',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\UserIdentity',
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

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['pattern' => 'product/create', 'route'=>'product/create', 'verb' => 'GET'],
                ['pattern' => 'product/create', 'route'=>'product/add', 'verb' => 'POST'],
                ['pattern' => 'product/update', 'route'=>'product/update', 'verb' => 'GET'],
                ['pattern' => 'product/update', 'route'=>'product/edit', 'verb' => 'POST'], #With PUT routing is not working, and always use GET rule %(

                ['pattern' => 'category/create', 'route'=>'category/create', 'verb' => 'GET'],
                ['pattern' => 'category/create', 'route'=>'category/add', 'verb' => 'POST'],
                ['pattern' => 'category/update', 'route'=>'category/update', 'verb' => 'GET'],
                ['pattern' => 'category/update', 'route'=>'category/edit', 'verb' => 'POST'], #With PUT routing is not working, and always use GET rule %(
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
