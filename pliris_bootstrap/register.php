<?php
require_once 'src/shared/database.php';
require_once 'src/shared/sessionmanager.php';
require_once 'src/shared/authentication.php';

$sessionManager = new SessionManager();
$auth = new Authentication($sessionManager);

if(isset($_POST['submit'])){
    $result = $auth->handleRegistration($_POST);
    if($result['success']){
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLIRIS Registration</title>
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">PLIRIS Registration</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="assets/images/ustplogo.png" alt="USTP Logo" class="img-fluid mb-3" style="max-width: 120px;">
                            <h2 class="text-primary fw-bold">Create Account</h2>
                            <p class="text-muted">Physics Laboratory Item Reservation and Inventory System</p>
                        </div>

                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="first_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Middle Initial</label>
                                <input type="text" class="form-control" name="middle_initial" maxlength="1" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">ID Number</label>
                                <input type="number" class="form-control" name="id_number" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Create Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="submit" class="btn btn-primary btn-lg">
                                    Register
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <span>Already have an account?</span>
                                <a href="index.php" class="text-decoration-none">Login here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
