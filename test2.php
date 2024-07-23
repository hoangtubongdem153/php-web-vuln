<?php
require_once 'connect-db.php'; // Kết nối đến cơ sở dữ liệu

// Kiểm tra phiên đăng nhập
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: welcome.php');
    exit;
}

// Truy vấn nội dung từ bảng 'post' và liên kết với bảng 'user' để lấy tên người đăng
$sql = "SELECT title, content, date, username 
        FROM post 
        JOIN user ON post.id = user.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách bài viết</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        .post {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .post-title {
            font-size: 24px;
            font-weight: bold;
        }
        .post-content {
            margin-top: 10px;
        }
        .post-info {
            margin-top: 10px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Danh sách bài viết</h1>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="post">';
                echo '<div class="post-title">' . htmlspecialchars($row['title']) . '</div>';
                echo '<div class="post-content">' . nl2br(htmlspecialchars($row['content'])) . '</div>';
                echo '<div class="post-info">Đăng bởi: ' . htmlspecialchars($row['username']) . ' vào ' . htmlspecialchars($row['date']) . '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="alert alert-info">Chưa có bài viết nào.</div>';
        }
        ?>
    </div>
</body>
</html>