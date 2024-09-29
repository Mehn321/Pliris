<?php   
    session_start();
    $id_number=$_SESSION['id_number'];
    if (!isset($_SESSION['id_number'])) {
        header("Location: login.php");
        exit;
    }

    function connect(){
        $server="localhost";
        $username = "root";
        $password="";
        $db_name="mb_reserve";
        $conn = mysqli_connect($server,$username,$password,$db_name);
        return $conn;
    }

    function retrieve($column, $table, $where){
        $conn=connect();
        $sql="SELECT $column FROM $table WHERE $where";
        $result=$conn->query($sql);
        return $result;
    }
    $reserved=retrieve("*","reserved","id_number=$id_number");

    if(isset($_POST["submit"])){
        $reserve_id = $_POST["reserve_id"];
        $conn=connect();
        
        // Check if the reserve_id exists in the reserved table
        $check_query = "SELECT * FROM reserved WHERE reserve_id='$reserve_id'";
        $result = $conn->query($check_query);
        
        if($result->num_rows > 0) {
            $update_query = "UPDATE reserved SET return_stat='1' WHERE reserve_id='$reserve_id'";
            $insert_query = "INSERT INTO returned(`reserve_id`,`returned_time`) values('$reserve_id',NOW() )";
            $conn->query($update_query);
            $conn->query($insert_query);
            
        mysqli_close($conn);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/seeAll_items.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <?php
        include("sidebar.php");
    ?>
    <header class="header">
        <nav class="navbar">
            <button class="menu" onclick=showsidebar()>
                <img src="../images/menuwhite.png" alt="menu"height="40px" width="45" >
            </button>

            <h2>All Items</h2>
            <!-- <ul>
                <li><a href="#">CHEMICAL</a></li>
                <li><a href="#">LABARATORY APARATUS</a></li>
                <li><a href="#">DIVING INSTRUMENTS</a></li>
                <li><a href="#"></a></li>
            </ul> -->

        <div class="logout-container">
            <button>Log Out</button>
        </div>
        </nav>

    </header>
    <div class="container">
    <table>
            <tr class="row-border">
                <th>Picture</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Borrowed</th>
                <th>Remaining</th>
                <th>Action</th>
            </tr>
            <?php
                while($row=$reserved->fetch_assoc()){
                    $reserve_id=$row['reserve_id'];
                    $quantity = $row['quantity'];
                    $borrow_time = $row['borrow_time'];
                    $return_time = $row['return_time'];
                    $id = $row['id'];
                    $items = retrieve("name","items","id=$id");
                    $return_stat=$row['return_stat'];
                    $row = $items->fetch_assoc();
                    $itemname = $row['name'];
                    if($return_stat=='1'){
                        continue;
                        // header("Refresh:0");
                    }

                    echo "
                    <tr class='row-border'>
                        <td><img src='../images/ustplogo.png' alt='item image'></td>
                        <td>$itemname </td>
                        <td>$quantity</td>
                        <td>$borrow_time</td>
                        <td>$return_time</td>
                        <form action='borrowed_items.php' method='post'>
                        <td>
                            <input type='hidden' name='reserve_id' value=$reserve_id>
                            <input type='submit' name='submit' value='return'>
                        </td>
                        </form>
                    </tr>
                    ";
                    }
            ?>
        </table>
    </div>

</body>
</html>

<?php

?>
