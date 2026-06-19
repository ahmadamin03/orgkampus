<?php
require_once __DIR__ . '/../config/database.php';

class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function showLogin() {
        require_once __DIR__ . '/../../resources/views/auth/login.php';
    }

    public function showSignup() {
        require_once __DIR__ . '/../../resources/views/auth/signup.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';

            // Basic validation
            if (empty($name) || empty($email) || empty($password)) {
                die('Please fill all fields');
            }

            if ($password !== $password_confirm) {
                die('Passwords do not match');
            }

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert into db
            $stmt = $this->pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
            try {
                $stmt->execute([$name, $email, $hashedPassword]);
                // Redirect to login page
                header('Location: /index.php?route=login');
                exit;
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    die('Email already exists');
                }
                die('Database error: ' . $e->getMessage());
            }
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                die('Please fill all fields');
            }

            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header('Location: /index.php');
                exit;
            } else {
                die('Invalid email or password');
            }
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /index.php');
        exit;
    }
}
