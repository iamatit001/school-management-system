<?php
session_start();
$_SESSION = array();
session_destroy();
header("Location: /school-management-system/pages/login.php");
exit();
?>
