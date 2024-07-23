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

//tạo bảng post chứa bài đăng người dùng
CREATE TABLE post (
    idpost INT PRIMARY KEY AUTO_INCREMENT,
    id INT(10) NOT NULL, 
    title VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, 
    content TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, 
    date DATETIME NOT NULL, 
    FOREIGN KEY (id) REFERENCES user(id) 
); 
//dữ liệu mẫu cho post
INSERT INTO post (id, title, content, date) VALUES
  (1, 'My Journey Learning a New Language', 'Share your experiences of learning a new language, including the challenges, rewards, and tips for others.', '2024-07-24 10:00:00'),
  (2, 'Latest Tech Breakthroughs and Their Impact on Society', 'Discuss recent technological advancements and their potential implications for various aspects of society.', '2024-07-23 15:30:00'),
  (3, 'Optimizing Website Performance for Better User Experience', 'Provide a guide on optimizing website performance, including techniques for improving loading speed, reducing page size, and enhancing user experience.', '2024-07-22 12:15:00'),
  (4, 'Chào mọi người!', 'Lại là Linh đây hihi.', '2024-07-22 12:15:00');

INSERT INTO post (id, title, content, date) VALUES
  (1, 'Bão', 'Hôm nay do ảnh hưởng của bão đổ bộ, trời mưa rất to.', '2024-07-23 17:55:00'),
  (2, 'Tôi thích nuôi mèo', 'Con mèo nhà tôi rất dễ thương và ngoan.', '2024-07-22 13:39:00'),
  (3, 'Bầu cử Tổng thống Mỹ', 'Tổng thống Mỹ Joe Biden vừa tuyên bố rút lui khỏi cuộc đua vào nhà trắng nhiệm kỳ II.', '2024-07-23 19:15:33'),
  (4, 'Thật không thể tin nổi!', 'Linh vừa đạt điểm 10 môn toán.', '2024-07-22 22:19:55');

// tạo bảng chứa comment của user trên một bài post cụ thể.
CREATE TABLE comment (
  idcommt INT PRIMARY KEY AUTO_INCREMENT,
  idpost INT NOT NULL,
  commt_content TEXT  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  user_commt VARCHAR(255)  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  date DATETIME NOT NULL,
  FOREIGN KEY (idpost) REFERENCES post(idpost)
);

//