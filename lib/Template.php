<?php/** * SLIM_MVC_Framework * * @category  controllers * @package   SLIM_MVC_Framework * @copyright Copyright (c) 2014 (http://www.elamurugan.com/) * @author    Ela <nelamurugan@gmail.com> *//** * Class SLIM_MVC_Framework * * @category    controllers * @package     SLIM_MVC_Framework */class Template extends Layout{    public $model = false;    public static function clearCssJsCache($path = 'frontend')    {        $script = "rm -rf " . _BASEDIR . "var/cache/$path/*";        return system($script, $retval);    }    public function getSiteTitle()    {        return Config::$siteTitle;    }    public function _reInit()    {        if ($this->model == false) {            $this->model = Config::$model;        }    }    public function _templateInit()    {        $area = $this->getArea();        Config::$siteTitle = $this->getConfig('default/site_title');        $this->setPageTitle($this->getConfig('default/site_title'));        $this->setPageMetaDescription($this->getConfig('default/site_meta_description'));        $this->setPageMetaKeywords($this->getConfig('default/site_meta_keywords'));        $theme = $this->getConfig($area . '/default/theme');        if ($theme == '') {            $theme = $this->getTheme();        }        if (Config::$cacheFolder == '') {            Config::$cacheFolder = $this->getConfig('path/var_cache');        }        if (Config::$skinBasePath == '') {            Config::$skinBasePath = $this->getConfig('path/skin');        }        $themePath = $area . "/" . $theme . "/";        Config::$skinPath = Config::$skinBasePath . "/" . $themePath;        Config::$themePath = _APPDIR . "design/" . $themePath;        Config::$templatePath = _APPDIR . "design/" . $themePath . "template/";        Config::$cacheUrl = Config::$cacheFolder . $area . "/";        Config::$cachePath = _BASEDIR . Config::$cacheUrl;        Config::$cacheJsonFile = Config::$cachePath . "cache.json";        if (!is_writable(_BASEDIR . Config::$cacheFolder)) {            $this->log("Please Check skin directory path is writable");        }    }    public function renderTemplate($templateFile, $_inputData = array())    {        $blockConfig = array();        $blockConfig['name'] = 'email_template';        $blockConfig['template'] = $templateFile;        $blockConfig['email_block'] = $blockConfig['block_class'] = 'block/template';        $blockConfig['path'] = Config::$templatePath;        $_template_content = Slim::renderBlock($blockConfig, $_inputData);        return $_template_content;    }    // For normal response    public function renderHtml($resultParams = array(), $returnAsHtml = false)    {        return $this->renderTemplatesIntoHtml($resultParams, $returnAsHtml);    }    public function renderTemplatesIntoHtml($resultParams = array(), $returnAsHtml = false)    {        ob_start();        $this->prepareLayout();        if (count($resultParams)) {            foreach ($resultParams as $key => $resultParam) {                $this->setData($key, $resultParam);            }        }        $this->renderLayout();        if (@Config::$configData['css_compress'] == 1 || @Config::$configData['js_compress'] == 1) {            Helper::updateCacheFile(Config::$cacheJsonFile, Config::$cachedJson);        }        if (@Config::$configData['print_execution_order'] == "1") {            App::printAppFilesStack();        }        $_template_content = ob_get_contents();        ob_end_clean();        if (@Config::$configData['html_compress'] == 1) {            $helper = new Helper();            $_template_content = $helper->compressHtml($_template_content);        }        if ($returnAsHtml) {            return $_template_content;        } else {            echo $_template_content;        }    }    public function prepareXmlTemplates($type, $xmlChildObj, $xmlParentObj = false, $parentName = '')    {        if ($xmlChildObj && $xmlChildObj->$type != null) {            foreach ($xmlChildObj->$type as $xmlNode) {                $name = $this->getXmlAttributeValue($xmlNode, 'name');                if ($parentName == '' && $xmlParentObj && is_a($xmlParentObj, 'SimpleXMLElement')) {                    $parentName = $this->getXmlAttributeValue($xmlParentObj, 'name');                }                $template = $this->getXmlAttributeValue($xmlNode, 'template');                if ($this->getArea() == Config::$__adminArea) {                    $blockClass = $this->getXmlAttributeValue($xmlNode,                        'type',                        Config::ADMINHTML_AREA . '_block/template'                    );                } else {                    $blockClass = $this->getXmlAttributeValue($xmlNode, 'type', 'block/template');                }                $toHtml = (boolean)$this->getXmlAttributeValue($xmlNode, 'toHtml');                Config::$templates[$name] = array("template" => $template, 'block' => $xmlNode, 'block_class' => $blockClass, 'parent' => $parentName, 'toHtml' => $toHtml);                $this->prepareActionElements($xmlNode);                if ($xmlNode->$type != null) {                    $this->prepareXmlTemplates($type, $xmlNode, $xmlChildObj->$type);                }            }        }    }    public function updateXmlTemplates($type, $xmlObj)    {        if ($xmlObj && $xmlObj->$type != null) {            foreach ($xmlObj->$type as $xmlChildObj) {                $this->prepareActionElements($xmlChildObj);                if ($xmlChildObj->block != null) {                    $name = $this->getXmlAttributeValue($xmlChildObj, 'name');                    $this->prepareXmlTemplates('block', $xmlChildObj, $xmlObj->$type, $name);                }            }        }    }    public function prepareActionElements($xmlChildObj)    {        if ($xmlChildObj->action != null) {            $name = $this->getXmlAttributeValue($xmlChildObj, 'name');            foreach ($xmlChildObj->action as $actionObj) {                $actionStr = $this->getXmlAttributeValues($actionObj);                if (($template = (string)$actionStr->setTemplate) != null) {                    $this->setTemplate($name, $template);                } elseif (($addItemStr = (string)$actionStr->addItem) != null) {                    $this->addItem($actionStr);                }            }        }    }    public function updateTemplates()    {        foreach (Config::$templates as $templateName => $templateXmlObj) {            if (isset(Config::$templateUpdates[$templateName]['template'])) {                Config::$templates[$templateName]['template'] = Config::$templateUpdates[$templateName]['template'];            }        }    }    public function prepareLayout()    {        $area = $this->getArea();        $this->siteTitle = $this->getConfig('default/site_title');        $this->siteMetaKeywords = $this->getConfig('default/site_meta_keywords');        $this->siteMetaDescription = $this->getConfig('default/site_meta_description');        $layoutXmlPath = Config::$themePath . "layout/" . $this->getConfig($area . '/layout');        $this->layoutPrepare($layoutXmlPath);    }    public function renderLayout()    {        foreach (Config::$handles as $handle) {            $xmlChildObj = $this->getLayoutXml($handle, true);            $this->prepareXmlTemplates('block', $xmlChildObj, $handle);        }        foreach (Config::$handles as $handle) {            $xmlNode = $this->getLayoutXml($handle, true);            $this->updateXmlTemplates('reference', $xmlNode);        }        foreach (Config::$templates as $templateName => $templateXmlObj) {            unset(Config::$templates[$templateName]['block']);        }        //                debug(Config::$handles);        //                                debug(Config::$templates);        //        die();        $this->updateTemplates();        $this->getChildHtml('root');    }    public function getChildTemplates($parentName = '')    {        $childrens = array();        foreach (Config::$templates as $templateName => $templateXmlObj) {            if (isset($templateXmlObj['parent']) && $parentName == $templateXmlObj['parent']) {                $childrens[$templateName] = $templateXmlObj;            }        }        return $childrens;    }    public function getChildHtml($childName = '')    {        //        debug($childName . "-" . Config::$templatePath . Config::$templates[$childName]['template']);        $childrens = array();        if (isset(Config::$templates[$childName]['template'])) {            $childrens[$childName] = Config::$templates[$childName];            Config::$templateStack[$childName] = Config::$templates[$childName]['template'];        } else {            $references = array_keys(Config::$templateStack);            $referenceName = array_pop($references);            $childrens = $this->getChildTemplates($referenceName);        }        if (count($childrens)) {            foreach ($childrens as $childName => $children) {                $block = Config::$templates[$childName];                $block['name'] = $childName;                $block['path'] = Config::$templatePath;                Slim::createBlock($block);            }        }    }    public function renderJs()    {        $mergedJsFileName = $html = '';        Config::$_jsFiles = array_unique(Config::$_jsFiles);        if (@Config::$configData['js_compress'] == 1 && is_writable(Config::$cacheFolder)) {            Helper::makeDir(Config::$cachePath, true);            $currentJsFiles['files'] = implode(",", Config::$_jsFiles);            if (file_exists(Config::$cacheJsonFile)) {                if (Config::$cachedJson === false) {                    Config::$cachedJson = Helper::readCacheFile(Config::$cacheJsonFile);                }                if (Config::$cachedJson && is_array(Config::$cachedJson) && isset(Config::$cachedJson['js'])) {                    foreach (Config::$cachedJson['js'] as $jsMergedFile) {                        if ($currentJsFiles['files'] == $jsMergedFile['files']) {                            $mergedJsFileName = $jsMergedFile['merged'];                        }                    }                }            }            if ($mergedJsFileName == '' || !file_exists(Config::$cachePath . $mergedJsFileName)) {                include_once(_PUBDIR . "lib/thirdparty/jsmin.php");                $mergedJsFileName = Helper::generateRandomString() . '.js';                $jsContents = '';                foreach (Config::$_jsFiles as $jsFile) {                    if (file_exists(_PUBDIR . Config::$skinPath . $jsFile)) {                        $jsContents .= file_get_contents(_PUBDIR . Config::$skinPath . $jsFile);                    }                }                $jsContents = JSMin::minify($jsContents);                $handle = fopen(Config::$cachePath . $mergedJsFileName, 'w');                fwrite($handle, $jsContents);                fclose($handle);                $currentJsFiles['merged'] = $mergedJsFileName;                Config::$cachedJson['js'][] = $currentJsFiles;            }            $html .= sprintf('<script type="text/javascript" src="%s"></script>' . "\n",                _BASEURL . Config::$cacheUrl . $mergedJsFileName            );        } else {            foreach (Config::$_jsFiles as $jsFile) {                if (file_exists(_PUBDIR . Config::$skinPath . $jsFile)) {                    $html .= sprintf('<script type="text/javascript" src="%s"></script>' . "\n",                        _BASEURL . Config::$skinPath . $jsFile                    );                }            }        }        return $html;    }    public function renderCss()    {        $mergedCssFileName = $html = '';        Config::$_cssFiles = array_unique(Config::$_cssFiles);        if (@Config::$configData['css_compress'] == 1 && is_writable(Config::$cacheFolder)) {            Helper::makeDir(Config::$cachePath, true);            $cssMergedFiles = array();            $currentCssFiles['files'] = implode(",", Config::$_cssFiles);            if (file_exists(Config::$cacheJsonFile)) {                if (Config::$cachedJson === false) {                    Config::$cachedJson = Helper::readCacheFile(Config::$cacheJsonFile);                }                $cssMergedFiles = Config::$cachedJson;                if (Config::$cachedJson && is_array(Config::$cachedJson) && isset(Config::$cachedJson['css'])) {                    foreach (Config::$cachedJson['css'] as $cssMergedFile) {                        if ($currentCssFiles['files'] == $cssMergedFile['files']) {                            $mergedCssFileName = $cssMergedFile['merged'];                        }                    }                }            }            if ($mergedCssFileName == '' || !file_exists(Config::$cachePath . $mergedCssFileName)) {                $mergedCssFileName = Helper::generateRandomString() . '.css';                $cssContents = '';                foreach (Config::$_cssFiles as $cssFile) {                    if (file_exists(_PUBDIR . Config::$skinPath . $cssFile)) {                        $cssContents .= file_get_contents(_PUBDIR . Config::$skinPath . $cssFile);                    }                }                $cssContents = Helper::compressCss($cssContents, _BASEURL . Config::$skinPath);                $handle = fopen(Config::$cachePath . $mergedCssFileName, 'w');                fwrite($handle, $cssContents);                fclose($handle);                $currentCssFiles['merged'] = $mergedCssFileName;                Config::$cachedJson['css'][] = $currentCssFiles;            }            $html .= sprintf('<link rel="stylesheet" type="text/css" href="%s"/>' . "\n",                _BASEURL . Config::$cacheUrl . $mergedCssFileName            );        } else {            foreach (Config::$_cssFiles as $cssFile) {                if (file_exists(_PUBDIR . Config::$skinPath . $cssFile)) {                    $html .= sprintf('<link rel="stylesheet" type="text/css" href="%s"/>' . "\n",                        _BASEURL . Config::$skinPath . $cssFile                    );                }            }        }        return $html;    }}