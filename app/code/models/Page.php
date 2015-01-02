<?php

class Page extends Model
{

    public function getUsers()
    {
        $qry = "SELECT * FROM `users`";
        return $result = $this->fetch_assoc($qry);
    }
}