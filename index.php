<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once __DIR__ . '/src/shared/sessionmanager.php';
require_once __DIR__ . '/src/shared/authentication.php';

$sessionManager = new SessionManager();
$auth = new Authentication($sessionManager);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $id_number = $_POST['id_number'];
    $password = $_POST['password'];
    
    // Try admin login first
    $result = $auth->handleAdminLogin($id_number, $password);
    if ($result['success']) {
        header('Location: views/admin/dashboard.php');
        exit;
    }
    
    // If not admin, try user login
    $result = $auth->handleUserLogin($id_number, $password);
    if ($result['success']) {
        header('Location: views/user/dashboard.php');
        exit;
    }
    
    $message = $result['message'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLIRIS - Physics Laboratory Login</title>
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
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 500px;
            width: 90%;
            position: relative;
            z-index: 2;
            backdrop-filter: blur(10px);
        }
        
        .logo-img {
            width: 120px;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }
        
        .hero-image {
            width: 100%;
            max-width: 250px;
            margin-bottom: 30px;
            animation: pulse 2s ease-in-out infinite;
        }
        
        .form-floating {
            margin-bottom: 20px;
        }
        
        .form-control:focus {
            border-color: #1e3c72;
            box-shadow: 0 0 0 0.25rem rgba(30, 60, 114, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-login:hover {
            background: linear-gradient(45deg, #2a5298, #1e3c72);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 60, 114, 0.4);
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
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

        .register-link {
    display: inline-block;
    color: #2a5298;
    font-weight: bold;
    padding: 5px 10px;
    text-decoration: none;
    position: relative;
    z-index: 10000;
    cursor: pointer;
}

.register-link:hover {
    color: #1e3c72;
    text-decoration: underline;
}

/* Remove any potential overlay interference */
.particles, .wave {
    pointer-events: none;
}
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="particles" id="particles-js"></div>
    <div class="wave wave1"></div>
    <div class="wave wave2"></div>
    
    <div class="login-container">
        <div class="text-center">
            <img src="assets/images/ustplogo.png" alt="USTP Logo" class="logo-img">
            <img src="https://cdn-icons-png.flaticon.com/512/2103/2103632.png" alt="Physics Lab" class="hero-image">
            <h2 class="mb-2 fw-bold gradient-text">Welcome to PLIRIS</h2>
            <p class="text-muted mb-4">Physics Laboratory Item Reservation and Inventory System</p>
        </div>

        <?php if (isset($message)): ?>
            <div class="alert alert-danger text-center mb-4 animate__animated animate__shakeX">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="post" class="needs-validation" novalidate>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="id_number" name="id_number" pattern="\d*" placeholder="ID Number" required>
                <label for="id_number"><i class="bi bi-person-badge me-2"></i>ID Number</label>
                <div class="invalid-feedback">Please enter your ID number.</div>
            </div>

            <div class="form-floating position-relative">
                <input type="password" class="form-control" id="passwordField" name="password" placeholder="Password" required>
                <label for="passwordField"><i class="bi bi-key me-2"></i>Password</label>
                <span class="position-absolute top-50 end-0 translate-middle-y pe-3" style="cursor: pointer" id="togglePassword">
                    <i class="bi bi-eye"></i>
                </span>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" name="login" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </button>
            </div>
              <p class="text-center mt-4 mb-0" style="position: relative; z-index: 9999;">
                  Don't have an account? 
                  <a href="register.php" 
                   onclick="window.location.href='register.php'" 
                   class="register-link">
                      Register
                  </a>
              </p>
          </form>






  <style>
  .register-link {
      display: inline-block;
      color: #2a5298;
      font-weight: bold;
      padding: 5px 10px;
      text-decoration: none;
      position: relative;
      z-index: 10000;
      cursor: pointer;
  }

  .register-link:hover {
      color: #1e3c72;
      text-decoration: underline;
  }

  /* Remove any potential overlay interference */
  .particles, .wave {
      pointer-events: none;
  }
  </style>
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

        // Password toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('passwordField');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            this.innerHTML = type === 'password' ? 
                '<i class="bi bi-eye"></i>' : 
                '<i class="bi bi-eye-slash"></i>';
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
