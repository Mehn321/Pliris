<?php
require_once "database.php";
class Authentication extends Database {
    private $sessionManager;
    
    public function __construct(SessionManager $sessionManager) {
        parent::__construct();
        $this->sessionManager = $sessionManager;
    }
    
    public function handleUserLogin($credentials) {
        $result = $this->validateUserCredentials($credentials);
        if ($result['success']) {
            $this->sessionManager->setUserSession($credentials['id_number']);
        }
        return $result;
    }
    
    public function handleAdminLogin($credentials) {
        if ($credentials['id_number'] !== '999999999') {
            return ['success' => false, 'message' => 'Invalid admin credentials'];
        }else{
            $result = $this->validateAdminCredentials($credentials);
            if ($result['success']) {
                $this->sessionManager->setAdminSession($credentials['id_number']);
            }
            return $result;
        }
        
    }
    
    private function validateUserCredentials($credentials) {
        $result = $this->retrieve("*", "accounts", "id_number='{$credentials['id_number']}'");
        if ($result->num_rows === 0) {
            return ['success' => false, 'message' => 'ID number not found'];
        }
        $user = $result->fetch_assoc();
        if ($user['password'] === $credentials['password']) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Invalid password'];
        }
    }
    
    private function validateAdminCredentials($credentials) {
        $result = $this->retrieve("password", "accounts", "id_number='999999999'");
        $admin = $result->fetch_assoc();
        if ($admin['password'] === $credentials['password']) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Invalid admin password'];
        }
    }    
    public function handleRegistration($userData) {
        if ($this->exists('accounts', "id_number='{$userData['id_number']}'")) {
            $admin = $this->getAdminInfo();
            return [
                'success' => false, 
                'message' => "ID Number already exists. If you forgot your password, please contact {$admin['first_name']} {$admin['last_name']}."
            ];
        }
        
        $columns = 'first_name, last_name, id_number, email, middle_initial, password';
        $values = "'{$userData['first_name']}',
                '{$userData['last_name']}',
                '{$userData['id_number']}',
                '{$userData['email']}',
                '{$userData['middle_initial']}',
                '{$userData['password']}'";
        
        $this->insert('accounts', $columns, $values);
        return ['success' => true, 'redirect' => 'index.php'];
    }
    
    private function getAdminInfo() {
        return $this->retrieve('first_name, last_name', 'accounts', "id_number='999999999'")->fetch_assoc();
    }
}
