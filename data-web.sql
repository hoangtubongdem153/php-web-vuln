// tạo bảng nguời dùng user
CREATE TABLE `user` (
`id` INT(10) PRIMARY KEY AUTO_INCREMENT,
`username` VARCHAR(20) NOT NULL UNIQUE,
`password` VARCHAR(255) NOT NULL,
`email` VARCHAR(30) NOT NULL UNIQUE,
`birthday` varchar(10) NOT NULL,
`gioi_tinh` ENUM('nam', 'nu') NOT NULL,
`trang_thai` TINYINT(1) NOT NULL DEFAULT 0
);
//giá trị mẫu
INSERT INTO `user` (`id`, `username`, `password`, `email`, `birthday`, `gioi_tinh`, `trang_thai`) VALUES
('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@viettel.com', '01/05/2003', 'nam', '0'),
('2', 'tung', 'bb7d4b236b564cf1ec27aa891331e0af', 'tung@viettel.com', '01/05/2003', 'nam', '0'),
('3', 'tuan', 'd6b8cc42803ea100735c719f1d7f5e11', 'tuan@viettel.com', '03/07/2005', 'nam', '0'),
('4', 'linh', '35a951128b06237d525b2359d6f6bb80', 'linh@viettel.com', '04/11/2009', 'nu', '0'),
('5', 'toi', '3c4e17f4e02fce26f5a145b4f866b7c1', 'toi@viettel.com', '27/12/2010', 'nam', '0');