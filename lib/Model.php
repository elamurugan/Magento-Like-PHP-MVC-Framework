<?phpclass Model extends Core{    public $conn          = false;    public $executedQuery = false;    public $numberOfRows  = false;    public function Model()    {        if (!$this->conn && $this->dbDisabled == false) {            $this->_initDbSettings();            $this->conn = @mysql_connect(parent::$__dbHostname, parent::$__dbUsername, parent::$__dbPassword);            if (!$this->conn) {                $this->log('Not connected : ' . mysql_error());            }            $selectedDb = @mysql_select_db(parent::$__dbName, $this->conn);            if (!$selectedDb) {                $this->log('DB ' . parent::$__dbName . 'cannot be used. ' . mysql_error());            }            $timeZone = $this->getSystemTimeZone();            $qry = 'SET time_zone = "' . $timeZone . '";';            $this->exec($qry);            $this->initConfigVariables();        }        return $this->conn;    }    public function exec($qry)    {        $this->executedQuery = mysql_query($qry, $this->conn);        if (!$this->executedQuery) {            return mysql_error();        }        return $this->executedQuery;    }    public function insert($qry)    {        $result = $this->exec($qry);        if (!$result) {            return mysql_error();        }        $id = mysql_insert_id($this->conn);        return $id;    }    public function getNumberOfROws()    {        if (!$this->numberOfRows = @mysql_num_rows($this->executedQuery)) {            return mysql_error();        }        return $this->numberOfRows;    }    public function fetch($qry, $oneRecord = false)    {        $result = $this->exec($qry);        $response = array();        if ($result) {            while ($row = mysql_fetch_assoc($result)) {                $response[] = $row;                if ($oneRecord == true) {                    break;                }            }            if ($oneRecord) {                $response = @$response[0];            }        }        return $response;    }    public function getTable($table)    {        $table = $this->dbTablePrefix . "" . $this->getConfig('db/tables/' . $table);        return $table;    }    public function initConfigVariables()    {        $qry = "SELECT path,value FROM `config` ";        $result = $this->fetch($qry);        $config = array();        foreach ($result as $row) {            $config[$row['path']] = $row['value'];        }        Core::$configData = $config;    }    public function createConfigVariable($path, $value)    {        $qry = "update `config` set  value = '$value' where path = '$path'";        $result = $this->exec($qry);        $this->initConfigVariables();    }    public function updateConfigVariable($path, $value)    {        $qry = "update `config` set  value = '$value' where path = '$path'";        $result = $this->exec($qry);        $this->initConfigVariables();    }    public function checkUrlRewriteAvailable($urlKey)    {        $targetPath = @explode("/", $urlKey);        $this->__module = $targetPath[0];        $this->__action = $targetPath[1];    }    public function checkUsernameExist($username)    {        $qry = "SELECT * FROM `users` where username = '$username'";        $result = $this->fetch($qry);        if (count($result)) {            return $result[0];        } else {            return false;        }    }    public function isUserLoggedIn()    {        return Template::getSession('user');    }    public function getLoggedInUser()    {        return Template::getSession('user');    }}