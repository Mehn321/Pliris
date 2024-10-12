<?php
    function connect(){
        $server="localhost";
        $username = "root";
        $password="";
        $db_name="mb_reserve";
        $conn = mysqli_connect($server,$username,$password,$db_name);
        return $conn;
    }

    function insert($table, $data) {
        $conn = connect();
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }

    function retrieve($column, $table, $where){
        $conn=connect();
        $sql="SELECT $column FROM $table WHERE $where";
        $result=$conn->query($sql);
        $conn->close();
        return $result;
    }

    // Update function
    function update($table, $data, $where) {
        $conn = connect();
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = '$value'";
        }
        $set = implode(", ", $set);
        $sql = "UPDATE $table SET $set WHERE $where";
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }

    // Delete function
    function delete($table, $where) {
        $conn = connect();
        $sql = "DELETE FROM $table WHERE $where";
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }

?>