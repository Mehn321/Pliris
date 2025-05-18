<?php

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/sessionmanager.php';

/**
 * Handles user and admin authentication
 */
class Authentication extends Database {
    private $sessionManager;
    
    public function __construct(SessionManager $sessionManager) {
        parent::__construct();
        $this->sessionManager = $sessionManager;
    }
    
    // Handle user login and set session if successful
    public function handleUserLogin($id_number, $password) {
        $result = $this->validateUserCredentials($id_number, $password);
        if ($result['success']) {
            $this->sessionManager->setUserSession($id_number);
        }
        return $result;
    }
    
    // Handle admin login, allowing only a specific admin ID
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
        // Validate user credentials against the database
        private function validateUserCredentials($id_number, $password) {
            // Escape the input to prevent SQL injection
            $id_number = $this->conn->real_escape_string($id_number);
        
            $result = $this->retrieve("*", "accounts", "id_number='$id_number' AND role_name='user'");
        
            // Check if query was successful
            if ($result === false) {
                return ['success' => false, 'message' => 'Database error: ' . $this->conn->error];
            }
        
            if ($result->num_rows === 0) {
                return ['success' => false, 'message' => 'ID number not found'];
            }
        
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return ['success' => true];
            }
        
            return ['success' => false, 'message' => 'Invalid password'];
        }
    // Validate admin credentials
    private function validateAdminCredentials($id_number, $password) {
        $result = $this->retrieve("password", "accounts", "id_number='999999999'");
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            return ['success' => true];
        }
        return ['success' => false, 'message' => 'Invalid admin password'];
    }

    // Validate if passwords match during registration
    private function validatePasswords($password, $confirmPassword) {
        if($password !== $confirmPassword) {
            return ['success' => false, 'message' => 'Passwords do not match!'];
        }
        return ['success' => true];
    }

    // Handle user registration and create account if valid
    public function handleRegistration($userData) {
        $passwordValidation = $this->validatePasswords($userData['password'], $userData['confirm_password']);
    
        if(!$passwordValidation['success']) {
            return $passwordValidation;
        }
        elseif($this->exists('accounts', "id_number='{$userData['id_number']}'")) {
            $admin = $this->getAdminInfo();
            return [
                'success' => false, 
                'message' => "ID Number already exists. If you forgot your password, please contact Sir/Maam {$admin['first_name']} {$admin['last_name']} at {$admin['email']}."
            ];
        } else {
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
            return ['success' => true];
        }
    }
    
    // Get admin contact information
    private function getAdminInfo() {
        return $this->retrieve('first_name, last_name, email', 'accounts', "id_number='999999999'")->fetch_assoc();
    }

    // Retrieve user information
    public function getUserinfo($userid_number) {
        return $this->retrieve('first_name, last_name, middle_initial', 'accounts', "id_number='$userid_number'")->fetch_assoc();
    }
}