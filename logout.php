<?php
require_once 'connect-db.php';
session_start();

$user = $_SESSION['username'];
$logout = $conn->query("UPDATE user set trang_thai='0' WHERE username ='$user'");
unset($_SESSION['username']);
header('location:welcome.php');
?>