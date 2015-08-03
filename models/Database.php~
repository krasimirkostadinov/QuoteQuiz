<?php

namespace models;
require ROOT_PATH . '/config.php';
/**
 * Database use \PDO driver and contain all necessary methods and functions
 * for DB manipulations. Created methods dealing with _stmt for easier
 * data manipulation. Such as: getAffectedRows(), fetchAllAssoc,
 * getSqlInterpolated() and other.
 *
 * @author Krasimir Kostadinov
 */
class Database {

    protected $connection = 'default';
    private $_db = null;
    private $_stmt = null;
    private $params = array();
    private $_sql;
    private static $_connections = array();

    /**
     * Instance
     * @var \models\Database
     */
    private static $_instance = null;

    /**
     * Set DB connection configuration
     * @var array
     */
    protected static $_cnf = array(
        'default' => array(
            'connection_uri' => 'mysql:host=localhost;dbname=xml_parser;port=3306',
            'username' => DB_USER,
            'password' => DB_PASS,
            'settings' => array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                \PDO::ATTR_PERSISTENT => true
            )
        )
    );

    /**
     * Database Construct
     * @param string\PDO $connection
     */
    public function __construct($connection = null) {
        if ($connection instanceof \PDO) {
            $this->_db = $connection;
        }
        else if ($connection !== null) {
            $this->_db = self::getConnection($connection);
            $this->connection = $connection;
        }
        else {
            $this->_db = self::getConnection($this->connection);
        }
    }

    /**
     * Get connection for Database
     * @param string $connection
     * @return \PDO
     * @throws \Exception
     */
    public function getConnection($connection = 'default') {
        if (!$connection) {
            throw new \Exception('It is not have connection identifier', 500);
        }
        if (isset(self::$_connections[$connection])) {
            return self::$_connections[$connection];
        }

        $dbh = new \PDO(
                self::$_cnf[$connection]['connection_uri'], 
                self::$_cnf[$connection]['username'],
                self::$_cnf[$connection]['password'],
                self::$_cnf[$connection]['settings']
        );
        self::$_connections[$connection] = $dbh;
        return $dbh;
    }

    /**
     * Get Instance of Database
     * @return \models\Database Database instance
     */
    public static function getInstance($connection = 'default') {
        if (self::$_instance === NULL) {
            try {
                self::$_instance = new \PDO(
                        self::$_cnf[$connection]['connection_uri'],
                        self::$_cnf[$connection]['username'],
                        self::$_cnf[$connection]['password'],
                        self::$_cnf[$connection]['settings']
                );
            } catch (PDOException $e) {
                throw new \Exception('Error during PDO instanse [' . $e->getMessage() . ']');
            }
        }
        return self::$_instance;
    }

    /**
     *
     * @param string $data
     * @param string $types int|string|trim|strip_tags|specialchars
     * @return string
     */
    public static function validateData($data, $types) {
        $types = explode('|', $types);
        if (is_array($types)) {
            foreach ($types as $v) {
                if ($v === 'int') {
                    $data = (int) $data;
                }
                if ($v === 'string') {
                    $data = (string) $data;
                }
                if ($v === 'trim') {
                    $data = trim($data);
                }
                if ($v === 'strip_tags') {
                    $data = strip_tags($data);
                }
                if ($v === 'specialchars') {
                    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
                }
                if ($v === 'filter_special_chars') {
                    $data = str_replace(str_split('<>"&*~|<>#@$%^()!?+-=/\\`.,:;_' . "'" . ''), ' ', $data);
                }
            }
        }
        return $data;
    }

    /**
     * Prepares a statement for execution
     * @param string $query SQL query String
     * @param array $params Array with query params.
     * Example: Array('key'=>'value')
     * @param array $pdoOptions PDO driver_options
     * @return \models\Database
     */
    public function prepare($query, $params = array(), $pdoOptions = array()) {
        $this->_stmt = $this->_db->prepare($query, $pdoOptions);
        $this->params = $params;
        $this->_sql = $query;
        return $this;
    }

    /**
     * Executes a prepared statement
     * @param array $params Array with query params.
     * Example: Array('placeholder'=>'name') for named placeholders or values for ? placeholders
     * @return \models\Database
     */
    public function execute($params = array()) {
        if ($params) {
            $this->params = $params;
        }
        $this->_stmt->execute($this->params);
        return $this;
    }

    /**
     * Get all rows as array indexed by column name as returned in the result set
     * @return array
     */
    public function fetchAllAssoc() {
        return $this->_stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Fetches the next row from a result set as assoc array
     * @return array
     */
    public function fetchRowAssoc() {
        return $this->_stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Get last insert id in DB table
     * @return int
     */
    public function getLastInsertId() {
        return $this->_db->lastInsertId();
    }

    /**
     * Returns the number of rows affected by the last SQL query
     * @return int
     */
    public function getAffectedRows() {
        return $this->_stmt->rowCount();
    }

    /**
     * Get STMT
     * @return \PDOStatement
     */
    public function getSTMT() {
        return $this->_stmt;
    }

    /**
     * Get SQL query as string.
     * @return string Return query string
     */
    public function getSql() {
        return $this->_sql;
    }

    /**
     * Replaces any parameter placeholders in a query with the value of that parameter.
     * This is mainly used for code debugging
     * @return string The interpolated query
     */
    public function getSqlInterpolated() {
        $params = $this->params;
        $keys = array();
        $values = array();
        foreach ($params as $key => $value) {
            $keys[] = (is_string($key)) ? '/:' . $key . '/' : '/[?]/';
            $values[$key] = (is_string($value)) ? '"' . $value . '"' : $value;
        }
        $query = preg_replace($keys, $values, $this->_sql, 1, $count);
        return $query;
    }

}
