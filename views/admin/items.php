<?php
require_once '../../src/shared/database.php';
require_once '../../src/shared/sessionmanager.php';
require_once '../../src/admin/items.php';
include 'header.php';

$sessionManager = new SessionManager();
$sessionManager->checkAdminAccess();

$items = new ItemManager();
$itemsList = $items->getActiveItems();

text_head("Items");


if (isset($_POST['submit'])) {
    $items->updateItem($_POST['item_id'], $_POST['itemname'], $_POST['item_quantity']);

}
if (isset($_POST['delete'])) {
    $items->deleteItem($_POST['item_id']);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items</title>
    <link rel="stylesheet" href="../../assets/css/items_records_reserved_returned.css">
</head>
<body>
    
<div class="container">
        <table>
            <tr class="row-border">
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Reservations</th>
                <th colspan="2">Action</th>
            </tr>
        <?php

        $items = $items->getActiveItems();
        while ($row = $items->fetch_assoc()) {
            $itemname = $row['item_name'];
            $item_quantity = $row['item_quantity'];
            $quantity_reserved = $row['item_quantity_reserved'];
            $item_id = $row['item_id'];

            if(isset($_POST["$item_id"])){
                echo "
                <tr class='row-border'>
                    <form action='items.php' method='post'>
                    <td class='itemname'>
                        <input type='text' name='itemname' value='$itemname'>
                    </td>
                    <td>
                        <input type='number' name='item_quantity' value='$item_quantity' min='0'>
                    </td>
                    <td>
                        $quantity_reserved
                    </td>
                    <td>
                        <input type='submit' name='submit'>
                    </td>
                        <input type='hidden' name='item_id' value='$item_id'>
                    </form>
                </tr>
                ";
            }elseif(!isset($_POST["$item_id"])){
                echo "
                <tr class='row-border'>
                    <td class='itemname'>$itemname </td>
                    <td>$item_quantity</td>
                    <td>$quantity_reserved</td>
                    <form action='items.php' method='post'>
                    <td>
                        <input type='submit' name='$item_id' value='edit'>
                        <input type='submit' name='delete' value='delete' onclick=\"return confirm('Are you sure you want to delete this item?');\">
                        <input type='hidden' name='item_id' value=$item_id>
                    </td>
                    </form>
                </tr>
                ";
                }
        }

        ?>
    </table>
</div>
</body>
</html>
