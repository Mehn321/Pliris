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

    function retrieve($column, $table){
        $conn=connect();
        $sql="SELECT $column FROM $table";
        $result=$conn->query($sql);
        return $result;
    }
    $items=retrieve("*","items");
    
    if(isset($_POST["submit"])){
        $id = $_POST["id"];
        $quantity = $_POST["quantity"];
        $borrow_time=$_POST["borrow_time"];
        $return_time=$_POST["return_time"];
        $borrowed=$_POST["borrowed"]+$quantity;
        $conn=connect();
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql="UPDATE items SET borrowed=$borrowed WHERE id=$id";
        $conn->query($sql);

        try{
            $reserve ="INSERT INTO reserved(`id_number`,`id`,`quantity`,`borrow_time`,`return_time`) values('$id_number','$id','$quantity','$borrow_time','$return_time' )";
            $conn->query($reserve);
        }
        catch (mysqli_sql_exception $e) {
            $reserve="UPDATE reserved SET quantity=$quantity, borrow_time=$borrow_time, return_time=$return_time WHERE id=$id AND id_number='$id_number'";
            $conn->query($reserve);
        }

        mysqli_close($conn);
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
                while($row=$items->fetch_assoc()){
                    $itemname = $row['name'];
                    $quantity = $row['quantity'];
                    $borrowed = $row['borrowed'];
                    $category_id = $row['category_id'];
                    $remaining = $quantity - $borrowed;
                    $id = $row['id'];
                    if(isset($_POST["$id"])){
                        echo "
                        <tr class='row-border'>
                            <form action='seeAll_items.php' method='post'>
                            <td><img src='../images/ustplogo.png' alt='item image'></td>
                            <td>$itemname </td>
                            <td>
                                $quantity <br>
                                <label>quantity:</label>
                                <input type='number' name='quantity' required>
                            </td>
                            <td>
                                $borrowed <br>
                                <label>borrow time:</label>
                                <input type='datetime-local' name='borrow_time' required>
                            </td>
                            <td>
                                $remaining<br>
                                <label>return time:</label>
                                <input type='datetime-local' name='return_time' required>
                            </td>
                            </td>
                                <input type='hidden' name='id' value='$id'>
                            <td>
                                <input type='hidden' name='borrowed' value='$borrowed'>
                            <td>
                            <td>
                                <input type='submit' name='submit' value='submit' >
                            </td>
                            </form>
                        </tr>
                        ";
                    }
                    elseif(isset($_POST["$id"])==false){
                    echo "
                    <tr class='row-border'>
                        <td><img src='../images/ustplogo.png' alt='item image'></td>
                        <td>$itemname </td>
                        <td>$quantity</td>
                        <td>$borrowed</td>
                        <td>$remaining</td>
                        <form action='seeAll_items.php' method='post'>
                        <td>
                            
                            <input type='submit' name='$id' value='reserve'>
                        </td>
                        </form>
                    </tr>
                    ";
                    }
                }
            ?>
        </table>
    </div>

</body>
</html>

<?php

?>
