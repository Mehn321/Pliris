<?php

class Database {
    public $conn;

    // Constructor establishes a connection to the database
    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'pliris');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // public function __construct() {
    //     $db_host = getenv('PGHOST');
    //     $db_port = getenv('PGPORT');
    //     $db_name = getenv('PGDATABASE');
    //     $db_user = getenv('PGUSER');
    //     $db_pass = getenv('PGPASSWORD');

    //     try {
    //         $dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name;";
    //         $this->conn = new PDO($dsn, $db_user, $db_pass);
    //         $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     } catch (PDOException $e) {
    //         die("Connection failed: " . $e->getMessage());
    //     }
    // }

    // Insert data into a specified table
    public function insert($table, $columns, $data) {
        $sql = "INSERT INTO $table ($columns) VALUES ($data)";
        return $this->conn->query($sql);
    }

    // Retrieve data from a specified table
    public function retrieve($column, $table, $where = '1=1', $order = null) {
        $sql = "SELECT $column FROM $table WHERE $where";
        if ($order) {
            $sql .= " ORDER BY $order";
        }
        return $this->conn->query($sql);
    }

    // Update data in a specified table
    public function update($table, $set, $where) {
        $sql = "UPDATE $table SET $set WHERE $where";
        return $this->conn->query($sql);
    }

    // Delete data from a specified table
    public function delete($table, $where) {
        $sql = "DELETE FROM $table WHERE $where";
        return $this->conn->query($sql);
    }

    // Get database connection
    public function getconnection() {
        return $this->conn;
    }

    // Count rows in a specified table
    public function count($table, $where = '1=1') {
        $sql = "SELECT COUNT(*) as count FROM $table WHERE $where";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['count'];
    }

    // Check if a record exists in a specified table
    public function exists($table, $where) {
        $sql = "SELECT 1 FROM $table WHERE $where LIMIT 1";
        $result = $this->conn->query($sql);
        return $result->num_rows > 0;
    }
}
