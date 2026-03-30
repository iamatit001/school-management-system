<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$action = $_POST['action'] ?? $_GET['action'] ?? '';
switch ($action) {
    case 'add':
        $stmt = $pdo->prepare("INSERT INTO subjects (subject_name, class_id) VALUES (:subject_name, :class_id)");
        $stmt->execute(['subject_name' => trim($_POST['subject_name']), 'class_id' => $_POST['class_id']]);
        header("Location: /school-management-system/modules/subjects/list.php?success=added"); exit();
    case 'delete':
        $stmt = $pdo->prepare("DELETE FROM subjects WHERE id = :id");
        $stmt->execute(['id' => $_GET['id']]);
        header("Location: /school-management-system/modules/subjects/list.php?success=deleted"); exit();
    default:
        header("Location: /school-management-system/modules/subjects/list.php"); exit();
}
?>
