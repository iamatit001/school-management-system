<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$action = $_POST['action'] ?? $_GET['action'] ?? '';

function calculateGrade($marks) {
    if ($marks >= 90) return 'A+';
    if ($marks >= 80) return 'A';
    if ($marks >= 70) return 'B+';
    if ($marks >= 60) return 'B';
    if ($marks >= 50) return 'C';
    if ($marks >= 40) return 'D';
    return 'F';
}

switch ($action) {
    case 'add':
        $stmt = $pdo->prepare("INSERT INTO exams (exam_name, date) VALUES (:exam_name, :date)");
        $stmt->execute(['exam_name' => trim($_POST['exam_name']), 'date' => $_POST['date']]);
        header("Location: /school-management-system/modules/exams/list.php?success=Exam+created"); exit();

    case 'save_marks':
        $examId = $_POST['exam_id'];
        $subjectId = $_POST['subject_id'];
        $classId = $_POST['class_id'];
        $marksData = $_POST['marks'] ?? [];

        // Delete existing results for this exam + subject
        $delStmt = $pdo->prepare("DELETE FROM results WHERE exam_id = :exam_id AND subject_id = :subject_id AND student_id IN (SELECT id FROM students WHERE class_id = :class_id)");
        $delStmt->execute(['exam_id' => $examId, 'subject_id' => $subjectId, 'class_id' => $classId]);

        // Insert new results with auto-calculated grades
        $stmt = $pdo->prepare("INSERT INTO results (student_id, exam_id, subject_id, marks, grade) VALUES (:student_id, :exam_id, :subject_id, :marks, :grade)");
        foreach ($marksData as $studentId => $marks) {
            if ($marks !== '' && $marks !== null) {
                $marks = intval($marks);
                $grade = calculateGrade($marks);
                $stmt->execute([
                    'student_id' => $studentId,
                    'exam_id' => $examId,
                    'subject_id' => $subjectId,
                    'marks' => $marks,
                    'grade' => $grade
                ]);
            }
        }
        header("Location: /school-management-system/modules/exams/enter_marks.php?exam_id=$examId&class_id=$classId&subject_id=$subjectId&success=saved"); exit();

    case 'delete':
        $id = $_GET['id'];
        $pdo->prepare("DELETE FROM results WHERE exam_id = :id")->execute(['id' => $id]);
        $pdo->prepare("DELETE FROM exams WHERE id = :id")->execute(['id' => $id]);
        header("Location: /school-management-system/modules/exams/list.php?success=Exam+deleted"); exit();

    default:
        header("Location: /school-management-system/modules/exams/list.php"); exit();
}
?>
