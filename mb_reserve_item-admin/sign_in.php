<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="sign_in.php" method="post">
        <label for="">username</label><br>
        <input type="text" name="username"><br>
        <label for="">password</label><br>
        <input type="password" name="pass" id=""><br>
        <input type="submit" value="login">
        
    </form>

</body>
</html>

<?php
    $username = $_POST['username'];
    $password = $_POST['pass'];
    
    if ($username == 'admin' && $password == 'admin') {
        header('Location: add.php');
    } else {
        echo 'Invalid username or password';
    }
    
    

?>