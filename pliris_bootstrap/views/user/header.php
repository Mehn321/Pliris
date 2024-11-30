  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <style>
          .sidebar {
              width: 180px;
              height: 100vh;
              position: fixed;
              left: -180px;
              top: 0;
              background: white;
              transition: 0.3s;
              z-index: 1000;
              box-shadow: 0 0 10px rgba(0,0,0,0.1);
          }
          .sidebar.show { left: 0; }
          .navbar { height: 60px; }
          .nav-link {
              padding: 10px 15px;
              color: #333;
              font-size: 14px;
          }
          .nav-link:hover {
              background: #f8f9fa;
              color: #0d6efd;
          }
          .notification-badge {
              position: absolute;
              top: -5px;
              right: -5px;
              width: 18px;
              height: 18px;
              background: red;
              color: white;
              border-radius: 50%;
              font-size: 11px;
              display: flex;
              align-items: center;
              justify-content: center;
          }
          @media (max-width: 576px) {
              .sidebar { width: 160px; left: -160px; }
          }
      </style>
  </head>
  <body>
  <?php
  function text_head($headertext) {
      require_once 'src/shared/sessionmanager.php';
      require_once '../../src/user/notifications.php';
      $sessionManager = new SessionManager();
      $notificationManager = new UserNotificationsManager($sessionManager);
      $notificationManager->createReturnReminderNotification();
      $not_seenNotificationcount = $notificationManager->not_seenNotificationCount();

      if (isset($_POST['logout'])) {
          $sessionManager->handleUserLogout();
          header("Location: ../../index.php");
          exit();
      }
      ?>

      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
          <div class="container-fluid px-3">
              <button class="btn p-0" onclick="toggleSidebar()">
                  <img src="../../assets/images/menuwhite.png" alt="menu" height="25">
              </button>
            
              <div class="d-flex align-items-center gap-2">
                  <img src="../../assets/images/ustplogo.png" alt="USTP Logo" height="30">
                  <span class="text-white small"><?php echo $headertext; ?></span>
              </div>
            
              <div class="d-flex align-items-center gap-3">
                  <a href="notifications.php" class="position-relative">
                      <img src="../../assets/images/bell.png" alt="notifications" height="20">
                      <?php if ($not_seenNotificationcount > 0): ?>
                          <span class="notification-badge"><?php echo $not_seenNotificationcount; ?></span>
                      <?php endif; ?>
                  </a>
                
                  <form action="" method="post" class="m-0">
                      <button type="submit" name="logout" class="btn btn-sm btn-light px-3 py-1">
                          Logout
                      </button>
                  </form>
              </div>
          </div>
      </nav>

      <div class="sidebar">
          <div class="bg-primary p-3 d-flex align-items-center">
              <button class="btn p-0" onclick="toggleSidebar()">
                  <img src="../../assets/images/menuwhite.png" alt="menu" height="25">
              </button>
              <span class="text-white ms-3 small">Menu</span>
          </div>
        
          <div class="nav flex-column mt-2">
              <a href="dashboard.php" class="nav-link">Dashboard</a>
              <a href="reserve_item.php" class="nav-link">Reserve Items</a>
              <a href="return_items.php" class="nav-link">Return Items</a>
          </div>
      </div>

      <script>
          function toggleSidebar() {
              document.querySelector('.sidebar').classList.toggle('show');
          }
      </script>
      <?php
  }
  ?>
  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
  </html>