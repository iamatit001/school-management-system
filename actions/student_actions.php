<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        $name = trim($_POST['name']);
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $address = trim($_POST['address'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $class_id = !empty($_POST['class_id']) ? $_POST['class_id'] : null;

        $stmt = $pdo->prepare("INSERT INTO students (name, dob, gender, address, phone, class_id) VALUES (:name, :dob, :gender, :address, :phone, :class_id)");
        $stmt->execute([
            'name' => $name,
            'dob' => $dob,
            'gender' => $gender,
            'address' => $address,
            'phone' => $phone,
            'class_id' => $class_id
        ]);
        header("Location: /school-management-system/modules/students/list.php?success=added");
        exit();

    case 'update':
        $id = $_POST['id'];
        $name = trim($_POST['name']);
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $address = trim($_POST['address'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $class_id = !empty($_POST['class_id']) ? $_POST['class_id'] : null;

        $stmt = $pdo->prepare("UPDATE students SET name=:name, dob=:dob, gender=:gender, address=:address, phone=:phone, class_id=:class_id WHERE id=:id");
        $stmt->execute([
            'name' => $name,
            'dob' => $dob,
            'gender' => $gender,
            'address' => $address,
            'phone' => $phone,
            'class_id' => $class_id,
            'id' => $id
        ]);
        header("Location: /school-management-system/modules/students/list.php?success=updated");
        exit();

    case 'delete':
        $id = $_GET['id'];
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
        $stmt->execute(['id' => $id]);
        header("Location: /school-management-system/modules/students/list.php?success=deleted");
        exit();

    default:
        header("Location: /school-management-system/modules/students/list.php");
        exit();
}
?>
