<?php   
    session_start();
    $id_number = $_SESSION['id_admin'];
    if (!isset($_SESSION['id_admin'])) {
        header("Location: ../index.php");
        exit;
    }
    if (isset($_POST['logout'])) {
        unset($_SESSION['id_admin']);
        header("Location: ../index.php");
        exit;
    }

    include("database.php");
    include("header.php");

    if (isset($_POST["submit"])) {
        $id_number = $_POST['id_number'];
    
        if (!empty($_POST["first_name"])) {
            $first_name = $_POST['first_name'];
            update("accounts", "first_name='$first_name'", "id_number='$id_number'");
        }
        if (!empty($_POST["last_name"])) {
            $last_name = $_POST['last_name'];
            update("accounts", "last_name='$last_name'", "id_number='$id_number'");
        }
        if (!empty($_POST["id_num"])) {
            echo "okay";
            $id_num = $_POST["id_num"];
            update("accounts", "id_number='$id_num'", "id_number='$id_number'");
        }
        if (!empty($_POST["email"])) {
            $email = $_POST['email'];
            update("accounts", "email='$email'", "id_number='$id_number'");
        }
        if (!empty($_POST["middle_initial"])) {
            $middle_initial = $_POST['middle_initial'];
            update("accounts", "middle_initial='$middle_initial'", "id_number='$id_number'");
        }
        if (!empty($_POST["password"])) {
            $password = $_POST['password'];
            update("accounts", "password='$password'", "id_number='$id_number'");
        }
        header("Location: accounts.php");
        mysqli_close($conn);
    }

    if (isset($_POST["delete"])) {
        $id_number = $_POST['id_number'];
        $items_reserved = retrieve("quantity_reserved", "reservations", "id_number='$id_number'");
        $reservations = $items_reserved->num_rows;
        if ($reservations <= 0) {
            $active_status_id = retrieve("active_status_ID", "active_status", "active_stat='deleted'")->fetch_assoc()['active_status_ID'];
            update("accounts", "active_status_ID='2'", "id_number='$id_number'");
            header("Location:accounts.php");
        } else {
            echo "
            <script>
                alert('This user is still reserving an item please wait for the user to return the item or you can force the return of the item in the system using the reservations items in the menu');
            </script>";
            header("Loaction: items.php");
        }
    }

    text_head("Accounts");


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
    <div class="container">
    <table>
            <tr class="row-border">
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Initial</th>
                <th>Id Number</th>
                <th>Email</th>
                <th>Password</th>
                <th>Action</th>

            </tr>
            <?php
                $query = "SELECT accounts.first_name, accounts.last_name, accounts.id_number, accounts.email, accounts.middle_initial, accounts.password 
                        FROM accounts INNER JOIN active_status ON accounts.active_status_ID=active_status.active_status_ID 
                        WHERE active_status.active_stat='active' ORDER BY accounts.last_name";
                $accounts = $conn->query($query);
                while ($row = $accounts->fetch_assoc()) {
                    $first_name = $row['first_name'];
                    $last_name = $row['last_name'];
                    $id_number = $row['id_number'];
                    $email = $row['email'];
                    $middle_initial = $row['middle_initial'];
                    $password = $row['password'];
                    if (isset($_POST["$id_number"])) {
                        echo "
                        <tr class='row-border'>
                        <form action='accounts.php' method='post'>
                        <td>
                            <input type='text' name='last_name' value='$last_name'>
                        </td>
                        <td>
                            <input type='text' name='first_name' value='$first_name'>
                        </td>
                        <td>
                            <input type='text' class='mi' name='middle_initial' value='$middle_initial'>
                        </td>
                        <td>
                            <input type='number' name='id_num' value='$id_number'>
                        </td>
                        <td>
                            <input type='email' name='email' value='$email'>
                        </td>
                        <td>
                            <input type='text' name='password' value='$password'>
                            <input type='hidden' name='id_number' value=$id_number>
                        </td>
                        <td><input type='submit' name='submit' value='submit'></td>
                        </form>
                    </tr>
                    ";
                    } else {
                        echo "
                        <tr class='row-border'>
                        <td>$last_name</td>
                        <td>$first_name</td>
                        <td>$middle_initial</td>
                        <td>$id_number</td>
                        <td>$email</td>
                        <td>$password</td>
                        <form action='accounts.php' method='post' class='action'>
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

