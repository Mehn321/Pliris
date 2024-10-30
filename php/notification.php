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
    include("sidebar.php");
    

    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="../css/notification.css">
</head>
<header class="header">
        <nav class="navbar">
            <button class="menu" onclick=showsidebar()>
                <img src="../images/menuwhite.png" alt="menu"height="40px" width="45" >
            </button>
            <img src="../images/ustplogo.png" alt="">
            <ul>
                <li> NOTIFICATIONS </li>
            </ul>
            <div class="logout-container">
                <form action="" method="post">
                <button name="logout" value="logout">Log Out</button>
                </form>
            </div>
        </nav>
</header>
<body>
    <div class="notifications">
            <?php
                $reserved=retrieve("*","reserved"," return_status='borrowing' AND id_number='$id_number'");
                    while($reserved_row=$reserved->fetch_assoc()){
                        $returned_td = new DateTime($reserved_row['scheduled_return_datetime']);
                        $return_dateandtime = $returned_td->format('M-d-Y H:i:s');
                        date_default_timezone_set('Asia/Manila');
                        $currentTime = date('M-d-Y H:i:s');
                        if($return_dateandtime<=$currentTime){
                            $item_id=$reserved_row['item_id'];
                            $items=retrieve("item_name","items","item_id='$item_id'");
                            if ($itemrow = $items->fetch_assoc()) { // Check if item exists
                                $item_name = $itemrow["item_name"];
                                echo "<li>Please return the $item_name you borrowed</li>";
                            }
                        }
                    }
                $notifications=retrieve("*","notifications","id_number = '$id_number'","notif_id DESC");
                while ($row = mysqli_fetch_assoc($notifications)) {
                    $message =$row['message'];
                    echo "<li>$message</li>";
                }
            ?>
    </div>
</body>
</html>