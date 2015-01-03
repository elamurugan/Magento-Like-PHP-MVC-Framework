<?php
class Error extends Template
{
    var $array = array();

    public static function exception($_class)
    {
        Template::$layout = 'exception';
    }
}