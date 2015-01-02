<?php
class Error extends Template
{
    var $array = array();

    public static function exception($_class)
    {
        die("'" . $_class . "' or configuration not loaded properly. <a href='" . _BASEURL . "'>Go Back</a>");
    }
}