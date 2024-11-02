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


// if(isset($_POST["submit"])){
//     $reserve_id = $_POST["reserve_id"];
//     $conn=connect();
    
//     $sql = "SELECT * FROM reserved WHERE reserve_id='$reserve_id'";
//     $result = $conn->query($sql);
//     $row=$result->fetch_assoc();
//     $item_id=$row['item_id'];
//     $id_number = $row['id_number'];
//     $item_name=retrieve("item_name","items",$item_id);
//     $namerow=$item_name->fetch_assoc();
//     $itemname=$namerow["item_name"];
//     $quantity=$_POST["quantity"];
//     $notification_type = "item_returned_approved";
//     $message = "Your returned item $itemname with the quantity of $quantity has been approved.";
//     if($result->num_rows > 0) {
//         $update_query = "UPDATE reserved SET reservation_status='approved' WHERE reserve_id='$reserve_id'";
//         $conn->query($update_query);
//         $query = "INSERT INTO notifications (id_number, notification_type, message) VALUES ('$id_number', '$notification_type', '$message')";
//         mysqli_query($conn, $query);
//         header("Location: returned_items.php");
//         exit;
//     }
    
    
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Records</title>
<link rel="stylesheet" href="../css/items_records_reserved_returned.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
<?php
include("sidebar.php");
?>
<class="header">
<nav class="navbar">
<button class="menu" onclick=showsidebar()>
<img src="../images/menuwhite.png" alt="menu"height="40px" width="45" >
</button>

<h2>Records</h2>
<div class="logout-container">
<form action="" method="post">
<button name="logout" value="logout">Log Out</button>
</form>
</div>
</nav>

</header>
<div class="container">
<table>
<?php
// $months = array();
// $returned=retrieve("*","returned", true);
// while ($row = $returned->fetch_assoc()) {
//     $reserve_id = $row['reserve_id'];
//     $returned_td = new DateTime($row['returned_time']);
//     $returned_time = $returned_td->format('M-d-Y H:i:s');
//     $month = $returned_td->format('F');
//     $reserved = retrieve("*", "reserved", "reserve_id = '$reserve_id'");
//     $row_reserved = $reserved->fetch_assoc();
//     $reservation_status=$row_reserved['reservation_status'];
//     $reserved_dateandtime=$row_reserved['scheduled_reserve_datetime'];
//     $id_num=$row_reserved['id_number'];
//     $quantity = $row_reserved['quantity'];
//     $item_id = $row_reserved['item_id'];
//     $accounts=retrieve('first_name', 'accounts',"id_number='$id_num'");
//     $row_users=$accounts->fetch_assoc();
//     $first_name=$row_users['first_name'];
//     $items = retrieve("item_name", "items", "item_id = $item_id");
//     $row_items = $items->fetch_assoc();
//     $itemname = $row_items['item_name'];

//     if(!($reservation_status=='approved')){
//         continue;
//     }

    $months = array();
    // $records = retrieve("*", "records");
    // while ($row = $records->fetch_assoc()) {
    //     $reserver_firstname = $row['reserver_firstname'];
    //     $reserver_lastname = $row['reserver_lastname'];
    //     $itemname = $row['item'];
    //     $quantity = $row['quantity'];
    //     $reserved_td = new DateTime($row['reserved_dateandtime']);
    //     $reserved_dateandtime = $reserved_td->format('M-d-Y H:i:s');
    //     $returned_td = new DateTime($row['returned_dateandtime']);
    //     $returned_dateandtime = $returned_td->format('M-d-Y H:i:s');

    $sql="SELECT reserved.quantity_reserved, reserved.scheduled_reserve_datetime, accounts.first_name, accounts.last_name, items.item_name, returned.returned_time FROM records INNER JOIN reserved ON records.reserve_id = reserved.reserve_id INNER JOIN accounts ON reserved.id_number = accounts.id_number INNER JOIN items ON reserved.id_number = accounts.id_number INNER JOIN returned ON reserved.reserve_id = returned.reserve_id";
    $records=$conn->query($sql);
    while($row=$records->fetch_assoc()){

        $reserver_firstname = $row['first_name'];
        $reserver_lastname = $row['last_name'];
        $itemname = $row['item_name'];
        $quantity = $row['quantity_reserved'];
        $reserved_td = new DateTime($row['scheduled_reserve_datetime']);
        $reserved_dateandtime = $reserved_td->format('M-d-Y H:i:s');
        $returned_td = new DateTime($row['returned_time']);
        $returned_dateandtime = $returned_td->format('M-d-Y H:i:s');

    $year = $returned_td->format('Y');
    $month = $returned_td->format('F');
        
    $year_month_key = "$year-$month";
    if (!isset($months[$year_month_key])) {
        $months[$year_month_key] = array();
    }
    
    $months[$year_month_key][] = array(
        'first_name' => $reserver_firstname,
        'last_name' => $reserver_lastname,
        'itemname' => $itemname,
        'quantity' => $quantity,
        'reserved_dateandtime' => $reserved_dateandtime,
        'returned_dateandtime' => $returned_dateandtime,
    );
}

echo "
    <table>
        <tr class='row-border'>
            <th>Borrower</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Reserved Date and Time</th>
            <th>Returned Date and Time</th>
        </tr>";

foreach ($months as $year_month => $items) {
    echo "<tr><th colspan='5'>$year_month</th></tr>";
    foreach ($items as $item) {
        echo "
            <tr class='row-border'>
                <td>" . $item['first_name'] . " " . $item['last_name'] . "</td>
                <td>" . $item['itemname'] . "</td>
                <td>" . $item['quantity'] . "</td>
                <td>" . $item['reserved_dateandtime'] . "</td>
                <td>" . $item['returned_dateandtime'] . "</td>
            </tr>";
    }
}
echo "</table>";
?>
</table>
</div>

</body>
</html>

<?php

?>
