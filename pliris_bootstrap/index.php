<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLIRIS Login</title>
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-control {
            padding: 8px 12px;
            font-size: 14px;
        }
        .form-label {
            font-size: 14px;
            margin-bottom: 4px;
        }
        .card {
            max-width: 400px;
            margin: 0 auto;
        }
        .btn {
            padding: 8px 16px;
        }
    </style>
</head>
<body style="background-color: #f5f5f5;">
    <?php
    require_once 'src/shared/database.php';
    require_once 'src/shared/sessionmanager.php';
    require_once 'src/shared/authentication.php';
    $message;
    $sessionManager = new SessionManager();
    $auth = new Authentication($sessionManager);

    if (isset($_POST['login'])) {
        $id_number = $_POST['id_number'];
        $password = $_POST['password'];
        $result = $auth->handleUserLogin($id_number, $password);
        if ($result['success']) {
            header("Location: views/user/dashboard.php");
            exit;
        }else{
            $message = $result['message'];
        }
    }
    ?>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <img src="assets/images/ustplogo.png" alt="USTP Logo" style="width: 80px;" class="mb-3">
                    <h4 class="fw-bold text-primary">Welcome to PLIRIS</h4>
                    <small class="text-muted">Physics Laboratory Item Reservation and Inventory System</small>
                </div>

                <?php if (isset($message)): ?>
                    <div class="alert alert-danger py-2 small" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="index.php" method="post">
                    <div class="mb-3">
                        <label class="form-label">ID Number</label>
                        <input type="text" class="form-control" name="id_number" pattern="[0-9]{}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary w-100 mb-3">
                        Sign In
                    </button>

                    <div class="text-center">
                        <small>Don't have an account? 
                            <a href="register.php" class="text-decoration-none">Register here</a>
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
