
<?php

class AuthController {
    private $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login() {
        if(isset($_POST['login'])) {
            $id_number = $_POST['id_number'];
            $password = $_POST['password'];
            
            return $this->authService->handleLogin($id_number, $password);
        }
    }

    public function register() {
        if(isset($_POST['submit'])) {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $id_number = $_POST['id_number'];
            $email = $_POST['email'];
            $middle_initial = $_POST['middle_initial'];
            $password = $_POST['password'];

            return $this->authService->handleRegistration(
                $first_name, 
                $last_name, 
                $id_number, 
                $email, 
                $middle_initial, 
                $password
            );
        }
    }
}
