<?php

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Đăng Nhập</title>
    <style>
        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        .container h3 {
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            width: 100%;
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .alert {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Đăng Nhập</h3>
        <form method="POST" action="">
            <div class="form-group">
                <label for="inUser">Tên đăng nhập</label>
                <input name="inUser" type="text" class="form-control" id="inUser" placeholder="Nhập tên đăng nhập">
            </div>
            <div class="form-group">
                <label for="inPasswd">Mật khẩu</label>
                <input name="inPasswd" type="password" class="form-control" id="inPasswd" placeholder="Nhập mật khẩu">
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="login">Đăng Nhập</button><br>
        </form><br>
        <div id="alert_div" ></div>
    </div>
    <?php 
        // tạo kết nối db từ file connect-db.php
        require_once 'connect-db.php';
        // khởi tạo quản lý phiên
        session_start();
        if (isset($_POST['login'])) {
            $username = trim($_POST['inUser']);
            $passwd = trim($_POST['inPasswd']);
        
            if (empty($username) || empty($passwd)) {
                $content = '<p >Vui lòng điền đầy đủ thông tin đăng nhập!</p>';
                echo '<script>document.getElementById("alert_div").innerHTML = "' . $content . '";</script>';
                exit;
            }
        
        $passwd = md5($passwd); 

        $query = " SELECT * FROM user WHERE username='$username' AND password='$passwd' "; 

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) >0) {
            $_SESSION["username"]= $username ;
            header('location:index.php');
            $conn->close();
        } else {
        //echo "Tên đăng nhập hoặc mật khẩu không đúng!";
        $content = '<p> Tên đăng nhập hoặc mật khẩu không chính xác! </p>';
        echo '<script>document.getElementById("alert_div").innerHTML = "' . $content . '";</script>';
        }
    }
    ?>


</body>
</html>