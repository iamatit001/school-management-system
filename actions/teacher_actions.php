<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        $stmt = $pdo->prepare("INSERT INTO teachers (name, subject, phone, email) VALUES (:name, :subject, :phone, :email)");
        $stmt->execute(['name' => trim($_POST['name']), 'subject' => trim($_POST['subject']), 'phone' => trim($_POST['phone'] ?? ''), 'email' => trim($_POST['email'] ?? '')]);
        header("Location: /school-management-system/modules/teachers/list.php?success=added"); exit();
    case 'update':
        $stmt = $pdo->prepare("UPDATE teachers SET name=:name, subject=:subject, phone=:phone, email=:email WHERE id=:id");
        $stmt->execute(['name' => trim($_POST['name']), 'subject' => trim($_POST['subject']), 'phone' => trim($_POST['phone'] ?? ''), 'email' => trim($_POST['email'] ?? ''), 'id' => $_POST['id']]);
        header("Location: /school-management-system/modules/teachers/list.php?success=updated"); exit();
    case 'delete':
        $stmt = $pdo->prepare("DELETE FROM teachers WHERE id = :id");
        $stmt->execute(['id' => $_GET['id']]);
        header("Location: /school-management-system/modules/teachers/list.php?success=deleted"); exit();
    default:
        header("Location: /school-management-system/modules/teachers/list.php"); exit();
}
?>
