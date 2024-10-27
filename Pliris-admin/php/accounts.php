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
    $accounts=retrieve("*","accounts",true, "last_name");

    if(isset($_POST["submit"])){
        $id_number = $_POST['id_number'];
    
        if(!empty($_POST["first_name"])){
            $first_name=$_POST['first_name'];
            // $sql="UPDATE accounts SET first_name='$first_name' WHERE id_number='$id_number'";
            // $conn->query($sql);
            update("accounts","first_name='$first_name'","id_number='$id_number'");
        }
        if(!empty($_POST["last_name"])){
            $last_name=$_POST['last_name'];
            // $sql="UPDATE accounts SET last_name='$last_name' WHERE id_number='$id_number'";
            // $conn->query($sql);
            update("accounts","last_name='$last_name'","id_number='$id_number'");
        }
        if(!empty($_POST["id_num"])){
            echo"okay";
            $id_num=$_POST["id_num"];
            // $sql="UPDATE accounts SET last_name='$last_name' WHERE id_number='$id_number'";
            // $conn->query($sql);
            update("accounts","id_number='$id_num'","id_number='$id_number'");
        }
        if(!empty($_POST["email"])){
            $email=$_POST['email'];
            // $sql="UPDATE accounts SET email='$email' WHERE id_number='$id_number'";
            // $conn->query($sql);
            update("accounts","email='$email'","id_number='$id_number'");
        }
        if(!empty($_POST["username"])){
            $username=$_POST['username'];
            // $sql="UPDATE accounts SET username='$username' WHERE id_number='$id_number'";
            // $conn->query($sql);
            update("accounts","username='$username'","id_number='$id_number'");

        }
        if(!empty($_POST["password"])){
            $password=$_POST['password'];
            // $sql="UPDATE accounts SET password='$password' WHERE id_number='$id_number'";
            // $conn->query($sql);
            update("accounts","password='$password'","id_number='$id_number'");

        }
        header("Location: accounts.php");
        mysqli_close($conn);
    }

    if(isset($_POST["delete"])){
        $id_number = $_POST['id_number'];
        $item=retrieve("quantity","reserved","id_number='$id_number'");
        $reserved=0;
        while($item_row=$item->fetch_assoc()){
            $reserved= $reserved+$item_row["quantity"];
        }
        
        if($reserved<=0){
            delete("accounts","id_number='$id_number'");
            header("Location:items.php");
        }else{
            echo"
            <script>
                alert('This user is still reserving an item please wait for the user to return the item or you can force the return of the item in the system using the reserved items in the menu');
            </script>";
            header("Loaction: items.php");
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts</title>
    <link rel="stylesheet" href="../css/accounts.css">
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
            <h2>All Accounts</h2>

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
                <th>Last Name</th>
                <th>First Name</th>
                <th>Id Number</th>
                <th>email</th>
                <th>Username</th>
                <th>Password</th>
            </tr>
            <?php
                while($row=$accounts->fetch_assoc()){
                    $first_name = $row['first_name'];
                    $last_name = $row['last_name'];
                    $id_number = $row['id_number'];
                    $email = $row['email'];
                    $username=$row['username'];
                    $password=$row['password'];
                    if(isset($_POST["$id_number"])){
                        echo "
                        <tr class='row-border'>
                        <form action='accounts.php' method='post'>
                        <td>
                            $last_name
                            <input type='text' name='last_name'>
                        </td>
                        <td>
                            $first_name
                            <input type='text' name='first_name'>
                        </td>
                        <td>
                            $id_number
                            <input type='number' name='id_num'>
                        </td>
                        <td>
                            $email
                            <input type='email' name='email'>
                        </td>
                        <td>
                            $username
                            <input type='text' name='username'>
                        </td>
                        <td>
                            $password
                            <input type='text' name='password'>
                            <input type='hidden' name='id_number' value=$id_number>
                            <input type='submit' name='submit' value='submit'>
                        </td>
                        </form>
                    </tr>
                    ";
                    }
                    else{
                        echo "
                        <tr class='row-border'>
                        <td>$last_name</td>
                        <td>$first_name </td>
                        <td>$id_number</td>
                        <td>$email</td>
                        <td>$username</td>
                        <td>$password</td>
                        <form action='accounts.php' method='post'>
                        <td>
                            <input type='submit' name='$id_number' value='edit'>
                            <input type='submit' name='delete' value='delete' onclick=\"return confirm('Are you sure you want to delete this account?');\">
                            <input type='hidden' name='id_number' value=$id_number>
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

<?php

?>
