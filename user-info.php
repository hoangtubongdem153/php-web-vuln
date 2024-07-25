<?php
require_once 'connect-db.php'; // Kết nối đến cơ sở dữ liệu

// Kiểm tra phiên đăng nhập
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

// Xử lý thay đổi mật khẩu
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    //lấy passwd cũ để đối sánh
    $sql = "SELECT password FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    //hashpaswd để đối sánh
    $hash_old_pass = md5($old_password);
    $hash_new_pass = md5($new_password);
    $hash_comfirm_pass = md5($confirm_password);

    //đối sánh mật khẩu cũ người dùng nhập trong CSDL
    if ($hash_old_pass == $row['password']) {
        if ($hash_old_pass == $hash_new_pass){
            $message = "Mật khẩu mới không được trùng với mật khẩu cũ!";
            exit;
        } else if ($hash_new_pass == $hash_comfirm_pass) {
            $sql = "UPDATE user SET password = '$hash_new_pass' WHERE username = '$username'";
            $conn->query($sql);
            $message = "Mật khẩu đã được thay đổi thành công!";
        } else {
            $message = "Mật khẩu mới và xác nhận mật khẩu không khớp!";
        }
        
    } else {
        $message = "Mật khẩu cũ không đúng!";
    }
}

// sử lý upload ảnh đại diện
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_avatar'])) {
    // $file lưu trữ đối tượng file được tải lên.
    $file = $_FILES['avatar'];
    $target_dir = "uploads/";

    //vị trí file sẽ được lưu sau khi upload thành công.
    $target_file = $target_dir . $_SESSION['username'] . basename($file["name"]);
    // ở trên , ta thêm tên người dùng vào trước tên ảnh , để phân biệt và lưu trữ được các avatar người dùng khác nhau. 
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // chỉ chấp nhận các file có định dạng jpg, png , jpeg.
    if ($check !== false && ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg")) {
        
        // Ktra Nếu file tồn tại, xóa file cũ
        if (file_exists($target_file)) {
            // hàm unlink dùng để xóa file
            unlink($target_file); 
        } 
        // di chuyển một file (ở vị trí tạm thời $file['tmp_name']) 
        // đến vị trí đc lưu trong biến $target_file
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            //cập nhật link avatar của nguời dùng
            $sql = "UPDATE user SET avatar = '$target_file' WHERE username = '$username'";
            $conn->query($sql);
            $message = "Ảnh đại diện đã được tải lên thành công!";
        } else {
            $message = "Có lỗi xảy ra khi tải lên ảnh!";
        }
    } else {
        $message = "Chỉ chấp nhận các định dạng JPG, JPEG, PNG!";
    }
}

// Truy vấn thông tin người dùng
$sql = "SELECT * FROM user WHERE username = '$username'";
$result = $conn->query($sql);
$user_info = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin người dùng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
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
        .profile {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .profile-title {
            font-size: 24px;
            font-weight: bold;
        }
        .profile-info {
            margin-top: 10px;
        }
        .profile-avatar {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Thông tin người dùng</h1>
    </header>
    <nav>
        <a href="index.php">Trang Chủ</a>
        <a href="blog-user.php">Bài Viết</a>
        <a href="quanly-post.php">Quản Lý</a>
        <a href="logout.php">Đăng Xuất</a>
    </nav><br>
    <div class="container">
        <h2 class="mb-4">Thông tin người dùng</h2>
        <div class="profile">
            <div class="profile-title">Thông tin cá nhân</div>
            <div class="profile-info">ID: <?php echo htmlspecialchars($user_info['id']); ?></div>
            <div class="profile-info">Username: <?php echo htmlspecialchars($user_info['username']); ?></div>
            <div class="profile-info">Ngày sinh: <?php echo htmlspecialchars($user_info['birthday']); ?></div>
            <div class="profile-info">Giới tính: <?php echo htmlspecialchars($user_info['gioi_tinh']); ?></div>
            <div class="profile-info">Email: <?php echo htmlspecialchars($user_info['email']); ?></div>
            <div class="profile-info">
                <img src="<?php echo htmlspecialchars($user_info['avatar']); ?>" class="profile-avatar" alt="Avatar: Not set!">
            </div>
        </div>

        <div class="mb-4">
            <h2>Thay đổi mật khẩu</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="old_password">Mật khẩu cũ</label>
                    <input type="password" class="form-control" name="old_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Mật khẩu mới</label>
                    <input type="password" class="form-control" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Xác nhận mật khẩu mới</label>
                    <input type="password" class="form-control" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary" name="change_password">Thay đổi mật khẩu</button>
            </form>
        </div>

        <div class="mb-4">
            <h2>Upload ảnh đại diện</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="avatar">Chọn ảnh</label>
                    <input type="file" class="form-control-file" name="avatar" required>
                </div>
                <button type="submit" class="btn btn-primary" name="upload_avatar">Upload ảnh</button>
            </form>
        </div>

        <?php if (isset($message)) { ?>
            <script>
                alert("<?php echo htmlspecialchars($message); ?>"); 
            </script>
        <?php  
            unset($message);
            }
        ?>
    </div>
</body>
</html>