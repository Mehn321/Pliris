<?php   
    session_start();
    $id_number=$_SESSION['id_admin'];
    if (!isset($_SESSION['id_admin'])) {
        header("Location: ../index.php");
        exit;
    }
    if(isset($_POST['logout'])) {
        unset($_SESSION['id_admin']);
        header("Location: ../index.php");
        exit;
    }

    // function connect(){
    //     $server="localhost";
    //     $username = "root";
    //     $password="";
    //     $db_name="pliris";
    //     $conn = mysqli_connect($server,$username,$password,$db_name);
    //     return $conn;
    // }
    // function retrieve($column, $table){
    //     $conn=connect();
    //     $sql="SELECT $column FROM $table";
    //     $result=$conn->query($sql);
    //     return $result;
    // }

    include("database.php");
    
    if(isset($_POST["submit"])){
        $conn=connect();
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $item_id = $_POST['item_id'];
        if(!empty($_POST["itemname"])){
            $itemname=$_POST['itemname'];
            // $sql="UPDATE `items` SET item_name='$itemname' WHERE item_id='$item_id'";    
            // $conn->query($sql);
            update("`items`","item_name='$itemname'","item_id='$item_id'");
        }
        if(!empty($_POST["item_quantity"])){
            $item_quantity=$_POST['item_quantity'];
            // $sql="UPDATE `items` SET `item_quantity`='$item_quantity' WHERE item_id='$item_id'";
            // $conn->query($sql);
            update("`items`","item_quantity='$item_quantity'","item_id='$item_id'");
        }
    
        mysqli_close($conn);
        header("Location:items.php");
    }
    
    if(isset($_POST["delete"])){
        $item_id = $_POST['item_id'];
        $item=retrieve("*","items","item_id='$item_id'");
        $item_row=$item->fetch_assoc();
        $borrowed=$item_row["borrowed"];
        if($borrowed<=0){
            delete("items","item_id='$item_id'");
            header("Location:items.php");
        }else{
            echo"
            <script>
                alert('A user is still reserving the item please for the user to return the item or you can force the return of the item in the system using the reserved in the menu');
            </script>";
            header("Loaction: items.php");
        }
        
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items</title>
    <link rel="stylesheet" href="../css/items_records_reserved_returned.css">
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
        <div class="logout-container">
            <form action="" method="post">
            <button name="logout" value="logout">Log Out</button>
            </form>
        </div>
        </nav>

    </header>
    <div class="container">
    <table>
            <tr class="row-border">
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Reserved</th>
                <th>Remaining</th>
                <th>Action</th>
            </tr>
            <?php
                $items=retrieve("*","items",true,"item_name");
                while($row=$items->fetch_assoc()){
                    $itemname = $row['item_name'];
                    $item_quantity = $row['item_quantity'];
                    $borrowed = $row['borrowed'];
                    $remaining = $item_quantity - $borrowed;
                    $item_id = $row['item_id'];
                    if(isset($_POST["$item_id"])){
                        echo "
                        <tr class='row-border'>
                            <form action='items.php' method='post'>
                            <td class='itemname'>$itemname
                            <input type='text' name='itemname'>
                            </td>
                            <td>
                                $item_quantity <br>
                                <input type='number' name='item_quantity'>
                            </td>
                            <td>
                                $borrowed
                            </td>
                            <td>
                                $remaining
                            </td>
                            <td>
                                <input type='submit' name='submit'>
                            </td>
                                <input type='hidden' name='item_id' value='$item_id'>
                            </form>
                        </tr>
                        ";
                    }
                    elseif(isset($_POST["$item_id"])==false){
                    echo "
                    <tr class='row-border'>
                        <td class='itemname'>$itemname </td>
                        <td>$item_quantity</td>
                        <td>$borrowed</td>
                        <td>$remaining</td>
                        <form action='items.php' method='post'>
                        <td>
                            <input type='submit' name='$item_id' value='edit'>
                            <input type='submit' name='delete' value='delete'>
                            <input type='hidden' name='item_id' value=$item_id>
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
<script>
</script>

