<?php

global $defaultParams;

if (file_exists(__DIR__.'/../config/server.local.php')) {
    $defaultParams = require_once(__DIR__.'/../config/server.local.php');
} else {
    $defaultParams = require_once(__DIR__.'/../config/server.default.php');
}

/*
 * Get global variable from server if exists.
 * Otherwise returns value from protected/config/server.default.php
 * @var parameter string
 * @var default string
 * @return string
 */
function serverConfig($parameter, $default = null)
{
    global $defaultParams;

    if (!is_string($parameter)) {
        $parameter = (string) $parameter;
    }

    if (isset($_SERVER[$parameter])) {
        $paramValue = $_SERVER[$parameter];
    } else {
        $paramValue = $defaultParams[$parameter];
    }

    return $paramValue;
}