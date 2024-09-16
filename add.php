<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="add.css">
</head>
<body>
    <?php include("sidebar.php"); ?>
    <div class="container">
        <h1>Add Item</h1>
        <br>
        <form action="" method="post">
            <div class="form-group">
                <label for="">Name:</label>
                <input type="text" name="item" required>
            </div>
            <div class="form-group">
                <label for="">Definition:</label>
                <textarea name="definition" id="" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group1">
                <label for="">Category:</label>
                <select name="category" id="">
                    <option value="chemical">Chemical</option>
                    <option value="lab_aparatus">Laboratory Aparatus</option>
                    <option value="diving_instrument">Diving Instrument</option>
                    
                </select>
                
            </div>
            <div class="form-group2">
                <div class="input-group">
                    <label for="">Quantity:</label>
                    <input type="number" name="quantity">
                </div>
                <div class="input-group">
                    <label for="">Expiry Date:</label>
                    <input type="date" name="expiry_date">
                </div>
            </div>
            <div class="form-group3">
                <div class="input-group">
                    <label for="">Location:</label>
                    <input type="text" name="location">
                </div>
                <div class="input-group">
                    <label for="">Item Image</label>
                    <input type="file" name="item_image" accept="image/*">
                </div>
            </div>
            <input type="submit" name="add" value="Add Item">
        </form>
    </div>
    
</body>
</html>

<?php
if (isset($_POST["add"])) {
    $item = $_POST['item'];
    $definition = $_POST['definition'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $expiry_date = $_POST['expiry_date'];
    $location = $_POST['location'];
    $item_image = $_FILES['item_image']['name'];

    // Move the uploaded file to a directory on your server
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($item_image);
    move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file);

    // Database connection
    $conn = mysqli_connect('localhost', 'root', '', 'mb_inventory');

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare an SQL statement
    $stmt = mysqli_prepare($conn, "INSERT INTO items (item, definition, category, quantity, expiry_date, location, item_image) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Bind variables to the prepared statement
    mysqli_stmt_bind_param($stmt, "sssssss", $item, $definition, $category, $quantity, $expiry_date, $location, $item_image);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Check if the query was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "New record created successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the prepared statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>