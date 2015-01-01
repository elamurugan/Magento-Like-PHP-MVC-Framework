<?php

class PageController extends Template {

    var $array = array();
	
	public function PageController() {
		
    } 
	
	public function indexAction(){	
		global $obj,$modelObj,$_app_params,$_statues,$_priority; 
		$this->setPageTitle("Home");
		$this->render("index",array());
	}
	
	public function aboutAction(){	
		global $obj,$modelObj,$_app_params,$_statues,$_priority; 
		$this->setPageTitle("About Us"); 
		$this->render("about",array());
	}
	
	public function contactAction(){	
		global $obj,$modelObj,$_app_params,$_statues,$_priority; 
		parent::addJs("js/contacts.js");	
		// $modelObj->getUsers();
		$this->setPageTitle("Contact Us");
		$this->render("contact",array());
	}
	
	public function clearcacheAction(){	
		$this->clearCssJsCache();
		$this->redirect('page/index');
	}
	
}