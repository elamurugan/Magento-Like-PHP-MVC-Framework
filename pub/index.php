<?php

$appStartTime = microtime(true);
define('DS', DIRECTORY_SEPARATOR);
$subDirectory = (($subDirectory = dirname($_SERVER['PHP_SELF'])) != "/") ? $subDirectory . "/" : "/";
define('_PROTOCOL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off") ? "https" : "http");
define('_BASEURL', _PROTOCOL . "://" . $_SERVER['HTTP_HOST'] . $subDirectory);
define('_PUBDIR', dirname(__FILE__) . DS);
define('_BASEDIR', dirname(_PUBDIR) . DS);
define('_APPDIR', _BASEDIR . "app" . DS);

define('_DEBUG_MODE', true);

function debug($data, $die = 0, $option = 1)
{
    echo "<br/><pre style='padding:4px 5px;background: none repeat scroll 0 0 #3f633f; clear: both;color: #FFFFFF;float: left;font-family: Times New Roman;text-align: left;font-size:15px;'>";
    if ($option == 0) {
        var_dump($data);
    } else {
        print_r($data);
    }
    echo "</pre>";
    if ($die == 1) {
        die();
    }
}
include_once "../vendor/autoload.php";

include_once "../lib/Config.php";
include_once "../app/Slim.php";
$slimApp = new Slim();
$slimApp->run();