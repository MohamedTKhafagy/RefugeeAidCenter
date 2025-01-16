<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

class DbConnection
{

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db_name = "aidcenter"; // database name 
    public  $database_connection;
    private static $instance;

    private function __construct()
    {
        $this->database_connection = $this->database_connect($this->host, $this->username, $this->password, $this->db_name);
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }

    public static function getInstance()
    { // create only one object for database 
        if (self::$instance == null) {
            self::$instance = new DbConnection();
        }
        return self::$instance;
    }

    public function query($sql, $params = [])
    {
        try {
            if (empty($params)) {
                $result = mysqli_query($this->database_connection, $sql);
                if (!$result) {
                    error_log("Query failed: " . mysqli_error($this->database_connection));
                    error_log("SQL: " . $sql);
                    return false;
                }
                return $result;
            }

            $stmt = $this->prepare($sql);
            if (!$stmt) {
                error_log("Prepare failed: " . mysqli_error($this->database_connection));
                error_log("SQL: " . $sql);
                return false;
            }

            // Determine types string
            $types = '';
            foreach ($params as $param) {
                if ($param === null) {
                    $types .= 's';
                } elseif (is_int($param)) {
                    $types .= 'i';
                } elseif (is_double($param) || is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
            }

            // Convert null values to actual NULL
            $params = array_map(function ($param) {
                return $param === null ? NULL : $param;
            }, $params);

            // Bind parameters
            if (!empty($params)) {
                $bindParams = array_merge([$stmt, $types], $params);
                call_user_func_array('mysqli_stmt_bind_param', $this->refValues($bindParams));
            }

            // Execute
            if (!mysqli_stmt_execute($stmt)) {
                error_log("Execute failed: " . mysqli_stmt_error($stmt));
                error_log("SQL: " . $sql);
                error_log("Params: " . print_r($params, true));
                mysqli_stmt_close($stmt);
                return false;
            }

            $result = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);

            if ($result === false && !preg_match('/^(INSERT|UPDATE|DELETE|REPLACE|CREATE|DROP|ALTER)/i', trim($sql))) {
                error_log("Get result failed: " . mysqli_error($this->database_connection));
                error_log("SQL: " . $sql);
                return false;
            }

            return $result !== false ? $result : true;
        } catch (Exception $e) {
            error_log("Database error: " . $e->getMessage());
            error_log("SQL: " . $sql);
            error_log("Params: " . print_r($params, true));
            throw $e;
        }
    }

    private function refValues($arr)
    {
        $refs = [];
        foreach ($arr as $key => $value) {
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }

    public function fetchAll($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        if ($result === false || $result === true) {
            return [];
        }
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

    private function database_select($database_name)
    {
        return mysqli_select_db($this->database_connection, $database_name)
            or die("No database is selected");
    }

    public function escape($string)
    {
        return mysqli_real_escape_string($this->database_connection, $string);
    }

    public function getBy($table, $field, $value, $numeric = false)
    {
        return $this->fetchAll(
            "SELECT * FROM $table WHERE $field = ?",
            [$value]
        );
    }

    public function prepare($sql)
    {
        $stmt = mysqli_prepare($this->database_connection, $sql);
        if (!$stmt) {
            error_log("Failed to prepare statement: " . mysqli_error($this->database_connection));
            error_log("SQL: " . $sql);
        }
        return $stmt;
    }
}
