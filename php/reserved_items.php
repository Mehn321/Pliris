<?php   
    session_start();
    $id_number=$_SESSION['id_number'];
    if (!isset($_SESSION['id_number'])) {
        header("Location: ../index.php");
        exit;
    }
    if(isset($_POST['logout'])) {
        unset($_SESSION['id_number']);
        header("Location: ../index.php");
        exit;
    }

    include("../Pliris-admin/php/database.php");

    

    if(isset($_POST["submit"])){
        $reserve_id = $_POST["reserve_id"];
        $conn=connect();
        
        // $sql = "SELECT * FROM reserved WHERE reserve_id='$reserve_id'";
        // $result = $conn->query($sql);
        $result=retrieve("*","reserved","reserve_id='$reserve_id'");

        if($result->num_rows > 0) {
            // $update_query = "UPDATE reserved SET return_stat='pending_return' WHERE reserve_id='$reserve_id'";
            // $insert_query = "INSERT INTO returned(`reserve_id`) values('$reserve_id')";
            // $conn->query($update_query);
            // $conn->query($insert_query);
            $return_stat=$_POST["return_stat"];
            if($return_stat=="disaproved"){
                update('reserved',"return_stat='pending_return'","reserve_id='$reserve_id'");
                // update("reserved","return_stat='pending_return","'$reserve_id'");
                
                header("Location:reserved_items.php");
            }
            else{
                update('reserved',"return_stat='pending_return'","reserve_id='$reserve_id'");
                insert("returned","`reserve_id`","'$reserve_id'");
                
                header("Location:reserved_items.php");
            }
            
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserved Items</title>
    <link rel="stylesheet" href="../css/reserve_reserved_item.css">
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

            <h2>Reserved Items</h2>

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
                $reserved=retrieve("*","reserved","id_number='$id_number' AND (return_stat='borrowing' OR return_stat='disaproved')");
                while($row=$reserved->fetch_assoc()){
                    $reserve_id=$row['reserve_id'];
                    $quantity = $row['quantity'];
                    $borrow_time = $row['borrow_time'];
                    $return_time = $row['return_time'];
                    $id = $row['id'];
                    $items = retrieve("item_name","items","id=$id");
                    $return_stat=$row['return_stat'];
                    $item_row = $items->fetch_assoc();
                    $itemname = $item_row['item_name'];
                    if($return_stat=='pending_return'){
                        continue;
                        // header("Refresh:0");
                    }

                    echo "
                    <tr class='row-border'>
                        <td>$itemname </td>
                        <td>$quantity</td>
                        <td>$borrow_time</td>
                        <td>$return_time</td>
                        <form action='reserved_items.php' method='post'>
                        <td>
                            <input type='hidden' name='reserve_id' value=$reserve_id>
                            <input type='hidden' name='return_stat' value=$return_stat>
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
