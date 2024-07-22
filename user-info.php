<?php
require_once 'connect-db.php';
session_start();
// Kiểm tra người dùng đã đăng nhập hay chưa, nếu chưa thì chuyển hướng về trang đăng nhập
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$username = $_SESSION['username'];
$sql = "SELECT id, email, birthday, gioi_tinh FROM user WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Không tìm thấy thông tin người dùng!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông Tin Cá Nhân</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Helvetica', 'Arial';
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
        .user-info {
            margin: 20px 0;
        }
        .user-info h4 {
            margin: 10px 0;
        }
        .btn-back {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Thông Tin Cá Nhân</h2>
        </div>
        <div class="user-info">
            <h4>ID: <?php echo $user['id']; ?></h4>
            <h4>Username: <?php echo $username; ?></h4>
            <h4>Email: <?php echo $user['email']; ?></h4>
            <h4>Ngày Sinh: <?php echo $user['birthday']; ?></h4>
            <h4>Giới Tính: <?php echo $user['gioi_tinh']; ?></h4>
        </div>
        <div class="btn-back">
            <a class="btn btn-primary" href="index.php">Quay lại Trang Chủ</a>
            <a class="btn btn-primary" href="change-passwd.php">Thay đổi mật khẩu</a>
            <a class="btn btn-primary" href="reset-passwd.php">Đặt lại mật khẩu</a>
        </div>
    </div>
</body>
</html>