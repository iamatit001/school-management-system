<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$action = $_POST['action'] ?? $_GET['action'] ?? '';
switch ($action) {
    case 'add':
        $stmt = $pdo->prepare("INSERT INTO classes (class_name, section) VALUES (:class_name, :section)");
        $stmt->execute(['class_name' => trim($_POST['class_name']), 'section' => trim($_POST['section'])]);
        header("Location: /school-management-system/modules/classes/list.php?success=added"); exit();
    case 'update':
        $stmt = $pdo->prepare("UPDATE classes SET class_name=:class_name, section=:section WHERE id=:id");
        $stmt->execute(['class_name' => trim($_POST['class_name']), 'section' => trim($_POST['section']), 'id' => $_POST['id']]);
        header("Location: /school-management-system/modules/classes/list.php?success=updated"); exit();
    case 'delete':
        $stmt = $pdo->prepare("DELETE FROM classes WHERE id = :id");
        $stmt->execute(['id' => $_GET['id']]);
        header("Location: /school-management-system/modules/classes/list.php?success=deleted"); exit();
    default:
        header("Location: /school-management-system/modules/classes/list.php"); exit();
}
?>
