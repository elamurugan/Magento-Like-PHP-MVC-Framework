<?php
/**
 * SLIM_MVC_Framework
 *
 * @category  controllers
 * @package   SLIM_MVC_Framework
 * @copyright Copyright (c) 2014 (http://www.elamurugan.com/)
 * @author    Ela <nelamurugan@gmail.com>
 */

/**
 * Class SLIM_MVC_Framework
 *
 * @category    controllers
 * @package     SLIM_MVC_Framework
 */
class Users extends Model
{

    public function login($params)
    {
        $email = $params['email'];
        $password = md5($params['password']);
        $qry = "select * from `users`  where emp_email='$email' and password='$password' ";
        $response = $this->fetch($qry);
        if ($response) {
            return $response[0];
        }
        return false;
    }

    public function create($params)
    {
        $msgs = array();
        try {
            $emp_name = $params['emp_name'];
            $emp_image = $_FILES['emp_image']['name'];
            $emp_email = $params['emp_email'];
            $emp_uname = $params['emp_uname'];
            $emp_pswd = md5($params['emp_pswd']);
            $emp_designation = $params['emp_designation'];
            $emp_permission_level = $params['emp_permission_level'];
            $emp_dob = $params['emp_dob'];
            $emp_adrs = $params['emp_adrs'];
            $emp_num1 = $params['emp_num1'];
            $emp_num2 = $params['emp_num2'];
            $emp_fcontact = $params['emp_fcontact'];
            $emp_blood = $params['emp_blood'];

            $qry = "select * from  `users` where emp_email='$emp_email' ";
            $result = $this->exec($qry);
            $count = $this->getNumberOfROws();
            if ($count > 0) {
                $msgs['type'] = 'err_message';
                $msgs['msg'] = "Employee already registered, Please Check";
            } else {
                $insert_qry = "INSERT INTO `users` (`emp_id`, `emp_name`, `emp_image`, `emp_email`, `username`, `password`, `designation`, `role_id`, `dob`, `contact_address`, `contact_num`, `sec_contact_num`, `blood_group`, `first_contact`, `emp_status`, `row_inserted_time`) VALUES (NULL, '$emp_name', '$emp_image', '$emp_email', '$emp_uname', '$emp_pswd', '$emp_designation', '$emp_permission_level', '$emp_dob', '$emp_adrs', '$emp_num1', '$emp_num2', '$emp_blood', '$emp_fcontact', NULL, NULL);";
                $this->insert($insert_qry);
                $msgs['type'] = 'suc_message';
                $msgs['msg'] = 'Employee registered successfully';
            }
        } catch (Exception $e) {
            $msgs['type'] = 'err_message';
            $msgs['msg'] = "Something went wrong";
        }
        return $msgs;
    }
}