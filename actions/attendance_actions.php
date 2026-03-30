<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$classId = $_POST['class_id'];
$date = $_POST['date'];
$attendanceData = $_POST['attendance'] ?? [];

// Delete existing attendance for this date and class
$deleteStmt = $pdo->prepare("DELETE FROM attendance WHERE date = :date AND student_id IN (SELECT id FROM students WHERE class_id = :class_id)");
$deleteStmt->execute(['date' => $date, 'class_id' => $classId]);

// Insert new attendance
$stmt = $pdo->prepare("INSERT INTO attendance (student_id, date, status) VALUES (:student_id, :date, :status)");
foreach ($attendanceData as $studentId => $status) {
    $stmt->execute(['student_id' => $studentId, 'date' => $date, 'status' => $status]);
}

header("Location: /school-management-system/modules/attendance/list.php?class_id=$classId&date=$date&success=saved");
exit();
?>
