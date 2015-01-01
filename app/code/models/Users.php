<?php

class Users extends Model {

	public function checkUser($username) {
        $qry 	 = "SELECT * FROM `users` where username = '$username'";
        $result  = $this->fetch_assoc($qry);
        if(count($result))
            return $result[0];
        else
            return false;
    }	
}