<?php
class Error extends Template {
    var $array = array();
	

    public function error404Action($_app_params) {
    	$this->render("error_404",array('result' => $_app_params));
    }
	
}