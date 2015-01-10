<?php

class Slim
{
    static private $_registry = array();
    static private $_objects;
    public static  $_app;
    public static  $_model;

    public function Slim()
    {
        $this->removeMagicQuotes();
        $this->setErrorReporting();
        spl_autoload_register(array('Slim', 'slimMVCAutoloader'));
    }

    public static function getClassPath($className, $_currentArea = '')
    {
        $classPath = explode("_", $className);
        return implode("/", $classPath);
    }

    public static function convertToClassPath($className, $_currentArea = '')
    {
        $classPath = explode("/", $className);
        $classPath = array_map(function($word) { return ucfirst($word); }, $classPath);
        $classPath = explode("_", implode("_", $classPath));
        $classPath = array_map(function($word) { return ucfirst($word); }, $classPath);
        return implode("_", $classPath);
    }

    public static function slimMVCAutoloader($className)
    {
        $_currentArea = ucfirst(Config::$__area);
        $classPath = self::getClassPath($className, $_currentArea);

        if (file_exists(_BASEDIR . "lib/" . $classPath . ".php")) {
            include_once _BASEDIR . "lib/" . $classPath . ".php";
        } elseif (file_exists(_APPDIR . "code/Adminhtml/" . $classPath . ".php")) {
            include_once _APPDIR . "code/Adminhtml/" . $classPath . ".php";
        } elseif (file_exists(_APPDIR . "code/" . $classPath . ".php")) {
            include_once _APPDIR . "code/" . $classPath . ".php";
        } else {
//            debug($className);
            Slim::register("error_page_info","Class ".$className." Not found");
            include_once _BASEDIR . "lib/Error.php";
            self::$_app->dispatchRouter("error","Error","printError","printError");
        }
    }

    public function run()
    {
        self::$_app = new App();
        self::$_app->processRouting();
    }

    /**
     * Register a new variable
     *
     * @param string $key
     * @param mixed  $value
     * @param bool   $graceful
     * @throws Mage_Core_Exception
     */
    public static function register($key, $value, $graceful = false)
    {
        self::$_registry[$key] = $value;
    }

    /**
     * Unregister a variable from register by key
     *
     * @param string $key
     */
    public static function unregister($key)
    {
        if (isset(self::$_registry[$key])) {
            if (is_object(self::$_registry[$key]) && (method_exists(self::$_registry[$key], '__destruct'))) {
                self::$_registry[$key]->__destruct();
            }
            unset(self::$_registry[$key]);
        }
    }

    /**
     * Retrieve a value from registry by a key
     *
     * @param string $key
     * @return mixed
     */
    public static function registry($key)
    {
        if (isset(self::$_registry[$key])) {
            return self::$_registry[$key];
        }
        return null;
    }

    public static function createBlock($block = array(), $this = false)
    {
        if (file_exists($tempFile = $block['path'] . $block['template'])) {
            $blockClass =  self::convertToClassPath($block['block_class']);
            debug($blockClass);
            $blockObj = new $blockClass($tempFile);
            $_objects[$blockClass.'_block'] = $blockObj;
            $blockObj->_templateFile = $tempFile;
//            include_once($tempFile);
        }
    }

    public static function getModel($class = "", $empty = false)
    {
        if(!isset($_objects[$class.'_model']) || $empty){
            $classFile = self::convertToClassPath($class);
            $obj = new $classFile();
            $_objects[$class.'_model'] = $obj;
        }
        return $_objects[$class.'_model'];
    }

    public function setErrorReporting()
    {
        if (_DEBUG_MODE) {
            error_reporting(E_ALL | E_STRICT);
            ini_set('display_errors', 1);
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
            ini_set('log_errors', 'On');
        }
    }

    public function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
        return $value;
    }

    public function removeMagicQuotes()
    {
        $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (get_magic_quotes_gpc()) {
            $_GET = stripSlashesDeep($_GET);
            $_POST = stripSlashesDeep($_POST);
            $_COOKIE = stripSlashesDeep($_COOKIE);
        }
    }
}