<?php
$appStartTime = microtime(true);

$app = false;
$xmlObj = false;
$dbObj = false;
$__area = 'frontend';
$defaultAdminPath = 'admin';

define('DS', DIRECTORY_SEPARATOR);
$subDirectory = (($subDirectory = dirname($_SERVER['PHP_SELF'])) != "/") ? $subDirectory . "/" : "/";
define('_PROTOCOL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off") ? "https" : "http");
define('_BASEURL', _PROTOCOL . "://" . $_SERVER['HTTP_HOST'] . $subDirectory);
define('_BASEDIR', dirname(dirname(__FILE__)) . DS);
define('_APPDIR', dirname(__FILE__) . DS);

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

function setErrorReporting()
{
    if (_DEBUG_MODE) {
        error_reporting(E_ALL | E_STRICT);
        ini_set('display_errors', 1);
    } else {
        error_reporting(0);
        ini_set('display_errors', 0);
        ini_set('log_errors', 'On');
    }
}

function stripSlashesDeep($value)
{
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
}

function removeMagicQuotes()
{
    if (get_magic_quotes_gpc()) {
        $_GET = stripSlashesDeep($_GET);
        $_POST = stripSlashesDeep($_POST);
        $_COOKIE = stripSlashesDeep($_COOKIE);
    }
}

function slimMVCAutoloader($className)
{
    global $__area;
    if (file_exists(_BASEDIR . "lib/" . $className . ".php")) {
        include_once _BASEDIR . "lib/" . $className . ".php";
    } elseif (file_exists(_APPDIR . "/code/controllers/" . $__area . "/" . $className . ".php")) {
        include_once _APPDIR . "/code/controllers/" . $__area . "/" . $className . ".php";
    } elseif (file_exists(_APPDIR . "/code/models/" . $className . ".php")) {
        include_once _APPDIR . "/code/models/" . $className . ".php";
    } else {
        include_once _BASEDIR . "lib/Error.php";
        // $errorObj = new Error();
        // $errorObj->printError($className);
    }
}

spl_autoload_register('slimMVCAutoloader');

function _init()
{
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    removeMagicQuotes();
    setErrorReporting();
}

function run()
{
    global $__area, $app, $xmlObj, $dbObj;
    $model = false;
    _init();
    $xmlObj = new XMLParser();
    $xmlObj->configPrepare();
    date_default_timezone_set($xmlObj->getSystemTimeZone());
    $__area = $xmlObj->getConfig('default/area');
    $__module = $xmlObj->getConfig('default/frontend/module');
    $__action = $xmlObj->getConfig('default/frontend/function');
    $dbObj = new Model();

    $__appParams = array();
    $__resultData = array();
    if (isset($_GET['url_request'])) {
        $urlParams = @explode("/", $_GET['url_request']);
        if (isset($urlParams[0]) && $urlParams[0] != '') {
            $__module = $urlParams[0];
            array_shift($urlParams);
            if ($__module == $xmlObj::$adminRoutePath) {
                $__area = $xmlObj->getConfig('default/adminhtml/area');
                $__module = $xmlObj->getConfig('default/adminhtml/module');
                $__action = $xmlObj->getConfig('default/adminhtml/function');
                if (isset($urlParams[0]) && $urlParams[0] != '') {
                    $__module = $urlParams[0];
                    array_shift($urlParams);
                    if (isset($urlParams[0]) && $urlParams[0] != '') {
                        $__action = $urlParams[0];
                        array_shift($urlParams);
                    }
                }
            } else {
                $urlRewriteExist = $dbObj->checkUrlRewriteAvailable($__module);
                if (!count($urlRewriteExist)) {
                    if (isset($urlParams[0]) && $urlParams[0] != '') {
                        $__action = $urlParams[0];
                        array_shift($urlParams);
                    } else {
                        $__action = 'error404';
                    }
                } else {
                    $__module = $urlRewriteExist[0];
                    $__action = $urlRewriteExist[1];
                    array_shift($urlRewriteExist);
                    array_shift($urlRewriteExist);
                    $urlParams = array_merge($urlRewriteExist, $urlParams);
                }
            }
        }
        foreach ($urlParams as $key => $val) {
            if ($key % 2 == 0 && $val != '') {
                $__appParams['params'][$val] = @$urlParams[$key + 1];
            }
        }
        if (isset($_REQUEST)) {
            foreach ($_REQUEST as $key => $val) {
                $__appParams['params'][$key] = $val;
            }
        }
//        debug($__appParams);
    }
    session_start();
    session_name($__area);
    if (Utils::isInstalled()) {
        $_controllerClass = ucfirst($__module) . 'Controller';

        if (isset($_GET['url_request']) && !class_exists($_controllerClass)) {
            $userExist = $dbObj->checkUsernameExist($__module);
            if ($userExist) {
                $__module = 'users';
                $_controllerClass = ucfirst($__module) . 'Controller';
                $__action = "profileview";
                $__resultData['current_user'] = $userExist;
            } else {
                $__module = 'exception';
                $_controllerClass = ucfirst($__module) . 'Controller';
            }
        }
//		debug($__resultData);
        $app = new $_controllerClass();
        $action = $__action . "Action";
        if (!method_exists($app, $action)) {
            $__action = "error404";
            $action = $__action . "Action";
        }
        $handler = strtolower($__module . "_" . $__action);

        $app::$__area = $__area;
        $app->__module = $__module;
        $app->__action = $__action;
        $app->__appParams = $__appParams;
        $app->__resultData = $__resultData;

        $modelClass = ucfirst($__module);
        if ($modelClass != '' && class_exists($modelClass)) {
            $model = new $modelClass;
        }
        $app->template = $app;
        $app->model = $model;
        $app->_templateInit();
        $app->setBodyClass($handler);
        $app->addHandle($handler);
        $app->$action();
    } else {
        $__module = 'install';
        $__action = 'setup';
        $installer = new Installer();

        $handler = strtolower($__module . "_" . $__action);

        $installer::$__area = $__area;
        $installer->__module = $__module;
        $installer->__action = $__action;
        $installer->__appParams = $__appParams;
        $installer->__resultData = $__resultData;

        $modelClass = ucfirst($__module);
        if ($modelClass != '' && class_exists($modelClass)) {
            $model = new $modelClass;
        }
        $installer->template = $installer;
        $installer->model = $model;
        $installer->_templateInit();
        $installer->setBodyClass($handler);
        $installer->addHandle($handler);
        $installer->setup();
    }
}