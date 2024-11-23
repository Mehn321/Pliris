<?php
class SessionManager {
    private $redirectPath = '../index.php';

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function setAdminSession($id) {
        $_SESSION['id_admin'] = $id;
    }

    public function setUserSession($id) {
        $_SESSION['id_number'] = $id;
    }

    public function getAdminId() {
        return $_SESSION['id_admin'] ?? null;
    }

    public function getUserId_number() {
        return $_SESSION['id_number'] ?? null;
    }

    public function isAdminLoggedIn() {
        return isset($_SESSION['id_admin']);
    }

    public function isUserLoggedIn() {
        return isset($_SESSION['id_number']);
    }

    public function checkAdminAccess() {
        if (!$this->isAdminLoggedIn()) {
            $this->redirectToLogin();
        }
    }

    public function checkUserAccess() {
        if (!$this->isUserLoggedIn()) {
            $this->redirectToLogin();
        }
    }

    public function handleLogout() {
        if (isset($_POST['logout'])) {
            $this->logout();
        }
    }

    public function logout() {
        if ($this->isAdminLoggedIn()) {
            unset($_SESSION['id_admin']);
        }
        if ($this->isUserLoggedIn()) {
            unset($_SESSION['id_number']);
        }
        session_destroy();
    }

    private function redirectToLogin() {
        header("Location: " . $this->redirectPath);
        exit;
    }

    public function setRedirectPath($path) {
        $this->redirectPath = $path;
    }
}
