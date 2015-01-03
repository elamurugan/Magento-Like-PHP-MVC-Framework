<?php

class Admin extends Model
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
}