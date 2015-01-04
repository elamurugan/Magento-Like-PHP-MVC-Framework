<?php

class Page extends Model
{
    public function Page()
    {
    }

    public function getUsers()
    {
        $qry = "SELECT * FROM `users`";
        return $result = $this->fetch($qry);
    }
}