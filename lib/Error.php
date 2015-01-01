<?php
class Error extends Template {
    var $array = array();
	

    public function error404Action($_url_params) {
    	$this->render_full("error_404",array('result' => $_url_params));
    }
	
}