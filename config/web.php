<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '23v52qb235vq2c54',
            'baseUrl' => ''
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Users',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => '<username>@<yourDomain>',
                'password' => '<userPassword>',
                'port' => 465,
                'encryption' => 'ssl',
            ],
            'useFileTransport' => false,
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
            'enableStrictParsing' => true,
            'rules' => [
                //роуты основной навигации
                '/' => 'site/index',
                'add' => 'site/add',
                 //todo почистить роуты, но перед этим посмотеть основной контроллер
                '<action:about|contact|feedback|data|addAdmin>' => 'site/<action>',
                //роуты регистрации и авторизации пользоватлелей
                'login' => 'uauth/login',
                'signup' => 'uauth/signup',
                'logout' => 'uauth/logout',

                //роуты  для работы с постами
                'CreatePost'=>'posts/create-post',
                'setImage' => 'posts/set-image',
                'GetPost'=>'posts/get-post',
                //todo убрать, когда комитить
                'ptest' => 'posts/ptest',
                'GetAllPosts' => 'posts/get-all-posts'

            ]
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable'       => 'auth_item',
            'itemChildTable'  => 'auth_item_child',
            'assignmentTable' => 'auth_assignment',
            'ruleTable'       => 'auth_rule',
            'defaultRoles'    => ['guest'],
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
