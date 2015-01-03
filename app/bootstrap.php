<?php
$app_start_time = microtime(true);
$app = $_area = $action = $module = false;
define('DS', DIRECTORY_SEPARATOR);
$subDirectory = (($subDirectory = dirname($_SERVER['PHP_SELF'])) != "/") ? $subDirectory . "/" : "/";
define('_PROTOCOL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off") ? "https" : "http");
define('_BASEURL', _PROTOCOL . "://" . $_SERVER['HTTP_HOST'] . $subDirectory);
define('_BASEDIR', dirname(dirname(__FILE__)) . DS);
define('_APPDIR', dirname(__FILE__) . DS);

define('DEBUG_MODE', true);
define('PRINT_MEMORY_USAGE', false);

function debug($data, $die = 0, $option = 1)
{
    echo "<br/><pre style='padding:4px 5px;background: none repeat scroll 0 0 #303030; clear: both;color: #FFFFFF;float: left;font-family: Times New Roman;text-align: left;font-size:15px;'>";
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

function setErrorReporting()
{
    if (DEBUG_MODE) {
        error_reporting(E_ALL | E_STRICT);
        ini_set('display_errors', 1);
    } else {
        error_reporting(0);
        ini_set('display_errors', 0);
        ini_set('log_errors', 'On');
    }
}

function slimMVCAutoloader($className)
{
    global $_area;
    if (file_exists(_APPDIR . "/code/controllers/" . $_area . "/" . $className . ".php")) {
        include_once _APPDIR . "/code/controllers/" . $_area . "/" . $className . ".php";
    } elseif (file_exists(_APPDIR . "/code/models/" . $className . ".php")) {
        include_once _APPDIR . "/code/models/" . $className . ".php";
    } elseif (file_exists(_BASEDIR . "lib/" . $className . ".php")) {
        include_once _BASEDIR . "lib/" . $className . ".php";
    } else {
        include_once _BASEDIR . "lib/Error.php";
        Error::printError($className);
    }
}

spl_autoload_register('slimMVCAutoloader');
setErrorReporting();