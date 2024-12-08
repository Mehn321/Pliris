<?php
class Authentication extends Database {
    private $sessionManager;
    
    public function __construct(SessionManager $sessionManager) {
        parent::__construct();
        $this->sessionManager = $sessionManager;
    }
    
    public function handleUserLogin($id_number, $password) {
        $result = $this->validateUserCredentials($id_number, $password);
        if ($result['success']) {
            $this->sessionManager->setUserSession($id_number);
        }
        return $result;
    }
    
    public function handleAdminLogin($id_number, $password) {
        if ($id_number !== '999999999') {
            return ['success' => false, 'message' => 'Invalid admin credentials'];
        }
        $result = $this->validateAdminCredentials($id_number, $password);
        if ($result['success']) {
            $this->sessionManager->setAdminSession($id_number);
        }
        return $result;
    }
    
    private function validateUserCredentials($id_number, $password) {
        $result = $this->retrieve("*", "accounts", "id_number='$id_number'");
        if ($result->num_rows === 0) {
            return ['success' => false, 'message' => 'ID number not found'];
        }
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            return ['success' => true];
        }
        return ['success' => false, 'message' => 'Invalid password'];
    }
    
    private function validateAdminCredentials($id_number, $password) {
        $result = $this->retrieve("password", "accounts", "id_number='999999999'");
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            return ['success' => true];
        }
        return ['success' => false, 'message' => 'Invalid admin password'];
    }

    public function handleRegistration($userData) {
        if ($this->exists('accounts', "id_number='{$userData['id_number']}'")) {
            $admin = $this->getAdminInfo();
            return [
                'success' => false, 
                'message' => "ID Number already exists. If you forgot your password, please contact {$admin['first_name']} {$admin['last_name']}."
            ];
        }
        
        $hashedPassword = password_hash($userData['password'], PASSWORD_BCRYPT);
        
        $columns = 'first_name, last_name, id_number, email, middle_initial, password';
        $values = "'{$userData['first_name']}',
                '{$userData['last_name']}',
                '{$userData['id_number']}',
                '{$userData['email']}',
                '{$userData['middle_initial']}',
                '$hashedPassword'";
        $this->insert('accounts', $columns, $values);
        $this->sessionManager->setUserSession($userData['id_number']);
        return true;
        
    }
    
    private function getAdminInfo() {
        return $this->retrieve('first_name, last_name', 'accounts', "id_number='999999999'")->fetch_assoc();
    }

    public function getUserinfo($userid_number) {
        return $this->retrieve('first_name, last_name, middle_initial', 'accounts', "id_number='$userid_number'")->fetch_assoc();
    }
}
