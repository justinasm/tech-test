<?php
return [
    'basePath'   => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'       => 'TECH-TEST',
    'homeUrl'    => ['main/index'],
    'preload'    => [],
    'aliases'    => [],
    'import'     => [
        'application.models.*',
        'application.components.*',
    ],
    'modules'    => [],
    'components' => [
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
        'errorHandler' => array(
            'errorAction' => 'main/error',
        ),
    ],
    'params'     => [],
];