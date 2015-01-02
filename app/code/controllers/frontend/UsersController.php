<?php

class UsersController extends Template {

	public $model = false;
	
	public function UsersController() {
		global $app,$_app_params,$modelObj;
		$this->model = $modelObj;
		
    } 
	
	public function indexAction($_app_params) {
		global $app;  
        $this->setPageTitle("Profile");
		if($this->getSession("emp_name")){
			$this->redirect('users/profile');
		} else {
		    $this->render("login",array());
	    }
    } 

	
	public function loginAction($_app_params){
		global $app;  
		if($this->model->isUserLoggedIn()){
			$this->redirect('users/profile');
			return;
		}
		elseif(isset($_POST)){
			$postParams = $this->getParamsByType('post'); 
			$response  = $this->model->login($postParams); 
			if($response && count($response)){
				$this->setSession("user",$response) ;
				$this->setSession('suc_message' ,"You logged in successfully");
				$this->redirect('users/profile');
			}
			else{
				$this->setSession('err_message' , 'Wrong user/password');						
				$this->redirect('');
			}
			return;
		}
		$this->render("login",array());
	} 
	
	public function createAction($_app_params){
		global $app,$_statues,$_priority; 
		if(isset($_POST)){
			$postParams = $this->getParamsByType('post'); 
			$response  = $this->model->create($postParams); 
			$this->setSession($response['type'] , $response['msg']); 
			$this->redirect("users/profile");
			return;
		}
		$this->render("create",array());
	}
	
	
    public function profileAction($_app_params) {
		if($this->model->isUserLoggedIn()){
			$this->render("profile",array());
		} else {
		    $this->redirect('users/login');
	    }
    }

    public function profileviewAction($_app_params) {
		$this->render("profile_view",array('current_user' => $_app_params['current_user']));
    }
 
	public function logoutAction($_app_params){
		$this->resetApp();
		$this->redirect("");
	}
	
}