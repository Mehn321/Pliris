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
    $sql="SELECT first_name FROM accounts WHERE id_number='$id_number'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $first_name = $row['first_name'];
    
    text_head("Welcome $first_name", $id_number);
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
    <div class="box">
        <ul>
            <?php
                $reservations = "SELECT COUNT(reservations.reservation_status_ID) as borrowed_itemsquantity
                FROM reservations INNER JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID 
                WHERE id_number='$id_number' AND reservation_stat='reserving'";
                $result = $conn->query($reservations);
                $row = $result->fetch_assoc();
                $borrowed_itemsquantity = $row['borrowed_itemsquantity'];
            echo"
            <a href='reserve_item.php' class='red'><li><img src='../images/allitems.png' alt=''>Reserve item</li></a>
            <a href='reserved_items.php' class='blue'><li><img src='../images/borrow.png' alt=''>Reserved items: $borrowed_itemsquantity </li></a>
            ";
            ?>
        </ul>
    </div>
</body>
</html>


