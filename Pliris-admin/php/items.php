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

    include("database.php");

    if(isset($_POST["submit"])){
        $conn=connect();
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $item_id = $_POST['item_id'];
        if(!empty($_POST["itemname"])){
            $itemname=$_POST['itemname'];
            update("items","item_name='$itemname'","item_id='$item_id'");
        }
        if(!empty($_POST["item_quantity"])){
            $item_quantity=$_POST['item_quantity'];
            update("items","item_quantity='$item_quantity'","item_id='$item_id'");
        }
    
        mysqli_close($conn);
        header("Location:items.php");
    }
    
    if(isset($_POST["delete"])){
        $conn=connect();
        $item_id = $_POST['item_id'];
        $item=mysqli_query($conn, "SELECT items.item_id, items.item_name, items.item_quantity, items.item_quantity_reserved, active_status.active_stat 
        FROM items 
        JOIN active_status ON items.active_status_ID = active_status.active_status_ID 
        WHERE items.item_id = $item_id");
        $item_row=mysqli_fetch_assoc($item);
        $quantity_reserved=$item_row["quantity_reserved"];
        if($quantity_reserved<=0){
            update("items","active_status_ID='2'","item_id='$item_id'");
            header("Location:items.php");
        }else{
            echo"
            <script>
                alert('A user is still reserving the item please for the user to return the item or you can force the return of the item in the system using the reservations in the menu');
            </script>";
            header("Location: items.php");
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
        include("header.php");
        text_head("items");
    ?>
    
    <div class="container">
    <table>
            <tr class="row-border">
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Reservations</th>
                <th>Action</th>
            </tr>
            <?php
                $conn=connect();
                $items=mysqli_query($conn, "SELECT items.item_id, items.item_name, items.item_quantity, items.item_quantity_reserved, active_status.active_stat 
                FROM items 
                JOIN active_status ON items.active_status_ID = active_status.active_status_ID 
                WHERE active_status.active_stat='active'
                ORDER BY items.item_name");
                while($row=mysqli_fetch_assoc($items)){
                    $itemname = $row['item_name'];
                    $item_quantity = $row['item_quantity'];
                    $quantity_reserved = $row['item_quantity_reserved'];
                    $item_id = $row['item_id'];
                    if(isset($_POST["$item_id"])){
                        echo "
                        <tr class='row-border'>
                            <form action='items.php' method='post'>
                            <td class='itemname'>
                                <input type='text' name='itemname' value='$itemname'>
                            </td>
                            <td>
                                <input type='number' name='item_quantity' value='$item_quantity'>
                            </td>
                            <td>
                                $quantity_reserved
                            </td>
                            <td>
                                <input type='submit' name='submit'>
                            </td>
                                <input type='hidden' name='item_id' value='$item_id'>
                            </form>
                        </tr>
                        ";
                    }


                    elseif(!isset($_POST["$item_id"])){
                    echo "
                    <tr class='row-border'>
                        <td class='itemname'>$itemname </td>
                        <td>$item_quantity</td>
                        <td>$quantity_reserved</td>
                        <form action='items.php' method='post'>
                        <td>
                            <input type='submit' name='$item_id' value='edit'>
                            <input type='submit' name='delete' value='delete' onclick=\"return confirm('Are you sure you want to delete this item?');\">
                            <input type='hidden' name='item_id' value=$item_id>
                        </td>
                        </form>
                    </tr>
                    ";
                    }
                }
                mysqli_close($conn);
            ?>
        </table>
    </div>

</body>
</html>
<script>
</script>

