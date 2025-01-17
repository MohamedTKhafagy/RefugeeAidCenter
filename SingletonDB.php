<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

class DbConnection {
    
    private $host="localhost";
    private $username="root";
    private $password="1234";
    private $db_name="aidcenter";// database name 
    public  $database_connection; 
    private static $instance;

    private function __construct() {
      $this->database_connection = $this->database_connect($this->host, $this->username,$this->password,$this->db_name);
    
    }
    public static function getInstance(){// create only one object for databse 
        if(self::$instance==null){
            self::$instance=new DbConnection();
        }
        return self::$instance;
    }
    public function query($sql) {
        $result = mysqli_query($this->database_connection, $sql);
        if (!$result) {
            die("Query failed: " . mysqli_error($this->database_connection));
        }
        return $result;
    }

    //Fetch results of select Queries
    public function fetchAll($sql) {
        $result = $this->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    private function database_connect($database_host, $database_username, $database_password, $db_name)
    {
        if ($connection = mysqli_connect($database_host, $database_username, $database_password, $db_name)) {

            return $connection;
        } else {
                die("Database connection error");
            
        }
    }
        /**
     * select a db
     *
     * @param string $database_name
     * @return mysql link
     */
    private function database_select($database_name) {
      
        return mysqli_select_db( $this->database_connection,$database_name)
            or die("No database is selecteted");
        
    }
    public function escape($string) {
        return mysqli_real_escape_string($this->database_connection, $string);
    }

    public function getBy($table, $field, $value, $numeric = false) {
        $value = $this->escape($value);
        $sql = ($numeric) ? "SELECT * FROM $table WHERE $field = $value" : "SELECT * FROM $table WHERE $field = '$value'";
        $rows = $this->query($sql);
        if(mysqli_num_rows($rows) == 0) return null;
        return mysqli_fetch_assoc($rows);
    }
     
    public function prepare($sql) {
        $stmt = mysqli_prepare($this->database_connection, $sql);
        if (!$stmt) {
            die("Failed to prepare statement: " . mysqli_error($this->database_connection));
        }
        return $stmt;
    }

}
