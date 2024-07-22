<?php
// Thay thế bằng thông tin kết nối:
$servername = "localhost";
$database = "web-vuln-db";
$username = "root";
$password = "";
// Tạo kết nối
$conn = mysqli_connect($servername, $username, $password, $database);
// Kiểm tra kết nối
if (!$conn) {
die("Kết nối thất bại: " . mysqli_connect_error());
}

?>