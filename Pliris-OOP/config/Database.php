
<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "pliris";
    private $connection;

    public function connect() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        return $this->connection;
    }

    public function retrieve($column, $table, $where=true, $order=null) {
        $conn = $this->connect();
        $sql = "SELECT $column FROM $table WHERE $where";
        if(isset($order)) {
            $sql .= " ORDER BY $order";
        }
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }

    public function insert($table, $columns, $data) {
        $conn = $this->connect();
        $sql = "INSERT INTO $table ($columns) VALUES ($data)";
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }

    public function update($table, $set, $where) {
        $conn = $this->connect();
        $sql = "UPDATE $table SET $set WHERE $where";
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }

    public function delete($table, $where) {
        $conn = $this->connect();
        $sql = "DELETE FROM $table WHERE $where";
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }

    public function query($sql) {
        $conn = $this->connect();
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }
    
    public function getConnection() {
        return $this->connection;
    }
}
