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


    if (isset($_POST["add"])) {
        $item_name = $_POST['item_name'];
        $item_quantity = $_POST['item_quantity'];

        insert("items","item_name, item_quantity","'$item_name', '$item_quantity'");
        header("Location: add.php");
    }

    text_head("Add Items");


    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link rel="stylesheet" href="../css/add.css">
</head>
<body>
    <div class="container">
        <h1>Add Item</h1>
        <br>
        <form action="add.php" method="post">
            <div class="form-group">
                <label for="">Name:</label>
                <input type="text" name="item_name" required>
            </div>
            <div class="form-group2">
                <div class="input-group">
                    <label for="">Quantity:</label>
                    <input type="number" name="item_quantity">
                </div>
            </div>
            </div>
            <input type="submit" name="add" value="Add Item">
        </form>
    </div>
    
</body>
</html>
