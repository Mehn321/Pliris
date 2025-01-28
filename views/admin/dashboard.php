<?php
// Include the header and necessary PHP files for database and session management
include "header.php";
require_once '../../src/shared/database.php';
require_once '../../src/shared/sessionmanager.php';
require_once '../../src/admin/dashboard.php';

// Initialize session manager
$sessionManager = new SessionManager();

// Set redirect path and check for admin access
$sessionManager->setRedirectPath("index.php");
$sessionManager->checkAdminAccess();

// Initialize admin dashboard
$dashboard = new AdminDashboard();
text_head("Welcome Admin");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <!-- Link to CSS stylesheets and JavaScript file -->
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <script src="../../assets/js/sidebar.js"></script>
</head>
<body>
    <?php 
    // Fetch and display dashboard statistics
    $stats = $dashboard->getDashboardStats();
    echo '
    <div class="container">
        <ul>
            <a href="items.php" class="red">
                <li><img src="../../assets/images/allitems.png" alt=""><br>All Items: ' . $stats['items'] . '</li>
            </a>
            <a href="reserved_items.php" class="blue">
                <li><img src="../../assets/images/borrow.png" alt=""><br>Reserved items: ' . $stats['reserved'] . '</li>
            </a>
            <a href="returned_items.php" class="green">
                <li><img src="../../assets/images/return.png" alt=""><br>Returned Items: ' . $stats['returned'] . '</li>
            </a>
            <a href="add.php" class="purple">
                <li><img src="../../assets/images/add.png" alt=""><br>Add Items</li>
            </a>
            <a href="accounts.php" class="pink">
                <li><img src="../../assets/images/accounts.png" alt=""><br>Accounts: ' . $stats['accounts'] . '</li>
            </a>
            <a href="records.php" class="brown">
                <li><img src="../../assets/images/records.png" alt=""><br>Records</li>
            </a>
        </ul>
    </div>';
    ?>
</body>
</html>

