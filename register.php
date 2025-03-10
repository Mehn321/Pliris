<?php
require_once 'src/shared/database.php';
require_once 'src/shared/sessionmanager.php';
require_once 'src/shared/authentication.php';

$sessionManager = new SessionManager();
$auth = new Authentication($sessionManager);

if(isset($_POST['submit'])){
    $result = $auth->handleRegistration($_POST);
    if($result['success']){
        header("Location: views/user/dashboard.php");
        exit;
    }else{
        $message = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLIRIS - Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .register-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 600px;
            width: 90%;
            position: relative;
            z-index: 2;
            backdrop-filter: blur(10px);
            margin: 40px auto;
        }
        
        .logo-img {
            width: 120px;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }
        
        .form-floating {
            margin-bottom: 20px;
        }
        
        .form-control:focus {
            border-color: #1e3c72;
            box-shadow: 0 0 0 0.25rem rgba(30, 60, 114, 0.25);
        }
        
        .btn-register {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-register:hover {
            background: linear-gradient(45deg, #2a5298, #1e3c72);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 60, 114, 0.4);
        }

        .gradient-text {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
        }

        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: url('https://raw.githubusercontent.com/Abdulrahman-Khalid/login-page-waves/master/wave.png');
            background-size: 1000px 100px;
            animation: wave 10s linear infinite;
            z-index: 1;
            pointer-events: none;
        }
        
        .wave.wave1 {
            animation: wave 30s linear infinite;
            z-index: 1000;
            opacity: 1;
            animation-delay: 0s;
            bottom: 0;
        }
        
        .wave.wave2 {
            animation: wave2 15s linear infinite;
            z-index: 999;
            opacity: 0.5;
            animation-delay: -5s;
            bottom: 10px;
        }
        
        @keyframes wave {
            0% { background-position-x: 0; }
            100% { background-position-x: 1000px; }
        }
        
        @keyframes wave2 {
            0% { background-position-x: 0; }
            100% { background-position-x: -1000px; }
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body>
    <div class="particles" id="particles-js"></div>
    <div class="wave wave1"></div>
    <div class="wave wave2"></div>
    
    <div class="register-container">
        <div class="text-center">
            <img src="ustplogo.png" alt="USTP Logo" class="logo-img">
            <h2 class="mb-2 fw-bold gradient-text">Create Your Account</h2>
            <p class="text-muted mb-4">Physics Laboratory Item Reservation and Inventory System</p>
        </div>

        <?php if (isset($message)): ?>
            <div class="alert alert-danger text-center mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="needs-validation" novalidate>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" required>
                        <label for="first_name"><i class="bi bi-person me-2"></i>First Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" required>
                        <label for="last_name"><i class="bi bi-person me-2"></i>Last Name</label>
                    </div>
                </div>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="middle_initial" id="middle_initial" maxlength="1" placeholder="Middle Initial">
                <label for="middle_initial"><i class="bi bi-person me-2"></i>Middle Initial</label>
            </div>

            <div class="form-floating mb-3">
                <input type="number" class="form-control" name="id_number" id="id_number" placeholder="ID Number" required>
                <label for="id_number"><i class="bi bi-person-badge me-2"></i>ID Number</label>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                <label for="email"><i class="bi bi-envelope me-2"></i>Email</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" id="passwordField1" placeholder="Password" required>
                <label for="passwordField1"><i class="bi bi-key me-2"></i>Create Password</label>
                <span class="position-absolute top-50 end-0 translate-middle-y pe-3" style="cursor: pointer" id="togglePassword1">
                    <i class="bi bi-eye"></i>
                </span>
            </div>

            <div class="form-floating mb-4">
                <input type="password" class="form-control" name="confirm_password" id="passwordField2" placeholder="Confirm Password" required>
                <label for="passwordField2"><i class="bi bi-key-fill me-2"></i>Confirm Password</label>
                <span class="position-absolute top-50 end-0 translate-middle-y pe-3" style="cursor: pointer" id="togglePassword2">
                    <i class="bi bi-eye"></i>
                </span>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" name="submit" class="btn btn-register">
                    <i class="bi bi-person-plus me-2"></i>Create Account
                </button>
            </div>

            <p class="text-center mt-4 mb-0">
                Already have an account? 
                <a href="index.php" class="text-decoration-none fw-bold gradient-text" style="position: relative; z-index: 9999;">Login</a>
            </p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS('particles-js', {
            particles: {
                number: { value: 80 },
                color: { value: '#ffffff' },
                shape: { type: 'circle' },
                opacity: { value: 0.5 },
                size: { value: 3 },
                move: {
                    enable: true,
                    speed: 2
                }
            }
        });

        // Password toggle functionality
        ['1', '2'].forEach(num => {
            document.getElementById(`togglePassword${num}`).addEventListener('click', function() {
                const passwordField = document.getElementById(`passwordField${num}`);
                const type = passwordField.type === 'password' ? 'text' : 'password';
                passwordField.type = type;
                this.innerHTML = type === 'password' ? 
                    '<i class="bi bi-eye"></i>' : 
                    '<i class="bi bi-eye-slash"></i>';
            });
        });

        // Form validation
        (function () {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>
