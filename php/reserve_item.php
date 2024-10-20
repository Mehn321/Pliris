<!-- <?php /*   
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

    function connect(){
        $server="localhost";
        $username = "root";
        $password="";
        $db_name="pliris";
        $conn = mysqli_connect($server,$username,$password,$db_name);
        return $conn;
    }

    function retrieve($column, $table){
        $conn=connect();
        $sql="SELECT $column FROM $table";
        $result=$conn->query($sql);
        return $result;
    }
    $items=retrieve("*","items");
    
    if(isset($_POST["submit"])){
        $id = $_POST["id"];
        $quantity = $_POST["quantity"];
        $borrow_time=$_POST["borrow_time"];
        $return_time=$_POST["return_time"];
        $borrowed=$_POST["borrowed"]+$quantity;
        $conn=connect();
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    
        // Validate inputs
        if (!is_numeric($quantity) || $quantity <= 0) {
            echo "<script>alert('Invalid quantity. Please enter a positive integer.');</script>";
            exit;
        }
    
        if (!is_numeric($id)) {
            echo "<script>alert('Invalid item ID. Please enter a valid integer.');</script>";
            exit;
        }
    
        $sql = "SELECT * FROM reserved WHERE id = $id AND ((borrow_time <= '$borrow_time' AND return_time >= '$borrow_time') OR (borrow_time <= '$return_time' AND return_time >= '$return_time'))";
        $result = $conn->query($sql);
    
        $availableQuantity = 0;
        while ($row = $result->fetch_assoc()) {
            $availableQuantity += $row['quantity'];
        }
    
        $itemSql = "SELECT quantity FROM items WHERE id = $id";
        $itemResult = $conn->query($itemSql);
        $itemRow = $itemResult->fetch_assoc();
        $totalQuantity = $itemRow['quantity'];
        
        $availableAtTime=$totalQuantity - $availableQuantity;
        if ($availableAtTime < $quantity) {
            echo "<script>alert('Not enough items available at the desired time. Only $availableAtTime items are available. Please choose a different time or reduce the quantity.');</script>";
            exit;
        }
        

        // Update item and reserve tables
        $sql="UPDATE items SET borrowed=$borrowed WHERE id=$id";
        if (!$conn->query($sql)) {
            echo "<script>alert('Failed to update items table.');</script>";
            exit;
        }
    
        $reserve ="INSERT INTO reserved(`id_number`,`id`,`quantity`,`borrow_time`,`return_time`,`return_stat`) values('$id_number','$id','$quantity','$borrow_time','$return_time','borrowing' )";
        if (!$conn->query($reserve)) {
            echo "<script>alert('Failed to insert into reserved table.');</script>";
            exit;
        }
        header("Location:reserve_item.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/reserve_item.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
            <h2>All Items</h2>

        <div class="logout-container">
            <form action="" method="post">
            <button name="logout" value="logout">Log Out</button>
            </form>
        </div>
        </nav>

    </header>
    <div class="container">
    <table>
            <tr class="row-border">
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Reserved</th>
                <th>Remaining</th>
                <th>Action</th>
            </tr>
            <?php
                while($row=$items->fetch_assoc()){
                    $itemname = $row['name'];
                    $quantity = $row['quantity'];
                    $borrowed = $row['borrowed'];
                    $remaining = $quantity - $borrowed;
                    $id = $row['id'];
                    if(isset($_POST["$id"])){
                        echo "
                        <tr class='row-border'>
                            <form action='reserve_item.php' method='post'>
                            <td>$itemname </td>
                            <td>
                                $quantity <br>
                                <label>quantity:</label>
                                <input type='number' name='quantity' required>
                            </td>
                            <td>
                                $borrowed <br>
                                <label>borrow time:</label>
                                <input type='datetime-local' name='borrow_time' required>
                            </td>
                            <td>
                                $remaining<br>
                                <label>return time:</label>
                                <input type='datetime-local' name='return_time' required>
                            </td>
                            </td>
                                <input type='hidden' name='id' value='$id'>
                            <td>
                                <input type='hidden' name='borrowed' value='$borrowed'>
                            <td>
                            <td>
                                <input type='submit' name='submit' value='submit' >
                            </td>
                            </form>
                        </tr>
                        ";
                    }
                    elseif(isset($_POST["$id"])==false){
                    echo "
                    <tr class='row-border'>
                        <td>$itemname </td>
                        <td>$quantity</td>
                        <td>$borrowed</td>
                        <td>$remaining</td>
                        <form action='reserve_item.php' method='post'>
                        <td>
                            
                            <input type='submit' name='$id' value='reserve'>
                        </td>
                        </form>
                    </tr>
                    ";
                    }
                }
            */?>
        </table>
    </div>

</body>
</html> -->


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

    if(isset($_POST["reserve"])){
        $id = $_POST["id"];
        $borrow_time=$_POST["borrow_time"];
        $return_time=$_POST["return_time"];
        $quantity_toreserve = $_POST["quantity"];

        $conn=connect();
        // $sql = "SELECT * FROM reserved WHERE id = $id AND ((borrow_time <= '$borrow_time' AND return_time >= '$borrow_time') OR (borrow_time <= '$return_time' AND return_time >= '$return_time'))";
        // $result = $conn->query($sql);
        $result=retrieve("*","reserved","id = $id AND ((borrow_time <= '$borrow_time' AND return_time >= '$borrow_time') OR (borrow_time <= '$return_time' AND return_time >= '$return_time'))");


        $availableAtTime= $_POST['availableAtTime'];
        if ($availableAtTime < $quantity_toreserve) {
            echo "<script>alert('Not enough items available at the desired time. Only $availableAtTime items are available. Please choose a different time or reduce the quantity.');</script>";
        }
        else{
            $borrowed += $quantity_toreserve;
            // $sql="UPDATE items SET borrowed=$borrowed WHERE id=$id";
            // if (!$conn->query($sql)) {
            //     echo "<script>alert('Failed to update items table.');</script>";
            // }
            update("items","borrowed=$borrowed","id=$id");

            // $reserve ="INSERT INTO reserved(`id_number`,`id`,`quantity`,`borrow_time`,`return_time`,`return_stat`) values('$id_number','$id','$quantity_toreserve','$borrow_time','$return_time','borrowing' )";
            // if (!$conn->query($reserve)) {
            //     echo "<script>alert('Failed to insert into reserved table.');</script>";
            // }
            insert("reserved","`id_number`,`id`,`quantity`,`borrow_time`,`return_time`,`return_stat`","'$id_number','$id','$quantity_toreserve','$borrow_time','$return_time','borrowing'");
            header("Location:reserve_item.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/reserve_item.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
            <h2>All Items</h2>
        <div class="logout-container">
            <form action="" method="post">
            <button name="logout" value="logout">Log Out</button>
            </form>
        </div>
        </nav>

    </header>
    <div class="container">
        <form action="reserve_item.php" method="post">
            <p>Please submit first the date and time you want to borrow and return the item to show the list of items available at that time</p>
            <label>Borrow Time:</label>
            <input type="datetime-local" name="borrow_time" required>
            <label>Return Time:</label>
            <input type="datetime-local" name="return_time" required>
            <input type="submit" name="submit" value="Submit">
        </form>
        <table>
                <tr class="row-border">
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Reserved</th>
                    <th>Remaining</th>
                    <th>Action</th>
                </tr>

        <?php if(isset($_POST["submit"])){ 
                
                $borrow_time=$_POST["borrow_time"];
                $return_time=$_POST["return_time"];
                $items=retrieve("*","items",true);
                // $reserved=retrieve("quantity,id","reserved","return_stat='borrowing'");
                while($row=$items->fetch_assoc()){
                    $itemname = $row['name'];
                    $quantity = $row['quantity'];
                    // $borrowed = $row['borrowed'];
                    $id = $row['id'];

                    $conn=connect();
                    $sql = "SELECT * FROM reserved WHERE id = '$id' AND return_stat='borrowing' AND (((borrow_time <= '$borrow_time' AND return_time >= '$borrow_time') OR (borrow_time >= '$return_time' AND return_time <= '$return_time')) OR ((borrow_time >= '$borrow_time' AND return_time <= '$borrow_time') OR (borrow_time >= '$return_time' AND return_time <= '$return_time')))";
                    $reserved = $conn->query($sql);
                    $borrowed_Quantity = 0;
                    while ($row2 = $reserved->fetch_assoc()) {
                        $borrowed_Quantity += $row2['quantity'];

                    }

                    $availableAtTime=$quantity - $borrowed_Quantity;
                    $borrowedAtTime = $borrowed_Quantity;

                    echo "
                    <tr class='row-border'>
                        <td>$itemname </td>
                        <td>$quantity</td>
                        <td>$borrowedAtTime</td>
                        <td>$availableAtTime</td>
                        <td>
                            <form action='reserve_item.php' method='post'>
                                <input type='hidden' name='id' value='$id'>
                                <input type='hidden' name='borrow_time' value='$borrow_time'>
                                <input type='hidden' name='return_time' value='$return_time'>
                                <input type='hidden' name='availableAtTime' value='$availableAtTime'>
                                <label>Quantity:</label>
                                <input type='number' name='quantity' required>
                                <input type='submit' name='reserve' value='Reserve'>
                                
                            </form>
                        </td>
                    </tr>
                    ";
                }
            }
            ?>
        </table>
        
    </div>

</body>
</html>
