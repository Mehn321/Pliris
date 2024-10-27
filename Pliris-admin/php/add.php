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

        if (isset($_POST["add"])) {
            $item_name = $_POST['item_name'];
            $quantity = $_POST['quantity'];
        
            // $conn = mysqli_connect('localhost', 'root', '', 'pliris');
            // if (!$conn) {
            //     die("Connection failed: " . mysqli_connect_error());
            // }
        
            // $sql = "INSERT INTO items (item_name, quantity) VALUES ('$item_name', '$quantity')";
            // mysqli_query($conn, $sql);
            // mysqli_close($conn);

            insert("items","item_name, quantity","'$item_name', '$quantity'");
            header("Location: add.php");
        }
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
<?php
        include("sidebar.php");
    ?>
    <header class="header">
        <nav class="navbar">
            <button class="menu" onclick=showsidebar()>
                <img src="../images/menuwhite.png" alt="menu"height="40px" width="45" >
            </button>
            <h2>Add Item</h2>

        <div class="logout-container">
            <form action="" method="post">
                <button name="logout" value="logout">Log Out</button>
            </form>
        </div>
        </nav>

    </header>
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
                    <input type="number" name="quantity">
                </div>
            </div>
            </div>
            <input type="submit" name="add" value="Add Item">
        </form>
    </div>
    
</body>
</html>

<?php

?>