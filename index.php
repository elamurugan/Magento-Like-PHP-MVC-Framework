<?php

include_once "app/configuration.php";
include_once _BASEDIR."lib/Template.php";
include_once _BASEDIR."lib/Model.php";
include_once _BASEDIR."lib/Error.php";
include_once _BASEDIR."app/code/models/Users.php";
include_once _BASEDIR."app/code/controllers/UsersController.php";

$temp 		   = array();
$_url_params   = $url_params    = $result_data   = array();

// Routing process
if (isset($_GET['url'])){
    $url  = $_GET['url']; 
    $url_params = @explode("/", $url); 
    if (isset($url_params[0]) && $url_params[0] != '') {
        $module = $url_params[0];
        array_shift($url_params);
        if (isset($url_params[0]) && $url_params[0] != '') {
            $function = $url_params[0];
            array_shift($url_params);
            $_url_params = $_REQUEST;
            foreach($url_params as $key => $val){
                if($key%2 == 0 && $val != '') $_url_params[$val] = @$url_params[$key+1];
            }
        }
    }
}

$module		  = $model		  = ucfirst($module);
$module_class = $module.'Controller';
if (file_exists(_BASEDIR."app/code/controllers/".$module_class.".php")) {
	include_once _BASEDIR."app/code/models/".$model.".php";
	include_once _BASEDIR."app/code/controllers/".$module_class.".php";
}

if (!class_exists($module_class)) {
    $obj        = new UsersController(); 
    $user_exist = $obj->checkUser($module); 
    if ($user_exist) {
        $module     					= 'Users';
		$module_class 					= $module.'Controller';
        $function   					= "profileView";
        $_url_params['current_user']    = $user_exist;
    }
	else
	{
        $module   = 'Error';  
    }
} 

$obj          = new $module_class();
$action 	  = $function.'Action';
if (!method_exists($obj, $action)){
    $function = "error404"; 
	$action   = "error404Action";
}

$_url_params['config']['module']   = strtolower($module);
$_url_params['config']['model']    = ($model);
$_url_params['config']['function'] = $function;
$_url_params['config']['action']   = $action;
$_url_params['config']['area']     = $_area;
$_SESSION['body_class'] 		   = strtolower($module."_".$function);

$obj->$action($_url_params);
