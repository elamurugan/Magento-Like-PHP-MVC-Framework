<?php
$app_start_time = microtime(true);
define('DEBUG_MODE', true);
define('PRINT_MEMORY_USAGE', false);

if (DEBUG_MODE) {
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 'On');
}

define("_HOST", "localhost");
define("_USERNAME", "root");
define("_PASSWORD", '');
define("_DBNAME", "sample_db");
define("_TIME_ZONE", "Asia/Kolkata");
date_default_timezone_set(_TIME_ZONE);

$app = $dbObj = $modelObj = false;
$_app_params = $url_params = array();
$_app_params['config']['site_title'] = $_app_params['config']['site_meta_keywords'] = $_app_params['config']['site_meta_description'] = "Ems";
$_app_params['config']['frontend']['theme'] = "default";
$_app_params['config']['adminhtml']['theme'] = "default";
$_app_params['config']['skin_path'] = _SKIN;

$sub_directory = dirname($_SERVER['PHP_SELF']) != "/" ? dirname($_SERVER['PHP_SELF']) . "/" : "" . "/";
define('DS', DIRECTORY_SEPARATOR);
define('_PROTOCOL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off") ? "https" : "http");
define('_BASEURL', _PROTOCOL . "://" . $_SERVER['HTTP_HOST'] . $sub_directory);
define('_BASEDIR', dirname(dirname(__FILE__)) . "/");

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


function slim_mvc_autoloader($className)
{
    global $_area;
    if (file_exists(_BASEDIR . _APP . "/code/controllers/" . $_area . "/" . $className . ".php")) {
        include_once _BASEDIR . _APP . "/code/controllers/" . $_area . "/" . $className . ".php";
    } elseif (file_exists(_BASEDIR . _APP . "/code/models/" . $className . ".php")) {
        include_once _BASEDIR . _APP . "/code/models/" . $className . ".php";
    } elseif (file_exists(_BASEDIR . "lib/" . $className . ".php")) {
        include_once _BASEDIR . "lib/" . $className . ".php";
    } else {
        include_once _BASEDIR . "lib/Error.php";
        Error::exception($className);
    }
}

spl_autoload_register('slim_mvc_autoloader');

$module = "page"; // Default module
$function = "index"; // Default action
$_area = "frontend"; // Is it for frontend or admin template/skin

// Global Js,css files for frontend and admin - can convert this into xml or json
$globalJsFiles['frontend'] = array("js/lib/jquery-1.9.1.min.js", "js/lib/bootstrap.js", "js/scripts.js");
$globalCssFiles['frontend'] = array("css/bootstrap.css", "css/dropzone.css", "css/jquery-te-1.4.0.css", "css/custom.css");

$globalJsFiles['adminhtml'] = array("js/lib/jquery-1.9.1.min.js", "js/scripts.js");
$globalCssFiles['adminhtml'] = array("css/bootstrap.css", "css/custom.css");

// SEO friendly URL Rewrites - can make it into Db
$url_rewrites = array(
    "about-us"   => "page/about",
    "contact-us" => "page/contact",
);




function run(){
	$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	global $app,$_app_params,$module,$function,$_area,$url_rewrites,$modelObj,$dbObj;
	$modelObj = $dbObj = new Model();
	// Routing process
	if (isset($_GET['url_request'])) {
		$url_params = @explode("/", $_GET['url_request']);
		if (isset($url_params[0]) && $url_params[0] != '') {
			$module = $url_params[0];
			array_shift($url_params);
			if ($module == _ADMIN_ROUTE_URL) {
				$_area = "adminhtml";
				$function = 'login';//default
				if (isset($url_params[0]) && $url_params[0] != '') {
					$module = $url_params[0];
					array_shift($url_params);
					if (isset($url_params[0]) && $url_params[0] != '') {
						$function = $url_params[0];
						array_shift($url_params);
					}
				}
			} elseif (isset($url_rewrites[$module])) {
				$url_rewrite_params = @explode("/", $url_rewrites[$module]);
				$module = $url_rewrite_params[0];
				$function = $url_rewrite_params[1];
			} else {
				if (isset($url_params[0]) && $url_params[0] != '') {
					$function = $url_params[0];
					array_shift($url_params);
				} else {
					$function = 'error404';
				}
			}
		}
		foreach ($url_params as $key => $val) {
			if ($key % 2 == 0 && $val != '') {
				$_app_params['params'][$val] = @$url_params[$key + 1];
			}
		}
		if (isset($_REQUEST)) {
			foreach ($_REQUEST as $key => $val) {
				$_app_params['params'][$key] = $val;
			}
		}
	}

	session_start();
	session_name($_area);
	$module = $model = ucfirst($module);
	$module_class = $module . 'Controller';

	if (isset($_GET['url_request'])) {
		if (!class_exists($module_class)) {
			$user_exist = $dbObj->checkUsernameExist($module);
			if ($user_exist) {
				$model = $module = 'Users';
				$module_class = $module . 'Controller';
				$function = "profileview";
				$_app_params['current_user'] = $user_exist;
			} else {
				$module_class = $module = $model = 'Error';
			}
		}
	}

	$app = new $module_class();
	$action = $function . 'Action';
	if (!method_exists($app, $action)) {
		$function = "error404";
		$action = "error404Action";
	}
	$_app_params['config']['module'] = strtolower($module);
	$_app_params['config']['model'] = $model;
	$_app_params['config']['function'] = $function;
	$_app_params['config']['action'] = $action;
	$_app_params['config']['area'] = $_area;
	$_app_params['config']['body_class'] = strtolower($module . "_" . $function);
	if ($model != '' && class_exists($model)) {
		$modelObj = new $model;
	}
}
run();