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
class Adminhtml_Model_Dashboard extends Model
{

    public function login($params)
    {
        $email = $params['email'];
        $password = md5($params['password']);
        $qry = "SELECT * FROM `{$this->getTable("users")}`  WHERE (`email` = '$email' or `username` = '$email')AND password = '$password';";
        $response = $this->fetch($qry);
        if ($response) {
            return $response[0];
        }
        return false;
    }

    public function update_user_data($params)
    {
        extract($params);
        $data = array("username" => $username, "name" => $name);
        if (isset($password) && $password != '') {
            $password = md5($params['password']);
            if (isset($confirm_password) && $confirm_password != '') {
                $confirm_password = md5($params['confirm_password']);
                if ($password == $confirm_password) {
                    $data["password"] = $password;
                } else {
                    $msgs['type'] = 'err_message';
                    $msgs['msg'] = 'Passwords Do Not Match..!';
                    return $msgs;
                }
            } else {
                $data["password"] = $password;
            }
        }
        if (isset($user_type) && $user_type != '') {
            $data["user_type"] = $user_type;
        }
        if (isset($is_active) && $is_active != '') {
            $data["is_active"] = $is_active;
        }
        $this->update("users", $data, array("id" => $id));
        $msgs['type'] = 'suc_message';
        $msgs['msg'] = 'USER ID: ' . $id . ', Profile Updated Successfully..!';
        return $msgs;
    }

    public function update_config_data($params)
    {
        $user_config = array_keys($this->getConfigData());

        foreach ($params as $key => $value) {
            if (in_array($key, $user_config)) {
                $this->updateConfigVariable($key, $value);
            } else {
                $this->createConfigVariable($key, $value);
            }
        }

        $msgs['type'] = 'suc_message';
        $msgs['msg'] = 'Configuration Updated Successfully..!';

        return $msgs;
    }
}