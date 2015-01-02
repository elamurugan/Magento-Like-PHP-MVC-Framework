<?php
define('_APP','app');
define('_SKIN','skin');
define('_ADMIN_ROUTE_URL','admin');// Admin Base Path 
include_once _APP."/configuration.php";
$modelObj        = $dbObj        = new Model();
// Routing process
if (isset($_GET['url'])){
    $url_params = @explode("/", $_GET['url']);
    if (isset($url_params[0]) && $url_params[0] != '') {
        $module = $url_params[0];
        array_shift($url_params);
		if($module == _ADMIN_ROUTE_URL){
			$_area 		   = "adminhtml"; 
			$function =  'login';//default
			if (isset($url_params[0]) && $url_params[0] != '') {
				$module = $url_params[0];
				array_shift($url_params);
				if (isset($url_params[0]) && $url_params[0] != '') {
					$function = $url_params[0];
					array_shift($url_params); 
				}
			}
		}
		elseif(isset($url_rewrites[$module])){
			$url_rewrite_params = @explode("/", $url_rewrites[$module]);
			$module =	$url_rewrite_params[0];
			$function =	$url_rewrite_params[1];
		}
		else{
			if (isset($url_params[0]) && $url_params[0] != '') {
				$function = $url_params[0];
				array_shift($url_params); 
			}
			else{
				$function = 'error404';
			}
		}
    }
	foreach($url_params as $key => $val){
		if($key%2 == 0 && $val != '') $_app_params['params'][$val] = @$url_params[$key+1];
	}
	if(isset($_REQUEST)){
		foreach($_REQUEST as $key => $val){
			$_app_params['params'][$key] = $val;
		}
	}
}

session_start();
session_name($_area);
$module		  = $model		  = ucfirst($module);
$module_class = $module.'Controller';

if (isset($_GET['url'])){
	if (!class_exists($module_class)) {
		$user_exist = $dbObj->checkUsernameExist($module); 
		if ($user_exist) {
			$model		  = $module     	= 'Users';
			$module_class 					= $module.'Controller';
			$function   					= "profileview";
			$_app_params['current_user']    = $user_exist;
		}
		else
		{
		   $module_class = $module   = $model		  = 'Error';  
		}
	}
}

$app          = new $module_class();
$action 	  = $function.'Action';
if (!method_exists($app, $action)){
    $function = "error404"; 
	$action   = "error404Action";
}
$_app_params['config']['module']   = strtolower($module);
$_app_params['config']['model']    = $model;
$_app_params['config']['function'] = $function;
$_app_params['config']['action']   = $action;
$_app_params['config']['area']     = $_area;
$_app_params['config']['body_class'] 	= strtolower($module."_".$function);
if($model != '' && class_exists($model)){
	$modelObj        = new $model;
}
$app->_init();
$app->$action($_app_params);
