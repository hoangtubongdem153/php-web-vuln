<?php
require_once 'connect-db.php';
session_start();
// Kiểm tra người dùng đã đăng nhập hay chưa, nếu chưa thì chuyển hướng về trang đăng nhập
if (!isset($_SESSION['username'])) {
    header('Location: welcome.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        nav {
            background-color: #444;
            overflow: hidden;
        }
        nav a {
            float: left;
            display: block;
            color: #fff;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        nav a:hover {
            background-color: #ddd;
            color: black;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Web Vuln</h1>
    </header>
    <nav>
        <a href="user-info.php">Thông Tin</a>
        <a href="post.php">Bài Viết</a>
        <a href="quanly.php">Quản Lý</a>
        <a href="logout.php">Đăng Xuất</a>
    </nav>
    <div class="content">
        <h2>Chào mừng bạn đến với trang chủ</h2>
        <p>Đây là trang chủ của website với các mục Thông Tin, Bài Viết, Quản Lý và Đăng Xuất.</p>
    </div>
</body>
</html>