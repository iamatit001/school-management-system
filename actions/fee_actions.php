<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$action = $_POST['action'] ?? $_GET['action'] ?? '';
switch ($action) {
    case 'add':
        $stmt = $pdo->prepare("INSERT INTO fees (student_id, amount, status, due_date) VALUES (:student_id, :amount, :status, :due_date)");
        $stmt->execute(['student_id' => $_POST['student_id'], 'amount' => $_POST['amount'], 'status' => $_POST['status'], 'due_date' => $_POST['due_date']]);
        header("Location: /school-management-system/modules/fees/list.php?success=added"); exit();
    case 'mark_paid':
        $stmt = $pdo->prepare("UPDATE fees SET status='Paid' WHERE id=:id");
        $stmt->execute(['id' => $_GET['id']]);
        header("Location: /school-management-system/modules/fees/list.php?success=updated"); exit();
    case 'delete':
        $stmt = $pdo->prepare("DELETE FROM fees WHERE id = :id");
        $stmt->execute(['id' => $_GET['id']]);
        header("Location: /school-management-system/modules/fees/list.php?success=deleted"); exit();
    default:
        header("Location: /school-management-system/modules/fees/list.php"); exit();
}
?>
