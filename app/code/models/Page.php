<?php

class Page extends Model {

	public function getUsers() {
        $qry 	 = "SELECT * FROM `users`";
        $result  = $this->fetch_assoc($qry);
		debug($result);
    }
}