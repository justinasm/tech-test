<?php
return [
    'basePath'          => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'              => 'TECH-TEST',
    'homeUrl'           => ['main/index'],
    'defaultController' => 'main',
    'preload'           => [],
    'aliases'           => [],
    'import'            => [
        'application.models.*',
        'application.components.*',
        'application.components.fBase.models.*',
    ],
    'modules'           => [],
    'components'        => [
        'cache'        => [
            'class' => 'CFileCache',
        ],
        'urlManager'   => array(
            'urlFormat'      => 'path',
            'rules'          => [
                '<controller:\w+>/<id:\d+>'              => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
            ],
            'showScriptName' => false,
            'caseSensitive'  => false,
        ),
        'errorHandler' => [
            'errorAction' => 'main/error',
        ],
    ],
    'params'            => [],
];