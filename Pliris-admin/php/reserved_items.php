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
        $reserve_id = $_POST["reserve_id"];
        $conn=connect();
        // $reservation_status=$_POST["reservation_status"];
        // if($reservation_status=="disapproved"){
        //     update('reservation_status',"reservation_stat='pending_return',returned_datetime=NOW()'","reserve_id='$reserve_id'");
        //     header("Location:reserved_items.php");
        // }
        // else{
            // If the reserve_id does not exist, insert it into the returned table
            update('reservations',"returned_datetime=NOW(), reservation_status_ID=2","reserve_id='$reserve_id'");
            header("Location:reserved_items.php");
            
            // }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserved Items</title>
    <link rel="stylesheet" href="../css/items_records_reserved_returned.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <?php
        include("header.php");
        text_head("Reserved Items");
    ?>
    <div class="container">
    <table>
            <tr class="row-border">
                <th>Borrower</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Reserved Schedule</th>
                <th>Return Schedule</th>
                <th>Action</th>
            </tr>
            <?php
                $sql="SELECT reservations.*, items.item_name, accounts.first_name 
                    FROM reservations 
                    JOIN items ON reservations.item_id = items.item_id 
                    JOIN accounts ON reservations.id_number = accounts.id_number 
                    JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID
                    WHERE reservation_status.reservation_stat = 'reserving' OR reservation_status.reservation_stat = 'disapproved'
                ";
                $reservations = $conn->query($sql);
                while($row = $reservations->fetch_assoc()){
                    $reserve_id = $row['reserve_id'];
                    $quantity_reserved = $row['quantity_reserved'];
                    $scheduled_reserve_datetime =  new DateTime($row['scheduled_reserve_datetime']);
                    $scheduled_reserve_datetime= $scheduled_reserve_datetime->format('M-d-Y h:i:s:a');
                    $scheduled_return_datetime = new DateTime($row['scheduled_return_datetime']);
                    $scheduled_return_datetime = $scheduled_return_datetime->format('M-d-Y h:i:s:a');
                    $itemname = $row['item_name'];
                    $first_name = $row['first_name'];
                    echo "
                    <tr class='row-border'>
                        <td>$first_name</td>
                        <td>$itemname </td>
                        <td>$quantity_reserved</td>
                        <td>$scheduled_reserve_datetime</td>
                        <td>$scheduled_return_datetime</td>
                        <form action='reserved_items.php' method='post'>
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