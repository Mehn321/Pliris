<?php

class Database {
    public $conn;
    
    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'pliris');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function insert($table, $columns, $data) {
        $sql = "INSERT INTO $table ($columns) VALUES ($data)";
        return $this->conn->query($sql);
    }

    public function retrieve($column, $table, $where = '1=1', $order = null) {
        $sql = "SELECT $column FROM $table WHERE $where";
        if ($order) {
            $sql .= " ORDER BY $order";
        }
        return $this->conn->query($sql);
    }

    public function update($table, $set, $where) {
        $sql = "UPDATE $table SET $set WHERE $where";
        return $this->conn->query($sql);
    }

    public function delete($table, $where) {
        $sql = "DELETE FROM $table WHERE $where";
        return $this->conn->query($sql);
    }

    public function getconnection() {
        return $this->conn;
    }

    public function count($table, $where = '1=1') {
        $sql = "SELECT COUNT(*) as count FROM $table WHERE $where";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['count'];
    }

    public function exists($table, $where) {
        $sql = "SELECT 1 FROM $table WHERE $where LIMIT 1";
        $result = $this->conn->query($sql);
        return $result->num_rows > 0;
    }

    public function beginTransaction() {
        $this->conn->begin_transaction();
    }

    public function commit() {
        $this->conn->commit();
    }

    public function rollback() {
        $this->conn->rollback();
    }

    public function getLastInsertId() {
        return $this->conn->insert_id;
    }

    public function escape($string) {
        return $this->conn->real_escape_string($string);
    }
}
