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

    $name=retrieve("*","items");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="seeAll_items.css">
</head>
<body>
    <?php
        include("sidebar.php");
    ?>
    <header class="header">
        <nav class="navbar">
            <ul>
                <li><a href="#">chemical</a></li>
                <li><a href="#">labaratory aparatus</a></li>
                <li><a href="#">diving instrument</a></li>
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
                    echo "
                    <tr class='row-border'>
                        <td><img src='../images/ustplogo.png' alt='item image'></td>
                        <td>$itemname </td>
                        <td>$quantity</td>
                        <td>$borrowed</td>
                        <td>$remaining</td>
                        <form action='borrow.php' method='post'>
                        <td>
                        
                            <input type='number'>
                            <input type='submit' name='reserve' value='reserve'>
                            
                        
                        </td>
                        <td>
                            <input type='date' name='date'>
                        </form>
                    </tr>
                    ";
                }
            ?>
        </table>
        
    </div>
    
</body>
</html>