<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link rel="stylesheet" href="../../assets/css/add.css">
</head>
<body>
    <?php
    // Include necessary files and start a session
    require_once '../../src/shared/database.php';
    require_once '../../src/shared/sessionmanager.php';
    require_once '../../src/admin/add.php';
    include 'header.php';

    $sessionManager = new SessionManager();
    // Check if the admin has access
    $sessionManager->checkAdminAccess();

    $addItem = new AddItemManager();

    if(isset($_SESSION['add_success'])) {
        echo "<div class='alert-notif green' id='alert_notif'>
                    <p class='circle-exclamation-check green-check'>✓</p>
                    Items added Successfully! 🎉
                </div>
                <script>
                    setTimeout(() => {
                        document.getElementById('alert_notif').remove();
                    }, 5000);
                </script>";
        unset($_SESSION['add_success']);
    }

    // Handle form submission to add a new item
    if(isset($_POST['submit'])) {
        $item_quantity = $_POST['item_quantity'];
        $item_name = $_POST['item_name'];
        $addItem->addNewItem($item_name, $item_quantity);
        $_SESSION['add_success'] = true;
        header('Location: add.php');
        exit;
    }


    // Display the page header
    text_head("Add Item");
    ?>

    <div class="container">
        <form class="add-items-form" action="" method="post">
            <div class="input-container">
                <label>Item Name</label>
                <input type="text" name="item_name" required>
            </div>
            <div class="input-container">
                <label>Quantity</label>
                <input type="number" name="item_quantity" required>
            </div>
            <input class="add-items-table" type="submit" name="submit" value="Add" class="btn">
        </form>
    </div>
</body>
</html>