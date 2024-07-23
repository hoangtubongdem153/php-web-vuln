<?php
require_once 'connect-db.php'; // Kết nối đến cơ sở dữ liệu

// Kiểm tra phiên đăng nhập
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: dangnhap.php');
    exit;
}

$username = $_SESSION['username'];

// Kiểm tra quyền admin
$is_admin = false;
$sql = "SELECT role FROM user WHERE username = '$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['role'] == 'admin') {
        $is_admin = true;
    }
}

// Xử lý tạo bài đăng mới
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_post'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $date = date('Y-m-d H:i:s');
    // chèn dữ liệu vào bảng post
    $user_id = $conn->query("SELECT id FROM user WHERE username = '$username'")->fetch_assoc()['id'];
    $sql = "INSERT INTO post (id, title, content, date) VALUES ('$user_id', '$title', '$content', '$date')";
    $conn->query($sql);
    header('Location: blog-user.php');
    exit;
}

// Xử lý xóa bài đăng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_post'])) {
    $post_id = intval($_POST['post_id']);

    // Xóa các bình luận liên quan đến bài đăng
    $sql = "DELETE FROM comment WHERE idpost = '$post_id'";
    $conn->query($sql);
    // xóa bài đăng
    $sql = "DELETE FROM post WHERE idpost = '$post_id'";
    $conn->query($sql);

    header('Location: quanly-post.php');
    exit;
}

// Xử lý xóa bình luận
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_comment'])) {
    $comment_id = intval($_POST['comment_id']);
    $sql = "DELETE FROM comment WHERE id = '$comment_id'";
    $conn->query($sql);
    header('Location: quanly-post.php');
    exit;
}

// Xử lý chỉnh sửa bài đăng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_post'])) {
    $post_id = intval($_POST['post_id']);
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $sql = "UPDATE post SET title = '$title', content = '$content' WHERE idpost = '$post_id'";
    $conn->query($sql);
    header('Location: quanly-post.php');
    exit;
}

// Truy vấn bài đăng của người dùng hiện tại (hoặc tất cả bài đăng nếu là admin)
$sql = $is_admin ? "SELECT post.*, user.username FROM post JOIN user ON post.id = user.id" : "SELECT post.*, user.username FROM post JOIN user ON post.id = user.id WHERE user.username = '$username'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bài đăng</title>
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
    <div class="container">
        <h1 class="mb-4">Quản lý bài đăng</h1>
        <div class="mb-4">
            <h2>Tạo bài đăng mới</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="title">Tiêu đề</label>
                    <input type="text" class="form-control" name="title" required>
                </div>
                <div class="form-group">
                    <label for="content">Nội dung</label>
                    <textarea class="form-control" name="content" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="create_post">Tạo bài đăng</button>
            </form>
        </div>
        <?php
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
                        if ($is_admin || $username == $comment['user_commt']) {
                            echo '<form method="POST" action="">';
                            echo '<input type="hidden" name="comment_id" value="' . $comment['id'] . '">';
                            echo '<button type="submit" class="btn btn-danger btn-sm" name="delete_comment">Xóa bình luận</button>';
                            echo '</form>';
                        }
                        echo '</div>';
                    }
                } else {
                    echo '<div class="comment">Chưa có bình luận nào.</div>';
                }

                // Form chỉnh sửa bài đăng
                echo '<form method="POST" action="">';
                echo '<div class="form-group">';
                echo '<label for="title">Chỉnh sửa tiêu đề</label>';
                echo '<input type="text" class="form-control" name="title" value="' . htmlspecialchars($row['title']) . '" required>';
                echo '</div>';
                echo '<div class="form-group">';
                echo '<label for="content">Chỉnh sửa nội dung</label>';
                echo '<textarea class="form-control" name="content" rows="3" required>' . htmlspecialchars($row['content']) . '</textarea>';
                echo '</div>';
                echo '<input type="hidden" name="post_id" value="' . $post_id . '">';
                echo '<button type="submit" class="btn btn-primary" name="edit_post">Chỉnh sửa bài đăng</button>';
                echo '</form>';

                // Nút xóa bài đăng
                echo '<form method="POST" action="" class="mt-2">';
                echo '<input type="hidden" name="post_id" value="' . $post_id . '">';
                echo '<button type="submit" class="btn btn-danger" name="delete_post">Xóa bài đăng</button>';
                echo '</form>';
                
                echo '</div>';
            }
        } else {
            echo '<div class="alert alert-info">Chưa có bài viết nào.</div>';
        }
        ?>
    </div>
</body>
</html>