<?php
session_start();

/**
 * Check if user is logged in, redirect to login if not
 */
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /school-management-system/pages/login.php");
        exit();
    }
}

/**
 * Check if user has the required role
 * @param array $allowedRoles Array of allowed roles e.g. ['admin', 'teacher']
 */
function requireRole($allowedRoles) {
    requireLogin();
    if (!in_array($_SESSION['role'], $allowedRoles)) {
        header("Location: /school-management-system/pages/dashboard.php?error=unauthorized");
        exit();
    }
}

/**
 * Check if the current user is logged in
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Get current user role
 * @return string|null
 */
function getUserRole() {
    return $_SESSION['role'] ?? null;
}

/**
 * Get current user ID
 * @return int|null
 */
function getUserId() {
    return $_SESSION['user_id'] ?? null;
}
?>
