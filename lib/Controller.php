<?phpclass Controller extends Template{    public function redirectUrl($url)    {        if (!isset($_REQUEST['is_ajax'])) {            if (!headers_sent()) {                header("Location: " . $url . "");                exit;            } else {                echo "<script language='javascript' type='text/javascript'>window.location.href='" . $url . "'</script>";                echo "<META http-equiv='refresh' content='0;URL=" . $url . "'>";                exit;            }        }    }    public function redirect($url)    {        $baseUrlPath = _BASEURL;        if ($this->isAdminPath()) {            $baseUrlPath = $baseUrlPath . parent::$adminRoutePath . '/';        }        $this->redirectUrl($baseUrlPath . $url);    }    public function error404Action()    {        $this->renderHtml();    }}