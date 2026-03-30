<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: /school-management-system/pages/dashboard.php");
} else {
    header("Location: /school-management-system/pages/login.php");
}
exit();
?>
