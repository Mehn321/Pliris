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
    include("header.php");

    if(isset($_POST["submit"])){
        $reserve_id = $_POST["reserve_id"];
        update('reservations',"returned_datetime=NOW(), reservation_status_ID=2","reserve_id='$reserve_id'");
        header("Location:reserved_items.php");
        
    }

    text_head("Reserved Items", $id_number);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserved Items</title>
    <link rel="stylesheet" href="../css/reserve_reserved_item.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="../pliris-admin/js/all.js" defer></script>
</head>
<body>
    <div class="container">
    <table>
            <tr class="row-border">
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Reserved Schedule</th>
                <th>Return Schedule</th>
                <th>Action</th>
            </tr>
            <?php
                $reserved_items = $conn->query("SELECT reservations.*, items.item_name, reservation_status.reservation_stat AS reservation_status FROM reservations 
                INNER JOIN items ON reservations.item_id = items.item_id
                INNER JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID
                WHERE reservations.id_number='$id_number' AND (reservation_status.reservation_stat='reserving' OR reservation_status.reservation_stat='disapproved')");
                while($row=$reserved_items->fetch_assoc()){
                    $reserve_id = $row['reserve_id'];
                    $quantity_reserved = $row['quantity_reserved'];
                    $scheduled_reserve_datetime =  new DateTime($row['scheduled_reserve_datetime']);
                    $scheduled_reserve_datetime= $scheduled_reserve_datetime->format('M-d-Y h:i:s:a');
                    $scheduled_return_datetime = new DateTime($row['scheduled_return_datetime']);
                    $scheduled_return_datetime = $scheduled_return_datetime->format('M-d-Y h:i:s:a');
                    $itemname = $row['item_name'];
                    $reservation_status = $row['reservation_status'];
                    
                    echo "
                    <tr class='row-border'>
                        <td>$itemname </td>
                        <td>$quantity_reserved</td>
                        <td>$scheduled_reserve_datetime</td>
                        <td>$scheduled_return_datetime</td>
                        <form action='reserved_items.php' method='post'>
                        <td>
                            <input type='hidden' name='reserve_id' value=$reserve_id>
                            <input type='hidden' name='reservation_status' value=$reservation_status>
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

