<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>
<body>
    <?php
    include 'header.php';
    require_once '../../src/shared/database.php';
    require_once '../../src/shared/sessionmanager.php';
    require_once '../../src/user/dashboard.php';
    require_once '../../src/shared/authentication.php';

    $sessionManager = new SessionManager();
    $sessionManager->setRedirectPath("../../index.php");
    $sessionManager->checkUserAccess();

    $dashboard = new UserDashboard();
    $stats = $dashboard->getDashboardStats($sessionManager->getUserId_number());
    
    $userid_number=$sessionManager->getUserId_number();
    $auth = new Authentication($sessionManager);
    $user_info = $auth->getUserInfo($userid_number);
    $first_name = $user_info['first_name'];
    $last_name = $user_info['last_name'];
    text_head("Welcome $first_name $last_name");
    ?>

    <div class="px-4">
        <div class="container-fluid py-5 border rounded-3 mt-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <a href="reserve_item.php" class="text-decoration-none">
                        <div class="card h-100 bg-danger text-white shadow-sm hover-card">
                            <div class="card-body text-center py-4">
                                <img src="../../assets/images/allitems.png" alt="Reserve Items" class="dashboard-icon mb-3" width="64">
                                <h5 class="card-title">Reserve Items</h5>
                                <p class="card-text">Browse and reserve available items</p>
                            </div>
                        </div>
                    </a>
                </div>
            
                <div class="col-md-4">
                    <a href="reservations.php" class="text-decoration-none">
                        <div class="card h-100 bg-success text-white shadow-sm hover-card">
                            <div class="card-body text-center py-4">
                                <img src="../../assets/images/return.png" alt="Reservations" class="dashboard-icon mb-3" width="64">
                                <h5 class="card-title">Reservations</h5>
                                <p class="card-text">Active Reservations: <span class="badge bg-white text-success"><?= $stats['reserved'] ?></span></p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="notifications.php" class="text-decoration-none">
                        <div class="card h-100 bg-primary text-white shadow-sm hover-card">
                            <div class="card-body text-center py-4">
                                <img src="../../assets/images/bell.png" alt="Notifications" class="dashboard-icon mb-3" width="64">
                                <h5 class="card-title">Notifications</h5>
                                <p class="card-text">View your latest updates</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
    .hover-card {
        transition: transform 0.2s ease-in-out;
    }
    .hover-card:hover {
        transform: translateY(-5px);
    }
    </style>
</body></html>