<?phpclass Layout extends Core{    public static $cachedJson  = false;    public static $cacheUrl    = '';    public static $cachePath   = '';    public static $cacheFolder = '';    public static $cacheJsonFile = '';    public static $_jsFiles  = array();    public static $_cssFiles = array();    public static $skinBasePath        = '';    public static $skinPath            = '';    public static $themePath           = '';    public static $templatePath        = '';    public        $handles             = array();    public        $templates           = array();    public        $bodyClasses         = array();    public        $siteTitle           = '';    public        $siteMetaKeywords    = '';    public        $siteMetaDescription = '';    public function addHandle($handle)    {        $this->handles[] = $handle;    }    public function getHandles()    {        return $this->handles;    }    public function setTemplate($name, $value)    {        $this->templates[$name]['template'] = $value;    }    public function addItem($obj)    {        $function = "add" . ucfirst((string)$obj->addItem);        self::$function((string)$obj->file);    }    public function setPageTitle($pageTitle)    {        $this->setData('page_title', $pageTitle, 'config');    }    public function setPageMetaKeywords($siteMetaKeywords)    {        $this->setData('site_meta_keywords', $siteMetaKeywords, 'config');    }    public function setPageMetaDescription($siteMetaDescription)    {        $this->setData('site_meta_description', $$siteMetaDescription, 'config');    }    public function getPageTitle()    {        $title = $this->getData('page_title', 'config') . " - " . $this->siteTitle;        return $title;    }    public function getPageMetaKeywords()    {        $siteMetaKeywords = $this->getData('site_meta_keywords',                                           'config'            ) . " " . $this->siteMetaKeywords;        return $siteMetaKeywords;    }    public function getPageMetaDescription()    {        $siteMetaDescription = $this->getData('site_meta_description',                                              'config'            ) . " " . $this->siteMetaDescription;        return $siteMetaDescription;    }    public function setBodyClass($cssClass)    {        $this->bodyClasses[] = $cssClass;    }    public function getBodyClass()    {        return $this->getData('body_class', 'config') . " " . implode(" ", $this->bodyClasses);    }    public static function addJs($jsFile)    {        self::$_jsFiles[] = $jsFile;    }    public static function addCss($cssFile)    {        self::$_cssFiles[] = $cssFile;    }}