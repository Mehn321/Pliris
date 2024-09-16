<?php
    function connect(){
        $server="localhost";
        $username = "root";
        $password="";
        $db_name="mb_reserve";
        $conn = mysqli_connect($server,$username,$password,$db_name);
        return $conn;
    }

    function retrieve($column, $table){
        $conn=connect();
        $sql="SELECT $column FROM $table";
        $result=$conn->query($sql);
        return $result;
    }

    $name=retrieve("*","chemicals");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="seeAll_items.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <?php
        include("sidebar.php");
    ?>
    <header class="header">
        <nav class="navbar">
            <button class="menu" onclick=showsidebar()>
                <img src="menuwhite.png" alt="menu"height="40px" width="45" >
            </button>
            <ul>
                <li><a href="#">CHEMICAL</a></li>
                <li><a href="#">LABARATORY APARATUS</a></li>
                <li><a href="#">DIVING INSTRUMENTS</a></li>
                <li><a href="#"></a></li>
            </ul>

        <div class="logout-container">
            <button>Log Out</button>
        </div>
        </nav>

    </header>
    <div class="container">
    <table>
            <tr class="row-border">
                <th>Picture</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Borrowed</th>
                <th>Remaining</th>
                <th>Action</th>
            </tr>
            <?php
                while($row=$name->fetch_assoc()){
                    $itemname = $row['name'];
                    $quantity = $row['quantity'];
                    $borrowed = $row['borrowed'];
                    $reserved_date = $row['reserve_date'];
                    $remaining = $quantity - $borrowed;
                    $id = $row['id'];
                    if(isset($_POST["$id"])){
                        echo "
                        <tr class='row-border'>
                            <form action='seeAll_items.php' method='post'>
                            <td><img src='ustplogo.png' alt='item image'></td>
                            <td>$itemname </td>
                            <td>
                                $quantity <br>
                                <label>quantity:</label>
                                <input type='number' required>
                            </td>
                            <td>
                                $borrowed <br>
                                <label>borrow time:</label>
                                <input type='datetime-local' required>
                            </td>
                            <td>
                                $remaining<br>
                                <label>return time:</label>
                                <input type='datetime-local' required>
                            </td>
                            
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
                        <td><img src='ustplogo.png' alt='item image'></td>
                        <td>$itemname </td>
                        <td>$quantity</td>
                        <td>$borrowed</td>
                        <td>$remaining</td>
                        <form action='seeAll_items.php' method='post'>
                        <td>
                            
                            <input type='submit' name='$id' value='reserve'>
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

<script>
    function showsidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.style.display = 'flex';
    }
</script>
