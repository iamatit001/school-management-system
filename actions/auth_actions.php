<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($username) || empty($password)) {
        header("Location: /school-management-system/pages/login.php?error=invalid");
        exit();
    }

    // Fetch user from database using prepared statement
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect to dashboard
        header("Location: /school-management-system/pages/dashboard.php");
        exit();
    } else {
        header("Location: /school-management-system/pages/login.php?error=invalid");
        exit();
    }
} else {
    header("Location: /school-management-system/pages/login.php");
    exit();
}
?>
