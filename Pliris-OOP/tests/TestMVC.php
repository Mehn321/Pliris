<?php

// Include required files
require_once "../config/database.php";
require_once "../src/Models/Auth/AuthModel.php";
require_once "../src/Models/User/NotificationModel.php";
require_once "../src/Services/AuthService.php";
require_once "../src/Services/NotificationService.php";
require_once "../src/Controllers/AuthController.php";
require_once "../src/Controllers/NotificationController.php";


// Database connection
$db = connect();

// Test data
$testUser = [
    'id_number' => '123456789',
    'password' => 'testpass',
    'first_name' => 'Test',
    'last_name' => 'User',
    'email' => 'test@test.com',
    'middle_initial' => 'T'
];

// Model Tests
echo "=== Testing Models ===\n";

// AuthModel Test
$authModel = new AuthModel($db);
echo "Testing AuthModel:\n";
$loginResult = $authModel->login($testUser['id_number'], $testUser['password']);
var_dump($loginResult);

$registerResult = $authModel->register(
    $testUser['first_name'],
    $testUser['last_name'],
    $testUser['id_number'],
    $testUser['email'],
    $testUser['middle_initial'],
    $testUser['password']
);
var_dump($registerResult);

// NotificationModel Test
$notificationModel = new NotificationModel($db, $testUser['id_number']);
echo "\nTesting NotificationModel:\n";
$notifications = $notificationModel->getNotifications();
var_dump($notifications);

// Service Tests
echo "\n=== Testing Services ===\n";

// AuthService Test
$authService = new AuthService($authModel,$notificationModel);
echo "Testing AuthService:\n";
$loginServiceResult = $authService->handleLogin($testUser['id_number'], $testUser['password']);
var_dump($loginServiceResult);

// NotificationService Test
$notificationService = new NotificationService($notificationModel);
echo "\nTesting NotificationService:\n";
$notificationCount = $notificationService->getTotalUnreadNotifications();
var_dump($notificationCount);

// Controller Tests
echo "\n=== Testing Controllers ===\n";

// AuthController Test
$authController = new AuthController($authService);
echo "Testing AuthController:\n";
$_POST['login'] = true;
$_POST['id_number'] = $testUser['id_number'];
$_POST['password'] = $testUser['password'];
$authControllerResult = $authController->login();
var_dump($authControllerResult);

// NotificationController Test
$notificationController = new NotificationController($notificationService);
echo "\nTesting NotificationController:\n";
$_SESSION['id_number'] = $testUser['id_number'];
$notificationDisplay = $notificationController->displayNotifications();
var_dump($notificationDisplay);
