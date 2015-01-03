<?php
class Error extends Controller
{
    public static function printError($_className)
    {
        Layout::$rootLayout = 'exception';
    }
}