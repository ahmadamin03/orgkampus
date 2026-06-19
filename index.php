<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/Controllers/AuthController.php';

$route = $_GET['route'] ?? 'home';
$action = $_GET['action'] ?? null;

$authController = new AuthController($pdo);

switch ($route) {
    case 'home':
        require_once __DIR__ . '/resources/views/home.php';
        break;
    
    case 'login':
        if ($action === 'process') {
            $authController->login();
        } else {
            $authController->showLogin();
        }
        break;
        
    case 'signup':
        if ($action === 'process') {
            $authController->register();
        } else {
            $authController->showSignup();
        }
        break;
        
    case 'logout':
        $authController->logout();
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}
