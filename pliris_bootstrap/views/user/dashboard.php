<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLIRIS Dashboard</title>
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f5f5; }
        .dashboard-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
        }
        .card-icon {
            width: 45px;
            height: 45px;
            background: #e7f1ff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <?php
    include 'header.php';

    require_once '../../src/shared/database.php';
    require_once '../../src/shared/sessionmanager.php';
    require_once '../../src/user/dashboard.php';
    require_once '../../src/shared/authentication.php';

    $sessionManager = new SessionManager();
    $sessionManager->checkUserAccess();
    // $sessionManager->handleUserLogout();

    $dashboard = new UserDashboard();
    $stats = $dashboard->getDashboardStats($sessionManager->getUserId_number());
    
    $userid_number=$sessionManager->getUserId_number();
    $auth = new Authentication($sessionManager);
    $user_info = $auth->getUserInfo($userid_number);
    $first_name = $user_info['first_name'];
    $last_name = $user_info['last_name'];
    text_head("Dashboard");
?>
      <div class="content">
          <div class="container-fluid p-4">
              <h4 class="mb-4">Dashboard</h4>
        
              <!-- Statistics Cards -->
              <div class="row g-3 mb-4">
                  <div class="col-md-4">
                      <div class="dashboard-card p-3">
                          <div class="d-flex align-items-center">
                              <div class="card-icon me-3">
                                  <img src="../../assets/images/pending.png" alt="Pending" height="25">
                              </div>
                              <div>
                                  <h6 class="mb-1">Pending Requests</h6>
                                  <h4 class="mb-0 text-warning">12</h4>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="dashboard-card p-3">
                          <div class="d-flex align-items-center">
                              <div class="card-icon me-3">
                                  <img src="../../assets/images/active.png" alt="Active" height="25">
                              </div>
                              <div>
                                  <h6 class="mb-1">Active Reservations</h6>
                                  <h4 class="mb-0 text-primary">8</h4>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="dashboard-card p-3">
                          <div class="d-flex align-items-center">
                              <div class="card-icon me-3">
                                  <img src="../../assets/images/completed.png" alt="Completed" height="25">
                              </div>
                              <div>
                                  <h6 class="mb-1">Total Completed</h6>
                                  <h4 class="mb-0 text-success">45</h4>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>















































              <!-- Main Content Area -->
              <div class="row g-3">
                  <div class="col-md-8">
                      <div class="dashboard-card p-3">
                          <h5 class="mb-3">Recent Activities</h5>
                          <div class="table-responsive">
                              <table class="table table-hover">
                                  <thead>
                                      <tr>
                                          <th>Date</th>
                                          <th>Item</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                          <td>2023-10-15</td>
                                          <td>Laboratory Equipment</td>
                                          <td><span class="badge bg-warning">Pending</span></td>
                                          <td>
                                              <button class="btn btn-sm btn-outline-primary">View</button>
                                          </td>
                                      </tr>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>






























































                  <!-- Quick Actions -->
                  <div class="col-md-4">
                      <div class="dashboard-card p-3">
                          <h5 class="mb-3">Quick Actions</h5>
                          <div class="d-grid gap-2">
                              <a href="reserve_item.php" class="btn btn-primary">
                                  <i class="bi bi-plus-circle me-2"></i>New Reservation
                              </a>
                              <a href="return_items.php" class="btn btn-outline-primary">
                                  <i class="bi bi-arrow-return-left me-2"></i>Return Items
                              </a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>