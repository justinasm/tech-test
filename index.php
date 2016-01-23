<?php
require_once(__DIR__ . '/protected/helpers/globals.php');
require_once(__DIR__ . '/protected/helpers/slug.php');
// change the following paths if necessary
$yii=dirname(__FILE__).'/vendor/yiisoft/yii/framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
$loader = require(__DIR__ . '/vendor/autoload.php');
Yii::$classMap = $loader->getClassMap();
Yii::createWebApplication($config)->run();
