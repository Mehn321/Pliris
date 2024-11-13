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
    include("header.php");
    text_head("Notifications");

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
        <ul>
        <?php
            $result=retrieve("*","items",true);
            while ($row = mysqli_fetch_assoc($result)) {
                $item_name=$row['item_name'];
                $item_quantity=$row['item_quantity'];
                if($item_quantity<=10){
                    echo "<li>Reminder: $item_name only has $item_quantity left. Please add more of this items. </li>";
                }
                
            }
        ?>
        </ul>
    </div>
</body>
</html>