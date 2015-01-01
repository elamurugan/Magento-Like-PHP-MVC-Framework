<?php

include_once "app/configuration.php";
$modelObj        = $dbObj        = new Model();
// Routing process
if (isset($_GET['url'])){
    $url  = $_GET['url']; 
    $url_params = @explode("/", $url);
    if (isset($url_params[0]) && $url_params[0] != '') {
        $module = $url_params[0];
        array_shift($url_params);
		if($module == $_adminPath){
			$_area 		   = "adminhtml"; 
			if (isset($url_params[0]) && $url_params[0] != '') {
				$module = $url_params[0];
				array_shift($url_params);
				if (isset($url_params[0]) && $url_params[0] != '') {
					$function = $url_params[0];
					array_shift($url_params); 
				}
			}
			else{
				$module   =  'admin';
				$function =  'login';
			}
		}
		if(isset($url_rewrites[$module])){
			$url_rewrite_params = @explode("/", $url_rewrites[$module]);
			$module =	$url_rewrite_params[0];
			$function =	$url_rewrite_params[1];
		}
		elseif($module !='admin'){
			if (isset($url_params[0]) && $url_params[0] != '') {
				$function = $url_params[0];
				array_shift($url_params); 
			}
			else{
				$function = 'error404';
			}
		}
    }
	$_app_params['request'] = $_REQUEST;
	foreach($url_params as $key => $val){
		if($key%2 == 0 && $val != '') $_app_params[$val] = @$url_params[$key+1];
	}
}

session_start();
session_name($_area);
$module		  = $model		  = ucfirst($module);
$module_class = $module.'Controller';

if (isset($_GET['url'])){
	if (!class_exists($module_class)) {
		$user_exist = $dbObj->checkUsernameexist($module); 
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

$obj          = new $module_class();
$action 	  = $function.'Action';
if (!method_exists($obj, $action)){
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
$obj->_init();
$obj->$action($_app_params);
