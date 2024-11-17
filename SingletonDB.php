<?php
class DbConnection {
    
    private $host="localhost";
    private $username="root";
    private $password="";
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
     private function database_connect($database_host, $database_username, $database_password,$db_name) {
        if ($connection = mysqli_connect($database_host, $database_username, $database_password,$db_name)) {
    
            return $connection;
            
        } else {
                die("Database connection error");
            
        }
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
    
    //Fetch One Item from Select Query
    /*public function fetchOne($sql) {
        $result = $this->query($sql);
        return mysqli_fetch_assoc($result);
    }
    */  
}
