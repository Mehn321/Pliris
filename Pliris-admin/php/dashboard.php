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
    
    $query_all_items = "SELECT COUNT(item_name) as total FROM items";
    $all_items_result = $conn->query($query_all_items);
    $all_items_row = $all_items_result->fetch_assoc();
    $quantity_of_allitems = $all_items_row['total'];

    $query_reserved_items = "SELECT COUNT(reservations.reservation_status_ID) as total FROM reservations 
                            JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID 
                            WHERE reservation_status.reservation_stat='reserving'";
    $reserved_items_result = $conn->query($query_reserved_items);
    $reserved_items_row = $reserved_items_result->fetch_assoc();
    $borrowed_itemsquantity = $reserved_items_row['total'] ;

    $query_returned_items = "SELECT COUNT(reservations.reservation_status_ID) as total FROM reservations 
                            JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID 
                            WHERE reservation_status.reservation_stat='pending_return'";
    $returned_items_result = $conn->query($query_returned_items);
    $returned_items_row = $returned_items_result->fetch_assoc();
    $returned_items_quantity = $returned_items_row['total'];

    $query_accounts = "SELECT COUNT(id_number) as total FROM accounts";
    $accounts_result = $conn->query($query_accounts);
    $accounts_row = $accounts_result->fetch_assoc();
    $accounts_quantity = $accounts_row['total'];

    $notifications_quantity = 0;
    $query_items = "SELECT item_name, item_quantity FROM items";
    $items_result = $conn->query($query_items);
    while ($row = $items_result->fetch_assoc()) {
        $item_quantity = $row['item_quantity'];
        if ($item_quantity <= 10) {
            $notifications_quantity++;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>

    
    <?php
        include("header.php");
        text_head('Welcome Admin :)');
    ?>

    <div class="box">
        <ul>
            <?php
            echo "
            <a href='items.php' class='red'><li><img src='../images/allitems.png' alt=''><br>All Items: $quantity_of_allitems </li></a>
            <a href='reserved_items.php' class='blue'><li><img src='../images/borrow.png' alt=''><br>Reserved items: $borrowed_itemsquantity </li></a>
            <a href='returned_items.php' class='green'><li><img src='../images/return.png' alt=''><br>Returned Items: $returned_items_quantity </li></a>
            <a href='add.php' class='purple'><li><img src='../images/add.png' alt=''><br>Add Items </li></a>
            <a href='accounts.php' class='pink'><li><img src='../images/accounts.png' alt=''><br>Accounts : $accounts_quantity</li></a>
            <a href='records.php' class='brown'><li><img src='../images/records.png' alt=''><br>Records</li></a>
            ";
            ?>
        </ul>
    </div>
</body>
</html>
