<?php 
class Template {    	public static $js_files = array();	public static $css_files = array();	public static $configData = array();	public static $bodyClasses = array();	public static $skinBasePath = '';	public static $skinPath = '';	public static $templatePath = '';	public static $cachedJson = false;	public static $cachePath = '';	public static $cacheJsonFile = '';		//Default Handler files	public static $exceptionLayoutFile = 'exception';	public static $layout = '1column';	public static $headerFile = 'header';	public static $leftFile = 'left';	public static $rightFile = 'right';	public static $footerFile = 'footer';	public static $contentFile = 'index';			public $model = false;		public function _init() {		global $globalJsFiles,$globalCssFiles,$_app_params,$modelObj;        $area   = $_app_params['config']['area'];		$theme  = $_app_params['config'][$area]['theme'];		self::$skinBasePath = $_app_params['config']['skin_path'];        self::$skinPath = self::$skinBasePath."/".$area."/".$theme."/";		self::$templatePath = _BASEDIR._APP."/design/".$area."/".$theme."/";		if (!is_writable(_BASEDIR.self::$skinPath)) {			die("Please Check skin directory path is writeable");		}		foreach($globalJsFiles[$area] as $globalJsFile){			self::addJs($globalJsFile);		}		foreach($globalCssFiles[$area]  as $globalCssFile){			self::addCss($globalCssFile);		}		self::$cachePath =  _BASEDIR.self::$skinPath."cache/";		self::$cacheJsonFile = self::$cachePath."cache.json";		$this->model = $modelObj;    }	// For normal response    public function render($view_file ,$params = array()) {		        global $app,$_app_params;          $module = $_app_params['config']['module'];		self::$contentFile = $view_file;				if (file_exists($layoutFileName = self::$templatePath.self::$layout.".phtml"))		    require_once($layoutFileName);        else            require_once(self::$templatePath.self::$exceptionLayoutFile.".phtml"); 				Helper::updateCacheFile(self::$cacheJsonFile,self::$cachedJson);		if(PRINT_MEMORY_USAGE){			self::printAppFilesStack();		}    }        // For ajax kind of response    public function renderIntoString($view_file, $params = array())    {        ob_start();		$this->render($view_file, $params);        $_template_content = ob_get_contents();        ob_end_clean();        return $_template_content;    }		public function setPageTitle($site_title)    {		global $_app_params; 		$_app_params['config']['site_title'] = $site_title;	}		public function setPageMetaKeywords($site_meta_keywords)    {		global $_app_params; 		$_app_params['config']['site_meta_keywords'] = $site_meta_keywords;	}		public function setPageMetadescription($site_meta_description)    {		global $_app_params; 		$_app_params['config']['site_meta_description'] = $site_meta_description;	}		public function getSiteTitle()    {		return self::$configData['site_title'];	}		public function getPageTitle()    {		global $_app_params; 		$title = $_app_params['config']['site_title']." - ".self::$configData['site_title'];		return $title;	}		public function getPageMetaKeywords()    {		global $_app_params;		$site_meta_keywords = @$_app_params['config']['site_meta_keywords']." ".self::$configData['site_meta_keywords'];		return $site_meta_keywords;	}		public function getPageMetadescription()    {		global $_app_params;		$site_meta_description = @$_app_params['config']['site_meta_description']." ".self::$configData['site_meta_description'];		return $site_meta_description;	} 			public function setBodyClass($cssclass)    {		self::$bodyClasses[] = $cssclass;	}		public function getBodyClass()    {		global $_app_params; 		$body_class = $_app_params['config']['body_class']." ".implode(" ",self::$bodyClasses);		return $body_class;	}			public static function addJs($js_file)    {		self::$js_files[] = $js_file;	}		public static function addCss($css_file)    {		self::$css_files[] = $css_file;	}		public function renderJs()    {		$mergedJsFileName = $html = '';		self::$js_files = array_unique(self::$js_files);		if(self::$configData['js_compress'] == 1){			if(!is_dir(self::$cachePath)) {				mkdir(self::$cachePath, 0777);			}			$curentJsFiles['files'] = implode(",",self::$js_files); 			if(file_exists(self::$cacheJsonFile)){				if(self::$cachedJson === false){					self::$cachedJson = Helper::readCacheFile(self::$cacheJsonFile);				}				if(self::$cachedJson &&  is_array(self::$cachedJson) && isset(self::$cachedJson['js'])){					foreach(self::$cachedJson['js'] as $jsMergedFile){						if($curentJsFiles['files'] == $jsMergedFile['files']){							$mergedJsFileName =  $jsMergedFile['merged'];						}					}				}			}			if($mergedJsFileName == '' || !file_exists(_BASEDIR.self::$skinPath."cache/".$mergedJsFileName)){				global $dbObj;				include_once(_BASEDIR."lib/jsmin.php");				$mergedJsFileName = Helper::generateRandomString().'.js';				$jsContents = '';				foreach(self::$js_files as $jsFile){ 					if(file_exists(_BASEDIR.self::$skinPath.$jsFile)){						$jsContents .= file_get_contents(_BASEDIR.self::$skinPath.$jsFile);					}				}				$jsContents = JSMin::minify($jsContents);				$handle     = fopen(_BASEDIR.self::$skinPath."cache/".$mergedJsFileName, 'w');				fwrite($handle, $jsContents);				fclose($handle);				$curentJsFiles['merged'] = $mergedJsFileName;				self::$cachedJson['js'][] = $curentJsFiles; 			}			$html .= sprintf('<script type="text/javascript" src="%s"></script>' . "\n",_BASEURL.self::$skinPath."cache/".$mergedJsFileName);		}		else{			foreach(self::$js_files as $jsFile){ 				if(file_exists(_BASEDIR.self::$skinPath.$jsFile)){					$html .= sprintf('<script type="text/javascript" src="%s"></script>' . "\n",_BASEURL.self::$skinPath.$jsFile);				}			}		}				return $html;	}			public function renderCss()    {		$mergedCssFileName = $html = '';		self::$css_files = array_unique(self::$css_files);		if(self::$configData['css_compress'] == 1){			if(!is_dir(self::$cachePath)) {				mkdir(self::$cachePath, 0777);			}						$cssMergedFiles = array();			$curentCssFiles['files'] = implode(",",self::$css_files); 			if(file_exists(self::$cacheJsonFile)){				if(self::$cachedJson === false){					self::$cachedJson = Helper::readCacheFile(self::$cacheJsonFile);				}				$cssMergedFiles = self::$cachedJson;				if(self::$cachedJson && is_array(self::$cachedJson) && isset(self::$cachedJson['css'])){					foreach(self::$cachedJson['css'] as $cssMergedFile){						if($curentCssFiles['files'] == $cssMergedFile['files']){							$mergedCssFileName =  $cssMergedFile['merged'];						}					}				}			}			if($mergedCssFileName == '' || !file_exists(_BASEDIR.self::$skinPath."cache/".$mergedCssFileName)){				global $dbObj;				$mergedCssFileName = Helper::generateRandomString().'.css';				$cssContents = '';				foreach(self::$css_files as $cssFile){ 					if(file_exists(_BASEDIR.self::$skinPath.$cssFile)){						$cssContents .= file_get_contents(_BASEDIR.self::$skinPath.$cssFile);					}				}				$cssContents = Helper::compressCss($cssContents,_BASEURL.self::$skinPath);				$handle     = fopen(_BASEDIR.self::$skinPath."cache/".$mergedCssFileName, 'w');				fwrite($handle, $cssContents);				fclose($handle);				$curentCssFiles['merged'] = $mergedCssFileName;				self::$cachedJson['css'][] = $curentCssFiles;			}			$html .= sprintf('<link rel="stylesheet" type="text/css" href="%s"/>'."\n",_BASEURL.self::$skinPath."cache/".$mergedCssFileName);		}		else{			foreach(self::$css_files as $cssFile){				if(file_exists(_BASEDIR.self::$skinPath.$cssFile)){					$html .= sprintf('<link rel="stylesheet" type="text/css" href="%s"/>'."\n",_BASEURL.self::$skinPath.$cssFile);				}			}		}		return $html;	}		public static function clearCssJsCache()    {		global $dbObj;		$script = "rm -rf "._BASEDIR.self::$skinPath."cache/*";		$results = system($script,$retval);	}		public static function resetApp()    {		unset($_SESSION);	}		public static function getParamsByType($type = 'get')    {		if($type == 'post') return $_POST;		return $_GET;	}		public static function getParams()    {		global $_app_params;		if(isset($_app_params['params'])) return $_app_params['params'];		return array();	}		public static function getParam($param)    {		global $_app_params;		if(isset($_app_params['params'][$param])) return $_app_params['params'][$param];		return false;	}		public static function setParam($param,$val = null)    {		global $_app_params;		if($val == null && isset($_app_params[$param]))			unset($_app_params[$param]);		else			$_app_params[$param] = $val;	} 		public static function getSession($sessionParam)    {		if(isset($_SESSION[$sessionParam])) return $_SESSION[$sessionParam];		return false;	}		public static function setSession($sessionParam,$val = null)    {		if($val == null && isset($_SESSION[$sessionParam])) 			unset($_SESSION[$sessionParam]);		else			$_SESSION[$sessionParam] = $val;	}		public static function getUrl($params = array())    {		$url =  self::getBaseUrl();		if($params && count($params)){			foreach($params as $key => $val) {				$url .= $key."/".$val."/";			}		}		return $url;	}		public static function getBaseUrl()    {		global $_app_params;		if($_app_params['config']['area'] == 'adminhtml') return _BASEURL._ADMIN_ROUTE_URL."/";		return _BASEURL;	}		public static function getMediaUrl()    {		return _BASEURL."media/";	}		public static function getSkinUrl()    {		return _BASEURL.self::$skinPath;	}				public static function printAppFilesStack() { 		global $app_start_time;		echo "<br/><br/><br/><br/><br/>";		$units = array('b','kb','mb','gb','tb','pb');		$memoryUsed = memory_get_usage();		debug("Memory usage: ".$memoryUsed." bits, ".@round($memoryUsed/pow(1024,($i=floor(log($memoryUsed,1024)))),2).' '.$units[$i]);				// debug("Execution Order");		// debug(array_reverse(debug_backtrace()));				debug("Included files");		debug(get_included_files());				$time = microtime(true) - $app_start_time;		debug("Page generation time: ".$time." seconds");	}	    public function redirect($url) {		$this->redirectUrl(_BASEURL . $url );    }		public function redirectUrl($url) {        if(!isset($_REQUEST['is_ajax'])){            if (!headers_sent()) {                header("Location: " .  $url . "");                exit;            } else {                echo "<script language='javascript' type='text/javascript'>window.location.href='" .  $url . "'</script>";                echo "<META http-equiv='refresh' content='0;URL=" .  $url . "'>";                exit;            }        }    }		public function error404Action($_app_params) {    	$this->render("error_404");    }
} 