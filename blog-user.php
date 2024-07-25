<?php
require_once 'connect-db.php'; // Kết nối đến cơ sở dữ liệu

// Kiểm tra phiên đăng nhập
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: welcome.php');
    exit;
}
// // lấy id của người dùng hiện tại
$username = $_SESSION['username'];


// Xử lý bình luận mới
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment_content']) && isset($_POST['post_id'])) {
    $comment_content = $conn->real_escape_string($_POST['comment_content']);
    $post_id = intval($_POST['post_id']);
    $date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO comment (idpost, commt_content, user_commt, date) VALUES ('$post_id', '$comment_content', '$username', '$date')";
    $conn->query($sql);
    header('Location: blog-user.php');
}

// Truy vấn nội dung từ bảng 'post' và liên kết với bảng 'user' để lấy tên người đăng
$sql = "SELECT idpost, title, content, date, username 
        FROM post 
        JOIN user ON post.id = user.id ORDER BY date DESC" ;
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title>Blog</title>
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
            margin-left: 50px;
            margin-right: 50px;
        }

        .post {
            /* mấy cái này chỉnh đi chỉnh lại đau đầu vl  */
            margin-top: 10px;
            margin-bottom: 10px;
            padding: 20px;
            border: 1px solid red;
            border-radius: 5px;
            margin-left: 10px;
            margin-right: 10px;
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
        .comment {
            margin-top: 20px;
            padding: 10px;
            border-top: 1px solid #ddd;
        }
        .comment-title {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <h1>Blog người dùng</h1>
    </header>
    <nav>
        <a href="index.php">Trang chủ</a>
        <a href="user-info.php">Thông Tin</a>
        <a href="quanly-post.php">Quản Lý</a>
        <a href="logout.php">Đăng Xuất</a>
    </nav>
    <div class="content">
        <?php
            $coloredname = '<span style="color: red;">' . $username . '</span>';
            echo "<h2>Chào mừng $coloredname đến với trang Blog</h2>";
            $date = date('Y-m-d H:i:s');
            echo '<span style="color: red;">TODAY </span> ' . $date;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="post">';
                    echo '<div class="post-title">' . htmlspecialchars($row['title']) . '</div>';
                    echo '<div class="post-content">' . nl2br(htmlspecialchars($row['content'])) . '</div>';
                    echo '<div class="post-info">Đăng bởi: ' . htmlspecialchars($row['username']) . ' vào ' . htmlspecialchars($row['date']) . '</div>';
    
                    // Hiển thị bình luận
                    $post_id = $row['idpost'];
                    $sql_comments = "SELECT * FROM comment WHERE idpost = '$post_id' ORDER BY date DESC";
                    $result_comments = $conn->query($sql_comments);
                    
                    if ($result_comments->num_rows > 0) {
                        while($comment = $result_comments->fetch_assoc()) {
                            echo '<div class="comment">';
                            echo '<div class="comment-title">' . htmlspecialchars($comment['user_commt']) . ' đã bình luận vào ' . htmlspecialchars($comment['date']) . '</div>';
                            echo '<div class="comment-content">' . nl2br(htmlspecialchars($comment['commt_content'])) . '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="comment">Chưa có bình luận nào.</div>';
                    }
    
                    // Form thêm bình luận mới
                    echo '<form method="POST" action="">';
                    echo '<div class="form-group">';
                    echo '<label for="comment_content">Thêm bình luận: </label>';
                    echo '<textarea class="form-control" name="comment_content" rows="1" required></textarea>';
                    echo '</div>';
                    echo '<input type="hidden" name="post_id" value="' . $post_id . '">';
                    echo '<button type="submit" class="btn btn-primary">Gửi</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo '<div class="alert alert-info">Chưa có bài viết nào.</div>';
            }
        ?>
        
</body>
</html>