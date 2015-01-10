<?php/** * SLIM_MVC_Framework * * @category  controllers * @package   SLIM_MVC_Framework * @copyright Copyright (c) 2014 (http://www.elamurugan.com/) * @author    Ela <nelamurugan@gmail.com> *//** * Class SLIM_MVC_Framework * * @category    controllers * @package     SLIM_MVC_Framework */class App extends XMLParser{    public static function setArea($_area)    {        return Config::$__area = $_area;    }    public static function getArea()    {        return Config::$__area;    }    public function App()    {        if ($this->configXml == false) {            $this->configPrepare();        }        if ($this->configXml == false) {            $this->localPrepare();        }        date_default_timezone_set($this->getSystemTimeZone());        Config::$adminRoutePath = $this->getLocalXml("admin/route_path");        Config::$__dbHostname = $this->getLocalXml("db/host");        Config::$__dbUsername = $this->getLocalXml("db/user");        Config::$__dbPassword = $this->getLocalXml("db/password");        Config::$__dbName = $this->getLocalXml("db/db_name");        Config::$__dbTablePrefix = $this->getLocalXml("db/table_prefix");    }    public function processRouting()    {        $area = $this->getConfig('default/area');        $module = $this->getConfig('default/frontend/module');        $function = $this->getConfig('default/frontend/function');        $__appParams = array();        $__resultData = array();        $model = new Model();        if (isset($_GET['url_request'])) {            $urlParams = @explode("/", $_GET['url_request']);            if (isset($urlParams[0]) && $urlParams[0] != '') {                $module = $urlParams[0];                array_shift($urlParams);                if ($module == Config::$adminRoutePath) {                    Config::$_isCurrentlyAdmin = true;                    $area = Config::ADMINHTML_AREA;                    $module = $this->getConfig('default/adminhtml/module');                    $function = $this->getConfig('default/adminhtml/function');                    if (isset($urlParams[0]) && $urlParams[0] != '') {                        $module = $urlParams[0];                        array_shift($urlParams);                        if (isset($urlParams[0]) && $urlParams[0] != '') {                            $function = $urlParams[0];                            array_shift($urlParams);                        }                    }                } else {                    $urlRewriteExist = $model->checkUrlRewriteAvailable($module);                    if (!count($urlRewriteExist)) {                        if (isset($urlParams[0]) && $urlParams[0] != '') {                            $function = $urlParams[0];                            array_shift($urlParams);                        } else {                            $function = 'error404';                        }                    } else {                        $module = $urlRewriteExist[0];                        $function = $urlRewriteExist[1];                        array_shift($urlRewriteExist);                        array_shift($urlRewriteExist);                        $urlParams = array_merge($urlRewriteExist, $urlParams);                    }                }            }            if (count($urlParams)) {                foreach ($urlParams as $key => $val) {                    if ($key % 2 == 0 && $val != '') {                        $__appParams['params'][$val] = @$urlParams[$key + 1];                    }                }            }            if (isset($_REQUEST)) {                foreach ($_REQUEST as $key => $val) {                    $__appParams['params'][$key] = $val;                }            }        }        session_start();        session_name($area);        if (!Utils::isInstalled()) {            $module = "install";            $function = "setup";        }        Config::$__area = $area;        Config::$__resultData = $__resultData;        Config::$__appParams = $__appParams;        $_controllerClass = 'Controller_' . ucfirst($module);        $modelClass = 'Model_' . ucfirst($module);        if (Config::$_isCurrentlyAdmin) {            $_controllerClass = ucfirst(Config::ADMINHTML_AREA) . "_" . $_controllerClass;            $modelClass = ucfirst(Config::ADMINHTML_AREA) . "_" . $modelClass;        }        $action = $function . "Action";        $this->dispatchRouter($module, $_controllerClass, $action, $function, $modelClass);    }    public function dispatchRouter($module, $_controllerClass, $action, $function, $modelClass = false)    {        $controller = new $_controllerClass();        if (!method_exists($controller, $action)) {            $function = "error404";            $action = $function . "Action";        }        $handler = strtolower($module . "_" . $function);        if ($modelClass) {            $model = new $modelClass();            $controller->model = $model;            Config::$model = $model;        }        $controller->_templateInit();        $controller->addHandle($handler);        $controller->setBodyClass($handler);        $controller->$action();    }    public function setData($var, $val, $variable = '')    {        if ($variable != '') {            Config::$__resultData[$variable][$var] = $val;        } else {            Config::$__resultData[$var] = $val;        }    }    public function getData($var, $variable = '')    {        if ($variable != '') {            return isset(Config::$__resultData[$variable][$var]) ? Config::$__resultData[$variable][$var] : false;        } else {            return isset(Config::$__resultData[$var]) ? Config::$__resultData[$var] : false;        }    }    public function getParams()    {        if (isset(Config::$__appParams['params'])) {            return Config::$__appParams['params'];        }        return array();    }    public function getParam($param)    {        if (isset(Config::$__appParams['params'][$param])) {            return Config::$__appParams['params'][$param];        }        return false;    }    public function setParam($param, $val = null)    {        if ($val == null && isset(Config::$__appParams[$param])) {            unset(Config::$__appParams[$param]);        } else {            Config::$__appParams[$param] = $val;        }    }    public static function getParamsByType($type = 'get')    {        if ($type == 'post') {            return $_POST;        }        return $_GET;    }    public static function getSession($sessionParam)    {        if (isset($_SESSION[$sessionParam])) {            return $_SESSION[$sessionParam];        }        return false;    }    public static function getSessionName()    {        return session_name();    }    public static function setSession($sessionParam, $val = null)    {        if ($val == null && isset($_SESSION[$sessionParam])) {            unset($_SESSION[$sessionParam]);        } else {            $_SESSION[$sessionParam] = $val;        }    }    public static function resetApp()    {        unset($_SESSION);        session_unset();        session_destroy();    }    public static function getUrl($params = array())    {        $url = self::getBaseUrl();        if ($params && count($params)) {            foreach ($params as $key => $val) {                $url .= $key . "/" . $val . "/";            }        }        return $url;    }    public static function getBaseUrl()    {        if (Config::$__area == Config::$__adminArea) {            return _BASEURL . Config::$adminRoutePath . "/";        }        return _BASEURL;    }    public static function getMediaUrl()    {        return _BASEURL . "media/";    }    public static function getSkinUrl()    {        return _BASEURL . self::$skinPath;    }    public function isAdminPath()    {        if (Config::$__area == Config::$__adminArea) {            return true;        }        return false;    }    public function isUserLoggedIn()    {        return self::getSession('user');    }    public function getLoggedInUser()    {        return self::getSession('user');    }    public function isAdminLoggedIn()    {        return self::getSession('admin');    }    public function getLoggedInAdmin()    {        return self::getSession('admin');    }    public static function printException($classFile, $msg)    {        $errorObj = new Error();        $errorObj->printError($classFile, $msg);    }    public static function printAppFilesStack()    {        global $appStartTime;        echo "<br/><br/><br/><br/><br/>";        $units = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');        $memoryUsed = memory_get_usage();        debug("Memory usage: " . $memoryUsed . " bits, " . @round($memoryUsed / pow(1024,                        ($i = floor(log($memoryUsed, 1024)))                    ),                                                                  2                ) . ' ' . $units[$i]        );        // debug("Execution Order");        // debug(array_reverse(debug_backtrace()));        debug("Included files");        debug(get_included_files());        $execTime = microtime(true) - $appStartTime;        debug("Page generation time: " . $execTime . " seconds");    }    public static function log($msg, $filename = 'exception.log')    {        $currentTime = @date('Y-m-d H:i:s');        $path = _BASEDIR . "var/" . $filename;        error_log($currentTime . ": " . $msg . "\n", 3, $path);    }}