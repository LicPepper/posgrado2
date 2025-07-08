<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Sistema de Documentos de Posgrado',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'es-MX',
    'timeZone' => 'America/Mexico_City',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'tu_clave_secreta_aqui',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'tucorreo@itvh.edu.mx',
                'password' => 'tucontraseña',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'categories' => ['application'],
                    'logFile' => '@runtime/logs/app.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                ],
            ],
        ],
        'formatter' => [
            'dateFormat' => 'dd/MM/yyyy',
            'datetimeFormat' => 'dd/MM/yyyy HH:mm:ss',
            'decimalSeparator' => '.',
            'thousandSeparator' => ',',
            'currencyCode' => 'MXN',
            'locale' => 'es_MX',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap5\BootstrapAsset' => [
                    'css' => ['https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css']
                ],
                'yii\bootstrap5\BootstrapPluginAsset' => [
                    'js' => ['https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js']
                ],
            ],
            'appendTimestamp' => true,
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                // Documentos generados
                'documento-generado/generar' => 'documento-generado/generar',
                'documento-generado/ver-historia/<alumno_id:\d+>' => 'documento-generado/ver-historia',
                'documento-generado/<action:[\w-]+>/<id:\d+>' => 'documento-generado/<action>',
                'documento-generado/download/<id:\d+>' => 'documento-generado/download',
                
                // Alumnos
                'alumno/buscar' => 'alumno/buscar',
                'alumno/generar-pdf' => 'alumno/generar-pdf',
                'alumno/validar/<id:\d+>' => 'alumno/validar',
                'alumno/<action:[\w-]+>' => 'alumno/<action>',
                'alumno/<action:[\w-]+>/<id:\d+>' => 'alumno/<action>',
                
                // API REST
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'api/alumno',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET search' => 'search',
                    ]
                ],
                
                // Reglas generales
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'response' => [
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
    ],
    'modules' => [
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*'],
        'generators' => [
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'adminlte' => '@vendor/dmstr/yii2-adminlte-asset/gii/templates/crud/simple',
                ]
            ]
        ],
    ];
}

return $config;