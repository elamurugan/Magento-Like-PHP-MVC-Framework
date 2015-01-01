<?php

class UsersController extends Template {

    var $array = array();
	
	public function indexAction($_url_params) {
		global $obj,$_url_params,$_statues,$_priority; 
		$model = $_url_params['config']['model'];
	    // d($_url_params);
		$db = new $model();
        $_SESSION['title']   = "EMS - EBDUS";		
		if(isset($_SESSION['emp_name'])){		
			$this->redirect('user/profile');
		} else {
		    $this->render_full("login",array());
	    }				
    } 

	
	public function loginAction(){	
		global $obj,$_url_params,$_statues,$_priority; 
		$model = $_url_params['config']['model'];
		$db = new $model();
		if(isset($_SESSION['emp_name'] )){
			$this->redirect('user/profile');
			return;
		}
		elseif(isset($_POST) && isset($_POST['email']) ){
			 // d($_url_params);die();
			$email 	   = $_POST['email'];
			$password  = md5($_POST['password']);
			$qry       = "select * from `users`  where emp_email='$email' and password='$password' ";
			$response  = $db->fetch_assoc($qry);
		   
			if($response && count($response)){
				$_SESSION['emp_name'] = $response[0]['emp_name'] ;
				$_SESSION['emp_id']   = $response[0]['emp_id'];
				$_SESSION['suc_message'] = "You logged in successfully";
				$this->redirect('user/profile');
			}
			else{
				$_SESSION['err_message'] = 'Wrong user/password';						
				$this->redirect('');
			}
			return;
		}
		$this->render_full("login",array());
	}
	
	
	public function createAction(){
		global $obj,$_url_params,$_statues,$_priority; 
		$model = $_url_params['config']['model'];
		$db = new $model();
		if(isset($_POST) && isset($_POST['emp_email'])){
			// d($_POST); d($_FILES);die();
	
			$emp_name     		  = $_POST['emp_name'];
			$emp_image			  = $_FILES['emp_image']['name'];
			$emp_email 			  = $_POST['emp_email'];
			$emp_uname  		  = $_POST['emp_uname'];
			$emp_pswd  			  = md5($_POST['emp_pswd']);
			$emp_designation      = $_POST['emp_designation'];
			$emp_permission_level = $_POST['emp_permission_level'];
			$emp_dob 			  = $_POST['emp_dob'];  
			$emp_adrs  			  = $_POST['emp_adrs'];
			$emp_num1    		  = $_POST['emp_num1'];
			$emp_num2 			  = $_POST['emp_num2'];
			$emp_fcontact 		  = $_POST['emp_fcontact'];
			$emp_blood  		  = $_POST['emp_blood'];
			
			$qry     = "select * from  `users` where emp_email='$emp_email' ";
			$result  = $this->query($qry);
			$count   = $this->number_of_rows();
			
			if($count > 0){
				$_SESSION['err_message'] = "Employee already registered, Please Check";				
				$this->redirect("user/profile");
			} else {
				$insert_qry = "INSERT INTO `users` (`emp_id`, `emp_name`, `emp_image`, `emp_email`, `username`, `password`, `designation`, `role_id`, `dob`, `contact_address`, `contact_num`, `sec_contact_num`, `blood_group`, `first_contact`, `emp_status`, `row_inserted_time`) VALUES (NULL, '$emp_name', '$emp_image', '$emp_email', '$emp_uname', '$emp_pswd', '$emp_designation', '$emp_permission_level', '$emp_dob', '$emp_adrs', '$emp_num1', '$emp_num2', '$emp_blood', '$emp_fcontact', NULL, NULL);";
				$this->insert($insert_qry);
				$_SESSION['suc_message'] = "Employee registered successfully";
				$this->redirect("employees/list");
			}
			return;
		}
		$this->render_full("create",array());
	}
	
	
    public function profileAction($_url_params) {
		if(isset($_SESSION['emp_name'])){		
			$this->render_full("profile",array());
		} else {
		    $this->redirect('user/index');
	    }
    }

    public function profileViewAction($_url_params) {
		$this->render_full("profile_view",array('current_user' => $_url_params['current_user']));
    }

	
	public function logoutAction(){
		unset($_SESSION['emp_name']);
		unset($_SESSION);
		$this->redirect("");
	}
	
}