<?phpclass Model{     var $conn     = false;    var $run_qry  = false;    var $num_rows = false;    public function Model()    {        global $_url_params;        if (!$this->conn) {            $this->conn = @mysql_connect(_HOST, _USERNAME, _PASSWORD);            if (!$this->conn) {                die('Not connected : ' . mysql_error());            }            $select_db = @mysql_select_db(_DBNAME, $this->conn);            if (!$select_db) {                die('DB ' . _DBNAME . 'cannot be used' . mysql_error());            }            $qry = 'SET time_zone = "' . _TIME_ZONE . '";';            $this->query($qry);            $this->initConfigVariables();        }        return $this->conn;    }    public function initConfigVariables()    {        $qry = "SELECT path,value FROM `config` ";        $result = $this->fetch_assoc($qry);        $config = array();        foreach ($result as $row) {            $config[$row['path']] = $row['value'];        }        Template::$configData = $config;    }    public function updateConfigVariable($path, $value)    {        $qry = "update `config` set  value = '$value' where path = '$path'";        $result = $this->query($qry);        $this->initConfigVariables();    }    public function query($qry)    {        $this->run_qry = mysql_query($qry, $this->conn);        if (!$this->run_qry) {            return mysql_error();        }        return $this->run_qry;    }    public function insert($qry)    {        $result = $this->query($qry);        if (!$result) {            return mysql_error();        }        $id = mysql_insert_id($this->conn);        return $id;    }    public function number_of_rows()    {        if (!$this->num_rows = @mysql_num_rows($this->run_qry)) {            return mysql_error();        }        return $this->num_rows;    }    public function fetch_assoc($qry, $single_row = false)    {        $result = $this->query($qry);        $response = array();        if ($result) {            while ($row = mysql_fetch_assoc($result)) {                $response[] = $row;            }            if ($single_row) {                $response = @$response[0];            }        } else {            return $result;        }        return $response;    }    public function fetch_values($qry, $single_row = false)    {        $result = $this->query($qry);        $response = array();        if ($result) {            while ($row = mysql_fetch_assoc($result)) {                $response[] = $row;            }            if ($single_row) {                $response = @$response[0];            }        }        return $response;    }    public function checkUsernameExist($username)    {        $qry = "SELECT * FROM `users` where username = '$username'";        $result = $this->fetch_assoc($qry);        if (count($result)) {            return $result[0];        } else {            return false;        }    }    public function isUserLoggedIn()    {        return Template::getSession('user');    }    public function getLoggedInUser()    {        return Template::getSession('user');    }}