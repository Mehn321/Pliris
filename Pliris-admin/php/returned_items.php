<?php
session_start();
$id_number = $_SESSION['id_admin'];
if (!isset($_SESSION['id_admin'])) {
    header("Location: ../index.php");
    exit;
}
if (isset($_POST['logout'])) {
    unset($_SESSION['id_admin']);
    header("Location: ../index.php");
    exit;
}

include("database.php");


$conn = connect();
if (isset($_POST["approve"])) {
    $reserve_id = $_POST["reserve_id"];
    $quantity_reserved = $_POST['quantity_reserved'];
    date_default_timezone_set('Asia/Manila');
    $currentTime = date('M-d-Y h:i:s:a');

    $sql = "SELECT items.item_id, items.item_quantity_reserved, accounts.id_number, items.item_name
        FROM reservations
        INNER JOIN items ON reservations.item_id = items.item_id
        INNER JOIN accounts ON reservations.id_number = accounts.id_number
        WHERE reservations.reserve_id = '$reserve_id'
    ";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $item_id = $row['item_id'];
    $id_number = $row['id_number'];
    $itemname = $row["item_name"];
    $item_quantity_reserved = $row['item_quantity_reserved'];

    $message = "Your reservation_status item $itemname with the quantity_reserved of $quantity_reserved has been approved at $currentTime.";

    if ($result->num_rows > 0) {
        $sql = "SELECT * FROM records WHERE reserve_id = '$reserve_id'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            insert("records", "`reserve_id`,`id_number`, `item_id`", "'$reserve_id', '$id_number','$item_id'");
            insert("notifications", "id_number, notification_status_id, message", "'$id_number',1, '$message'");
        }
        $newtotal_item_quantity_reserved = $item_quantity_reserved - $quantity_reserved;
        update("items", "item_quantity_reserved='$newtotal_item_quantity_reserved'", "item_id='$item_id'");
        // update("reservation_status", "reservation_stat='approved'", "reserve_id='$reserve_id'");
        update('reservations'," reservation_status_ID=3 ","reserve_id='$reserve_id'");
        header("Location: returned_items.php");
    }
}

if (isset($_POST["disapprove"])) {
    $reserve_id = $_POST["reserve_id"];

    $sql = "
        SELECT reservations.item_id, reservations.id_number, items.item_name
        FROM reservations
        INNER JOIN items ON reservations.item_id = items.item_id
        WHERE reservations.reserve_id = '$reserve_id'
    ";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $itemname = $row["item_name"];
    $item_id = $row['item_id'];
    $id_number = $row['id_number'];
    $quantity_reserved = $_POST['quantity_reserved'];
    date_default_timezone_set('Asia/Manila');
    $currentTime = date('M-d-Y h:i:s:a');
    $accounts = $conn->query("SELECT first_name, last_name FROM accounts WHERE id_number='999999999'");
    $fullname_row = $accounts->fetch_assoc();
    $admin_firstname = $fullname_row["first_name"];
    $admin_lastname = $fullname_row["last_name"];

    $message = "Your reservation_status item $itemname with the quantity of $quantity_reserved is disapproved at $currentTime. Please return the item/items or you can approach the moderator Mr/Maam: $admin_firstname $admin_lastname.";
    // update("reservation_status", "reservation_stat='disapproved'", "reserve_id='$reserve_id'");
    update('reservations',"reservation_status_ID=4","reserve_id='$reserve_id'");
    insert("notifications", "id_number, notification_status_id, message", "'$id_number',1 , '$message'");
    header("Location: returned_items.php");
}

include("header.php");
text_head("Returned Items");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returned Items</title>
    <link rel="stylesheet" href="../css/items_records_reserved_returned.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
<div class="container">
    <table>
        <tr class="row-border">
            <th>Borrower</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Returned Time</th>
            <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT reservation_status.reservation_status_ID, reservations.reserve_id, reservations.returned_datetime, reservations.reservation_status_ID, reservations.quantity_reserved, accounts.first_name, accounts.last_name, items.item_name 
                FROM reservation_status 
                INNER JOIN reservations ON reservation_status.reservation_status_ID = reservations.reservation_status_ID 
                INNER JOIN accounts ON reservations.id_number = accounts.id_number 
                INNER JOIN items ON reservations.item_id = items.item_id
                WHERE reservation_status.reservation_stat = 'pending_return'";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $returned_datetime = new DateTime($row['returned_datetime']);
            $returned_datetime = $returned_datetime->format('M-d-Y h:i:s:a');
            $quantity_reserved = $row['quantity_reserved'];
            $reserver_firstname = $row['first_name'];
            $itemname = $row['item_name'];
            $reserve_id = $row['reserve_id'];
            $reservation_status_ID = $row['reservation_status_ID'];
            echo "
            <tr class='row-border'>
                <td>$reserver_firstname</td>
                <td>$itemname </td>
                <td>$quantity_reserved</td>
                <td>$returned_datetime</td>
                <form action='returned_items.php' method='post'>
                <td>
                    <input type='hidden' name='quantity_reserved' value=$quantity_reserved>
                    <input type='hidden' name='reserve_id' value=$reserve_id>
                    <input type='hidden' name='returned_datetime' value=$returned_datetime>
                    <input type='hidden' name='reservation_status_ID' value=$reservation_status_ID>
                    <input type='submit' name='approve' value='approve'>
                    <input type='submit' name='disapprove' value='disapprove'>
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
