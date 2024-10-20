<?php
    function connect(){
        $server="localhost";
        $username = "root";
        $password="";
        $db_name="mb_reserve";
        $conn = mysqli_connect($server,$username,$password,$db_name);
        return $conn;
    }

    $conn=connect();
    
    function insert($table, $columns, $data) {
        $conn = connect();
        $sql = "INSERT INTO $table ($columns) VALUES ($data)";
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }

    function retrieve($column, $table, $where=true, $order=null){
        $conn=connect();
        $sql="SELECT $column FROM $table WHERE $where";
        if(isset($order)){
            $sql .=" ORDER BY $order";
        }
        $result=$conn->query($sql);
        $conn->close();
        return $result;
    }

    // Update function
    function update($table, $set, $where) {
        $conn = connect();
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