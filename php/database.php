<php
    function connect(){
        $server="localhost";
        $username = "root";
        $password="";
        $db_name="mb_reserve";
        $conn = mysqli_connect($server,$username,$password,$db_name);
        return $conn;
    }

    function retrieve($column, $table){
        $conn=connect();
        $sql="SELECT $column FROM $table";
        $result=$conn->query($sql);
        return $result;
    }
?>