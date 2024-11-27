<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/add.css">
</head>
<body>
    <?php
    require_once '../../src/shared/database.php';
    require_once '../../src/shared/SessionManager.php';
    require_once '../../src/admin/add.php';
    include 'header.php';

    $sessionManager = new SessionManager();
    $sessionManager->checkAdminAccess();
    // $sessionManager->handleAdminLogout();

    $addItem = new AddItemManager();

    if(isset($_POST['submit'])) {
        $item_quantity = $_POST['item_quantity'];
        $item_name = $_POST['item_name'];
        $addItem->addNewItem($item_name, $item_quantity);
    }

    text_head("Add Item");
    ?>

    <div class="container">
        <form class="add-items-form" action="" method="post">
            <div class="input-box">
            <label>Item Name</label>
                <input type="text" name="item_name" required>
            </div>
            <div class="input-box">
            <label>Quantity</label>
                <input type="number" name="item_quantity" required>
            </div>
            <input class="add-items-table" type="submit" name="submit" value="Add" class="btn">
        </form>
    </div>
</body>
</html>
