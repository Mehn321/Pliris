  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>PLIRIS</title>
      <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
      <link href="../../assets/css/style.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  </head>
  <body>
  <?php
  function text_head($headertext) {
      require_once '../../src/shared/sessionmanager.php';
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

      <nav class="navbar navbar-expand-lg bg-primary py-2">
          <div class="container-fluid px-4">
              <div class="d-flex align-items-center justify-content-between w-100">
                  <div class="d-flex align-items-center gap-3">
                      <button class="btn p-0" onclick="toggleSidebar()">
                          <img src="../../assets/images/menuwhite.png" alt="menu" height="25">
                      </button>
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
          </div>
      </nav>

      <div class="sidebar">
          <div class="nav flex-column mt-2">
              <a href="dashboard.php" class="nav-link">Dashboard</a>
              <a href="reserve_item.php" class="nav-link">Reserve Items</a>
              <a href="reservations.php" class="nav-link">Return Items</a>
          </div>
      </div>

      <script>
          function toggleSidebar() {
              document.querySelector('.sidebar').classList.toggle('collapsed');
              document.querySelector('.content').classList.toggle('expanded');
          }
      </script>
      <?php
  }
  ?>
  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  </body>
  </html>