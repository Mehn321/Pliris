<?php
include "header.php";
require_once '../../src/shared/database.php';
require_once '../../src/shared/sessionmanager.php';
require_once '../../src/admin/dashboard.php';

$sessionManager = new SessionManager();
$sessionManager->setRedirectPath("index.php");
$sessionManager->checkAdminAccess();

$dashboard = new AdminDashboard();
text_head("Welcome Admin");
$stats = $dashboard->getDashboardStats();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <div class="container-fluid px-4 py-5">
        <!-- Stats Overview -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <a href="items.php" class="text-decoration-none">
                    <div class="card bg-white shadow-sm border-0 rounded-3 hover-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-0">Total Items</p>
                                    <h3 class="fw-bold mb-0 text-dark"><?php echo $stats['items']; ?></h3>
                                </div>
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="bi bi-box-seam text-primary fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="reserved_items.php" class="text-decoration-none">
                    <div class="card bg-white shadow-sm border-0 rounded-3 hover-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-0">Reserved Items</p>
                                    <h3 class="fw-bold mb-0 text-dark"><?php echo $stats['reserved']; ?></h3>
                                </div>
                                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                    <i class="bi bi-bookmark-check text-warning fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="returned_items.php" class="text-decoration-none">
                    <div class="card bg-white shadow-sm border-0 rounded-3 hover-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-0">Returned Items</p>
                                    <h3 class="fw-bold mb-0 text-dark"><?php echo $stats['returned']; ?></h3>
                                </div>
                                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                    <i class="bi bi-arrow-return-left text-success fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="accounts.php" class="text-decoration-none">
                    <div class="card bg-white shadow-sm border-0 rounded-3 hover-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-0">Total Accounts</p>
                                    <h3 class="fw-bold mb-0 text-dark"><?php echo $stats['accounts']; ?></h3>
                                </div>
                                <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                    <i class="bi bi-people text-info fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row g-4">
            <div class="col-md-4">
                <a href="records.php" class="text-decoration-none">
                    <div class="card hover-card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-file-text text-primary fs-3 me-3"></i>
                                <h5 class="card-title mb-0 text-dark">View Records</h5>
                            </div>
                            <p class="card-text text-muted">View transaction history and reports</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="items.php" class="text-decoration-none">
                    <div class="card hover-card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-grid-3x3-gap-fill text-success fs-3 me-3"></i>
                                <h5 class="card-title mb-0 text-dark">Manage Items</h5>
                            </div>
                            <p class="card-text text-muted">View and manage inventory items</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="accounts.php" class="text-decoration-none">
                    <div class="card hover-card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-person-fill-gear text-info fs-3 me-3"></i>
                                <h5 class="card-title mb-0 text-dark">Manage Accounts</h5>
                            </div>
                            <p class="card-text text-muted">View and manage user accounts</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <style>
    .hover-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
