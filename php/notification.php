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
    text_head("Notifications", $id_number);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="../css/notification.css">
</head>
<body>
    <div class="notifications">
            <?php
                $reserved = $conn->query("SELECT * FROM reservations 
                INNER JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID 
                WHERE reservation_status.reservation_stat='reserving' AND reservations.id_number='$id_number' AND scheduled_return_datetime <= NOW()");
                while ($reserved_row = $reserved->fetch_assoc()) {
                    $item_id = $reserved_row['item_id'];
                    $items = retrieve("item_name", "items", "item_id='$item_id'");
                    if ($itemrow = $items->fetch_assoc()) {
                        $item_name = $itemrow["item_name"];
                        echo "<li class='reminder'>REMINDER: Please return <strong>$item_name</strong> you borrowed</li>";
                    }
                }
                
                $conn->query("UPDATE notifications SET notification_status_id='1' WHERE id_number='$id_number' AND notification_status_id='2'");
                $notifications = $conn->query(
                    "SELECT * FROM notifications WHERE id_number = '$id_number' ORDER BY notification_id DESC"
                );
                while ($row = mysqli_fetch_assoc($notifications)) {
                    $message = $row['message'];
                    echo "<li>$message</li>";
                }
                
            ?>
    </div>
</body>
</html>