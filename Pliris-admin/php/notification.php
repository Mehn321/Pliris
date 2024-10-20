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

    // function connect(){
    //     $server="localhost";
    //     $username = "root";
    //     $password="";
    //     $db_name="pliris";
    //     $conn = mysqli_connect($server,$username,$password,$db_name);
    //     return $conn;
    // }

    // function retrieve($column, $table){
    //     $conn=connect();
    //     $sql="SELECT $column FROM $table";
    //     $result=$conn->query($sql);
    //     return $result;
    // }
    include("database.php");
    $result=retrieve("*","items",true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/notification.css">
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
            <img src="../images/ustplogo.png" alt="">
            <ul>
                
                <li> NOTIFICATIONS </li>
            </ul>
            <div class="logout-container">
                <form action="" method="post">
                <button name="logout" value="logout">Log Out</button>
                </form>
            </div>
        </nav>
    </header>

    <div class="container">
        <ul>
        <?php
            while ($row = mysqli_fetch_assoc($result)) {
                $name=$row['name'];
                $quantity=$row['quantity'];
                if($quantity<=10){
                    echo "<li> $name only has $quantity left. Please add more of this items. </li>";
                }
                
            }
        ?>
        </ul>
    </div>
</body>
</html>