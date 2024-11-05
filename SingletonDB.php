<?php
class DbConnection {
    
    private $host="localhost";
    private $username="root";
    private $password="";
    private $db_name="aidcenter";// database name 
    private  $database_connection; 
    private static $instance;
public  static $Counter=0;

    private function __construct() {
      $this->database_connection = $this->database_connect($this->host, $this->username,$this->password,$this->db_name);
    
    }
    public static function getInstance(){// create only one object for databse 
        if(self::$instance==null){
          echo "Return New Instance";
            self::$instance=new DbConnection();
        }
        else 
        {
          echo "Object is there <br>";
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
}
