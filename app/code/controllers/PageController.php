<?php

class PageController extends Template {

    var $array = array();
	
	public function PageController() {
		
    } 
	
	public function injdexAction(){	
		global $obj,$_url_params,$_statues,$_priority; 
		$model = $_url_params['config']['model'];
		$db = new $model();
		
		$this->render_full("login",array());
	}
	
	
	
}