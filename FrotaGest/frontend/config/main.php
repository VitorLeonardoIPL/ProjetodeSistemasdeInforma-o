<?php

declare(strict_types=1);

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php',
);

return [
    'id' => 'app-frontend',
    'name' => 'FrotaGest',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => \common\models\User::class,
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        //gestor de assets: aqui podemos alterar bundles que vem do Yii
        'assetManager' => [
            'bundles' => [
                //sempre que alguem pedir o BootstrapAsset (o AppAsset, o ActiveForm, ...),
                //o Yii usa o bootstrap.min.css personalizado do template Cental
                \yii\bootstrap5\BootstrapAsset::class => [
                    //nao copiar do vendor/; o ficheiro ja esta em frontend/web
                    'sourcePath' => null,
                    //pasta no disco e URL onde esta o ficheiro (ambos = frontend/web)
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    //o CSS a carregar em vez do bootstrap.css do Yii
                    'css' => ['css/bootstrap.min.css'],
                ],
            ],
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
