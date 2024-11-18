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
    $sessionManager->handleLogout();

    $addItem = new AddItemManager();

    if(isset($_POST['submit'])) {
        $addItem->addNewItem($_POST);
    }

    text_head("Add Item", $sessionManager->getAdminId());
    ?>

    <div class="container">
        <form action="" method="post">
            <div class="input-box">
                <input type="text" name="item_name" required>
                <label>Item Name</label>
            </div>
            <div class="input-box">
                <input type="number" name="quantity" required>
                <label>Quantity</label>
            </div>
            <input type="submit" name="submit" value="Add" class="btn">
        </form>
    </div>
</body>
</html>
