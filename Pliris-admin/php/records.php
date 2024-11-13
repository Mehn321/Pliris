<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
text_head("Records");


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
    
<div class="container">
<table>
<?php

    $months = array();
    $sql="SELECT reservations.quantity_reserved, reservations.scheduled_reserve_datetime, accounts.first_name, accounts.last_name, items.item_name, reservations.returned_datetime 
    FROM records LEFT JOIN reservations 
    ON records.reserve_id = reservations.reserve_ID 
    INNER JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID
    INNER JOIN accounts ON reservations.id_number = accounts.id_number 
    INNER JOIN items ON reservations.item_id = items.item_id
    WHERE reservation_status.reservation_stat = 'approved'
    ORDER BY reservations.returned_datetime ASC
    ";
    $records=$conn->query($sql);
    while($row=$records->fetch_assoc()){

        $reserver_firstname = $row['first_name'];
        $reserver_lastname = $row['last_name'];
        $itemname = $row['item_name'];
        $quantity = $row['quantity_reserved'];
        $reserved_td = new DateTime($row['scheduled_reserve_datetime']);
        $reserved_dateandtime = $reserved_td->format('M-d-Y H:i:s:a');
        $returned_td = new DateTime($row['returned_datetime']);
        $returned_dateandtime = $returned_td->format('M-d-Y h:i:s:a');

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
