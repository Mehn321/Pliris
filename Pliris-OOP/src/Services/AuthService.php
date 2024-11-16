<?php

class AuthService {
    private $authModel;
    private $notificationModel;

    public function __construct(AuthModel $authModel, NotificationModel $notificationModel) {
        $this->authModel = $authModel;
        $this->notificationModel = $notificationModel;
    }

    public function handleLogin($id_number, $password) {
        $loginResult = $this->authModel->login($id_number, $password);
        
        if($loginResult) {
            session_start();
            $_SESSION['id_number'] = $id_number;
            
            if($loginResult['type'] === 'admin') {
                header("Location: ../pliris-admin/php/dashboard.php");
            } else {
                header("Location: php/dashboard.php");
            }
            return true;
        }
        return false;
    }

    public function handleRegistration($first_name, $last_name, $id_number, $email, $middle_initial, $password) {
        $registrationResult = $this->authModel->register($first_name, $last_name, $id_number, $email, $middle_initial, $password);
        
        if($registrationResult['status']) {
            $this->notificationModel->addNotification("Welcome to Pliris!");
            return true;
        }
        return $registrationResult;
    }
}
