<?php
class SessionManager {
    private $redirectPath = 'index.php';

    // Constructor starts a new session if none exists
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Set admin session ID
    public function setAdminSession($id) {
        $_SESSION['id_admin'] = $id;
    }

    // Set user session ID
    public function setUserSession($id) {
        $_SESSION['id_number'] = $id;
    }

    // Get admin session ID
    public function getAdminId() {
        return $_SESSION['id_admin'] ?? null;
    }

    // Get user session ID
    public function getUserId_number() {
        return $_SESSION['id_number'] ?? null;
    }

    // Check if admin is logged in
    public function isAdminLoggedIn() {
        return isset($_SESSION['id_admin']);
    }

    // Check if user is logged in
    private function isUserLoggedIn() {
        return isset($_SESSION['id_number']);
    }

    // Verify admin access, redirect if not logged in
    public function checkAdminAccess() {
        if (!$this->isAdminLoggedIn()) {
            $this->redirectToLogin();
        }
    }

    // Verify user access, redirect if not logged in
    public function checkUserAccess() {
        if (!$this->isUserLoggedIn()) {
            $this->redirectToLogin();
        }
    }

    // Handle user logout
    public function handleUserLogout() {
        if (isset($_POST['logout'])) {
            if ($this->isUserLoggedIn()) {
                unset($_SESSION['id_number']);
            }
        }
    }

    // Handle admin logout and destroy session
    public function handleAdminLogout() {
        if (isset($_POST['logout'])) {
            if ($this->isAdminLoggedIn()) {
                unset($_SESSION['id_admin']);
            }
            session_destroy();
        }
    }

    // Redirect to login page
    private function redirectToLogin() {
        header("Location: " . $this->redirectPath);
        exit;
    }

    // Set path for redirection
    public function setRedirectPath($path) {
        $this->redirectPath = $path;
    }
}

