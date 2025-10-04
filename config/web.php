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
        'pdf' => [
        'class' => '\Mpdf\Mpdf',
        'format' => 'A4',
        'orientation' => 'P',
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
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // 1. RUTAS ESPECÍFICAS DE USUARIO - DEBEN IR PRIMERO
                'usuario/view/<id:\d+>' => 'usuario/view',
                'usuario/update/<id:\d+>' => 'usuario/update',
                'mi-perfil' => 'usuario/view',
                'configuracion' => 'usuario/update',
                
                // 2. RUTAS ESPECÍFICAS DE OTROS MÓDULOS
                'alumno/buscar' => 'alumno/buscar',
                'alumno/generar-pdf' => 'alumno/generar-pdf',
                'alumno/verificar-documentos' => 'alumno/verificar-documentos',
                'alumno/validar/<id:\d+>' => 'alumno/validar',
                'alumno/asignar-revisores/<id:\d+>' => 'alumno/asignar-revisores',
                'alumno/generar-constancia/<id:\d+>' => 'alumno/generar-constancia',
                
                'documento-generado/generar' => 'documento-generado/generar',
                'documento-generado/ver-historia/<alumno_id:\d+>' => 'documento-generado/ver-historia',
                'documento-generado/<action:[\w-]+>/<id:\d+>' => 'documento-generado/<action>',
                'documento-generado/download/<id:\d+>' => 'documento-generado/download',
                
                // 3. REGLAS GENERALES - DEBEN IR AL FINAL
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

                'requisito/admin' => 'requisito/admin',
                'requisito/index' => 'requisito/index',
                'requisito/create' => 'requisito/create',
                ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
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