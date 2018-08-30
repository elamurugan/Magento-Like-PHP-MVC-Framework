<?php/** * SLIM_MVC_Framework * * @category  controllers * @package   SLIM_MVC_Framework * @copyright Copyright (c) 2014 (http://www.elamurugan.com/) * @author    Ela <nelamurugan@gmail.com> *//** * Class SLIM_MVC_Framework * * @category    controllers * @package     SLIM_MVC_Framework */class Model extends App{    public $conn = false;    public $executedQuery = false;    public $executedQueryString = '';    public $lastInsertId = 0;    public $numberOfRows = false;    public $resultSet;    protected $dataSet = array();    public function __construct()    {        $this->dbConnect();    }    public function dbConnect()    {        if (!$this->conn && Config::$dbDisabled == false) {            $this->conn = @mysqli_connect(Config::$__dbHostname, Config::$__dbUsername, Config::$__dbPassword, Config::$__dbName);            if (!$this->conn) {                $msg = 'Not connected : ' . mysqli_connect_error() . "#" . mysqli_connect_errno() . " Check with local.xml settings or reload db-install.sql  app/code/sql file";                $this->log($msg);                $this->printException(__FILE__, $msg);            }            $timeZone = $this->getSystemTimeZone();            $qry = 'SET time_zone = "' . $timeZone . '";';            $this->exec($qry);            $this->initConfigVariables();        } else {            Config::$configData = Config::$defaultConfigData;        }        return $this->conn;    }    public function exec($qry)    {        if (!$this->conn || !is_resource($this->conn)) {            $this->dbConnect();        }        $this->executedQuery = mysqli_query($this->conn, $qry);        $this->executedQueryString = $qry;        if (!$this->executedQuery) {            return mysqli_connect_error() . "#" . mysqli_connect_errno();        }        return $this->executedQuery;    }    public function getNumberOfROws()    {        if (!$this->numberOfRows = @mysqli_num_rows($this->executedQuery)) {            return mysqli_connect_error() . "#" . mysqli_connect_errno();        }        return $this->numberOfRows;    }    public function getTable($table)    {        $table = Config::$__dbTablePrefix . "" . $this->getConfig('db/tables/' . $table);        return $table;    }    public function getConfigData()    {        return Config::$configData;    }    public function fetch($qry, $asObject = false, $recordNo = null)    {        $result = $this->exec($qry);        $response = array();        if ($result) {            if ($asObject) {                while ($row = mysqli_fetch_object($result)) {                    $response[] = $row;                }            } else {                while ($row = mysqli_fetch_assoc($result)) {                    $response[] = $row;                }            }            if ($recordNo !== null) {                $response = @$response[$recordNo];            }        }        $this->resultSet = $response;        $this->setData("", $response);        return $this->resultSet;    }    /**     * @return array     */    public function getFirstItem()    {        if ($this->resultSet && count($this->resultSet)) {            return $this->resultSet[0];        }        return array();    }    /**     * @param        $table     * @param string $select     * @param string $conditions     * @param string $sort     * @param string $limit     * @param null $recordNo     * @param bool $asObject     * @return array     */    public function getCollection($table, $select = array(), $conditions = array(), $sort = array(), $limit = array(), $asObject = false, $recordNo = null)    {        $table = $this->getTable($table);        $result = array();        if ($table != '') {            $conditionStr = $selectStr = $sortStr = $limitStr = '';            if (!is_array($select) || count($select) == 0) {                $selectStr = ' * ';            } else {                foreach ($select as $column => $value) {                    if ($column != '' && !is_int($column)) {                        $selectStr .= " `$column` as '{$value}',";                    } else {                        $selectStr .= " {$value},";                    }                }                $selectStr = rtrim($selectStr, ",");            }            $qry = "SELECT  {$selectStr} FROM `{$table}` ";            if (is_array($conditions) && count($conditions) > 0) {                $conditionStr .= ' WHERE ';                foreach ($conditions as $column => $value) {                    $conditionStr .= " `{$column}` = '{$value}' AND";                }                $conditionStr = rtrim($conditionStr, "AND");            } elseif (is_string($conditions) && $conditions != '') {                $conditionStr = " WHERE   " . ((string)$conditions);            }            if (is_array($sort) && count($sort) > 0) {                foreach ($sort as $column => $value) {                    $sortStr = " {$column} {$value} ";                }                $sortStr .= ' ORDER BY ' . $sortStr;            }            if (is_array($limit) && count($limit) > 0) {                foreach ($limit as $column => $value) {                    $limitStr .= $value;                }                $limitStr = ' LIMIT ' . $limitStr;            }            $qry = $qry . $conditionStr . $sortStr . $limitStr;            $result = $this->fetch($qry, $asObject, $recordNo);        }        return $result;    }    /**     * @param       $table     * @param array $data     * @return int|string     */    public function insert($table, $data = array())    {        $table = $this->getTable($table);        if ($table != '' && is_array($data) && count($data)) {            $qry = "INSERT INTO   `{$table}`  ";            //            $columns = array_keys($data);            //            $values = array_values ($data);            $columns = ' (';            foreach ($data as $column => $value) {                //                $type = gettype($value);// If needs to be type casted                $columns .= " `{$column}`,";            }            $columns = rtrim($columns, ",") . ") ";            $values = ' VALUES (';            foreach ($data as $column => $value) {                $values .= " '{$value}',";            }            $values = rtrim($values, ",") . ") ";            $qry = $qry . $columns . $values;            return $this->exec($qry);        }        $this->lastInsertId = mysqli_insert_id($this->conn);        return $this->lastInsertId;    }    /**     * @param       $table     * @param array $data     * @param array $conditions     * @return int|string     */    public function update($table, $data = array(), $conditions = array())    {        $table = $this->getTable($table);        if ($table != '' && is_array($data) && count($data)) {            $qry = "UPDATE  `{$table}` SET ";            $columns = "";            foreach ($data as $column => $value) {                $columns .= " `{$column}` = '{$value}',";            }            $columns = rtrim($columns, ",");            $qry = $qry . $columns;            if (is_array($conditions) && count($conditions)) {                $qry .= ' WHERE ';                foreach ($conditions as $column => $value) {                    $qry .= " `{$column}` = '{$value}' AND";                }                $qry = rtrim($qry, "AND");            } elseif (is_string($conditions) && $conditions != '') {                $qry .= " WHERE  " . (string)$conditions;            }            return $this->exec($qry);        }        return false;    }    /**     * @param       $table     * @param array $conditions     * @return int|string     */    public function delete($table, $conditions = array())    {        $table = $this->getTable($table);        if ($table != '') {            $qry = "DELETE FROM  `{$table}`  ";            $qry .= ' WHERE ';            if (is_array($conditions) && count($conditions)) {                foreach ($conditions as $column => $value) {                    $qry .= " `{$column}` = '{$value}' AND";                }            } elseif (is_string($conditions) && $conditions != '') {                $qry .= "   " . (string)$conditions;            }            $qry = rtrim($qry, "AND");            return $this->exec($qry);        }        return false;    }    public function initConfigVariables()    {        $result = $this->getCollection("config", array("path" => "path", "value"));        $config = array();        foreach ($result as $row) {            $config[$row['path']] = $row['value'];        }        $result = array_merge(Config::$defaultConfigData, $config);        Config::$configData = $result;    }    public function createConfigVariable($path, $value)    {        $this->insert("config", array("path" => $path, "value" => $value));        return $this->initConfigVariables();    }    public function updateConfigVariable($path, $value)    {        $this->update("config", array("value" => $value), array("path" => $path));        return $this->initConfigVariables();    }    public function checkUrlRewriteAvailable($urlKey)    {        $_path = array();        $userExist = $this->checkUsernameExist($urlKey);        if ($userExist) {            $_path[0] = 'users';            $_path[1] = 'profileview';            $_path[2] = 'current_user';            $_path[3] = $urlKey;            Slim::register('current_user', $userExist);        } else {            $result = $this->getCollection("url_rewrites", array(), array("request_path" => $urlKey));            if (count($result)) {                $result = $this->getFirstItem();                $_path = @explode("/", $result['target_path']);            }        }        return $_path;    }    public function checkUsernameExist($username)    {        $result = $this->getCollection("users", array(), array("username" => $username));        if (count($result)) {            return $result[0];        } else {            return false;        }    }}