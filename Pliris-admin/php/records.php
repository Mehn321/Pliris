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

    function connect(){
        $server="localhost";
        $username = "root";
        $password="";
        $db_name="mb_reserve";
        $conn = mysqli_connect($server,$username,$password,$db_name);
        return $conn;
    }

    function retrieve($column, $table, $where){
        $conn=connect();
        $sql="SELECT $column FROM $table WHERE $where";
        $result=$conn->query($sql);
        return $result;
    }
    $returned=retrieve("*","returned", true);
    if(isset($_POST["submit"])){
        $reserve_id = $_POST["reserve_id"];
        $conn=connect();
        
        $sql = "SELECT * FROM reserved WHERE reserve_id='$reserve_id'";
        $result = $conn->query($sql);
        $row=$result->fetch_assoc();
        $id=$row['id'];
        $id_number = $row['id_number'];
        $name=retrieve("name","items",$id);
        $namerow=$name->fetch_assoc();
        $itemname=$namerow["name"];
        $quantity=$_POST["quantity"];
        $notification_type = "item_returned_approved";
        $message = "Your returned item $itemname with the quantity of $quantity has been approved.";
        if($result->num_rows > 0) {
            $update_query = "UPDATE reserved SET return_stat='approved' WHERE reserve_id='$reserve_id'";
            $conn->query($update_query);
            $query = "INSERT INTO notifications (id_number, notification_type, message) VALUES ('$id_number', '$notification_type', '$message')";
            mysqli_query($conn, $query);
            header("Location: returned_items.php");
            exit;
        }


    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/items.css">
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
                $months = array();
                while ($row = $returned->fetch_assoc()) {
                    $reserve_id = $row['reserve_id'];
                    $returned_td = new DateTime($row['returned_time']);
                    $returned_time = $returned_td->format('M-d-Y H:i:s');
                    $month = $returned_td->format('F');
                    $reserved = retrieve("*", "reserved", "reserve_id = '$reserve_id'");
                    $row_reserved = $reserved->fetch_assoc();
                    $return_stat=$row_reserved['return_stat'];
                    $borrowed_time=$row_reserved['borrow_time'];
                    $id_num=$row_reserved['id_number'];
                    $quantity = $row_reserved['quantity'];
                    $id = $row_reserved['id'];
                    $users=retrieve('first_name', 'users',"id_number='$id_num'");
                    $row_users=$users->fetch_assoc();
                    $first_name=$row_users['first_name'];
                    $items = retrieve("name", "items", "id = $id");
                    $row_items = $items->fetch_assoc();
                    $itemname = $row_items['name'];
                    
                    if(!($return_stat=='approved')){
                        continue;
                    }

                    if (!isset($months[$month])) {
                        $months[$month] = array();
                    }
                    
                    $months[$month][] = array(
                        'first_name' => $first_name,
                        'itemname' => $itemname,
                        'quantity' => $quantity,
                        'borrowed_time' => $borrowed_time,
                        'returned_time' => $returned_time,
                        'reserve_id' => $reserve_id
                    );
                }

                echo "
                    <table>
                        <tr class='row-border'>
                            <th>Borrower</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Borrowed Time</th>
                            <th>Returned Date</th>
                        </tr>";
                        
                        foreach ($months as $month => $items){
                            echo "<tr><th colspan='5'>$month</th></tr>";
                            foreach ($items as $item) {
                                echo"
                                    <tr class='row-border'>
                                        <td>" . $item['first_name'] . "</td>
                                        <td>" . $item['itemname'] . "</td>
                                        <td>" . $item['quantity'] . "</td>
                                        <td>" . $item['borrowed_time'] . "</td>
                                        <td>" . $item['returned_time'] . "</td>
                                        <form action='returned_items.php' method='post'>
                                            <input type='hidden' name='quantity' value='" . $item['quantity'] . "'>
                                            <input type='hidden' name='reserve_id' value='" . $item['reserve_id'] . "'>
                                        </form>
                                    </tr>
                                ";
                            }
                            
                        }
                    echo"</table>";
                ?>
        </table>
    </div>

</body>
</html>

<?php

?>
