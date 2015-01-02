<?php

class AdminController extends Template {

    var $array = array();
	
	public function AdminController() {
		
    } 
	
	public function dashboardAction($_app_params) {
		global $obj,$modelObj,$_app_params,$_statues,$_priority;  
        $this->setPageTitle("Dashboard");
		if(!isset($_SESSION['emp_name'])){ 
		   $this->redirect('admin/login');
	    }
		$this->render("dashboard",array());		
    } 
	
	public function loginAction(){
		global $obj,$modelObj,$_app_params,$_statues,$_priority;  
		if(isset($_SESSION['emp_name'] )){
			$this->redirect('admin/admin/dashboard');
			return;
		}
		elseif(isset($_POST) && isset($_POST['email']) ){
			$email 	   = $_POST['email'];
			$password  = md5($_POST['password']);
			$qry       = "select * from `users`  where emp_email='$email' and password='$password' ";
			$response  = $modelObj->fetch_assoc($qry);
		   
			if($response && count($response)){
				$_SESSION['emp_name'] = $response[0]['emp_name'] ;
				$_SESSION['emp_id']   = $response[0]['emp_id'];
				$_SESSION['suc_message'] = "You logged in successfully";
				$this->redirect('admin/admin/dashboard');
			}
			else{
				$_SESSION['err_message'] = 'Wrong user/password';						
				$this->redirect('');
			}
			return;
		}
		$this->render("login",array());
	} 
 
	public function logoutAction(){
		unset($_SESSION['emp_name']);
		unset($_SESSION);
		$this->redirect("");
	}
	
}