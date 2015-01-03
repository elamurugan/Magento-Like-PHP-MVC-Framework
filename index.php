<?php
define('_APP', 'app');
define('_SKIN', 'skin');
define('_ADMIN_ROUTE_URL', 'admin');// Admin Base Path
include_once _APP . "/bootstrap.php";
$action = $_app_params['config']['action'];
$app->_init();
$app->$action($_app_params);
