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
class Model_Users extends Model
{

    public function login($params)
    {
        $email = $params['email'];
        $password = md5($params['password']);
        $qry = "SELECT * from `{$this->getTable("users")}` WHERE `email`='$email' and password='$password' ";
        $response = $this->fetch($qry);
        if ($response) {
            return $response[0];
        }
        return false;
    }

    public function create($params)
    {
        $msgs = array();
        // debug($params);
        // die();
        try {
            $name = $params['username'];
            $username = $params['username'];
            $email = $params['email'];
            $password = md5($params['password']);
            $user_type = 'USER';
            $gender = '';
            $user_bio = '';
            $address = '';
            $contact_no = '';
            $photo = '';
            $dob = '';
            $is_active = '1';
            $is_root_admin = '0';

            if ($username != '' && $email != '' && $password != '') {
                $qry = "SELECT * FROM  `{$this->getTable("users"
                )}` WHERE `email` = '$email' OR `username` = '$username'";
                $result = $this->exec($qry);
                $count = $this->getNumberOfROws();
                if ($count > 0) {
                    $msgs['type'] = 'err_message';
                    $msgs['msg'] = "User already registered, Please Check..!";
                } else {
                    $insert_qry = "INSERT INTO `{$this->getTable("users")}` (`id`, `name`, `username`, `email`, `password`, `user_type`, `gender`, `user_bio`, `address`, `contact_no`, `photo`, `dob`, `is_active`, `created_time`, `last_visit`, `is_root_admin`)
											VALUES ('', '" . $name . "', '" . $username . "', '" . $email . "', '" . $password . "', '" . $user_type . "', '" . $gender . "', '" . $user_bio . "', '" . $address . "', '" . $contact_no . "', '" . $photo . "', '" . $dob . "', '" . $is_active . "', NOW(), NOW(), '" . $is_root_admin . "');";
                    $this->insert($insert_qry);
                    $msgs['type'] = 'suc_message';
                    $msgs['msg'] = 'User registered successfully..! Please Login..';
                }
            } else {
                $msgs['type'] = 'err_message';
                $msgs['msg'] = 'Please Fill all Fields..!';
            }
        } catch (Exception $e) {
            $msgs['type'] = 'err_message';
            $msgs['msg'] = "Something went wrong, Please Try Again Later..!";
        }
        return $msgs;
    }
}