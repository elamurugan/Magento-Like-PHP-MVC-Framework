<?php
$app_start_time = microtime(true);
define('DEBUG_MODE', true);
define('PRINT_MEMORY_USAGE',false);

if(DEBUG_MODE){
	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', 1);
}
else{
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

$_app_params   = $url_params    =  array();
$_app_params['config']['site_title'] = $_app_params['config']['site_meta_keywords'] = $_app_params['config']['site_meta_description'] = "Ems";
$_app_params['config']['frontend']['theme'] = "default";
$_app_params['config']['adminhtml']['theme'] = "default";
$_app_params['config']['skin_path'] = _SKIN;

$sub_directory = dirname($_SERVER['PHP_SELF']) != "/" ? dirname($_SERVER['PHP_SELF']) . "/" : "" . "/";
define('DS', DIRECTORY_SEPARATOR);
define('_PROTOCOL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off") ? "https" : "http");
define('_BASEURL', _PROTOCOL . "://" . $_SERVER['HTTP_HOST'] . $sub_directory);
define('_BASEDIR', dirname(dirname(__FILE__)) . "/");
				
function debug($data, $die = 0, $option = 1) {
    echo "<br/><pre style='padding:4px 5px;background: none repeat scroll 0 0 #303030; clear: both;color: #FFFFFF;float: left;font-family: Times New Roman;text-align: left;font-size:15px;'>";
    if ($option == 0)
        var_dump($data);
    else
        print_r($data);
    echo"</pre>";
    if ($die == 1) die();
}

function slim_mvc_autoloader($className) {
	global $_area;
	if (file_exists(_BASEDIR._APP."/code/controllers/".$_area."/".$className.".php")) {
		include_once _BASEDIR._APP."/code/controllers/".$_area."/".$className.".php";
	}
	elseif (file_exists(_BASEDIR._APP."/code/models/".$className.".php")) {
		include_once _BASEDIR._APP."/code/models/".$className.".php";
	}
	elseif (file_exists(_BASEDIR."lib/".$className.".php")) {
		include_once _BASEDIR."lib/".$className.".php";
	}
	else{
		include_once _BASEDIR."lib/Error.php";
		Error::exception($className);
	}
}

spl_autoload_register('slim_mvc_autoloader');

$module        = "page"; // Default module
$function      = "index"; // Default action
$_area 		   = "frontend"; // Is it for frontend or admin template/skin

// Global Js,css files for frontend and admin - can convert this into xml or json
$globalJsFiles['frontend']  = array("js/lib/jquery-1.9.1.min.js","js/lib/bootstrap.js","js/scripts.js");
$globalCssFiles['frontend'] = array("css/bootstrap.css","css/dropzone.css","css/jquery-te-1.4.0.css","css/custom.css");


$globalJsFiles['adminhtml']  = array("js/lib/jquery-1.9.1.min.js","js/scripts.js");
$globalCssFiles['adminhtml'] = array("css/bootstrap.css","css/custom.css");

// SEO friendly URL Rewrites - can make it into Db
$url_rewrites   = array(
						"about-us" => "page/about",
						"contact-us" => "page/contact",
						);

