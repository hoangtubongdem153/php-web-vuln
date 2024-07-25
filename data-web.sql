// tạo bảng nguời dùng user
CREATE TABLE user (
id INT(10) PRIMARY KEY AUTO_INCREMENT,
username VARCHAR(20) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
email VARCHAR(30) NOT NULL UNIQUE,
birthday varchar(10) NOT NULL,
gioi_tinh ENUM('nam', 'nu') NOT NULL,
trang_thai TINYINT(1) NOT NULL DEFAULT 0
);
// add thêm để chứa đường dẫn file ảnh upload 
ALTER TABLE user ADD COLUMN avatar VARCHAR(255);

//giá trị mẫu cho bảng 'user'
INSERT INTO user (id, username, password, email, birthday, gioi_tinh, trang_thai) VALUES
('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@viettel.com', '01/05/2003', 'nam', '0'),
('2', 'tung', 'bb7d4b236b564cf1ec27aa891331e0af', 'tung@viettel.com', '01/05/2003', 'nam', '0'),
('3', 'tuan', 'd6b8cc42803ea100735c719f1d7f5e11', 'tuan@viettel.com', '03/07/2005', 'nam', '0'),
('4', 'linh', '892da3d819056410c05bca7747d22735', 'linh@viettel.com', '04/11/2009', 'nu', '0'),
('5', 'toi', '3c4e17f4e02fce26f5a145b4f866b7c1', 'toi@viettel.com', '27/12/2010', 'nam', '0');

//bảng chứa bài đăng
CREATE TABLE post (
  idpost INT PRIMARY KEY AUTO_INCREMENT,
  id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  date DATETIME NOT NULL,
  FOREIGN KEY (id) REFERENCES user(id)
);

//dữ liệu mẫu cho bảng 'post'
INSERT INTO post (id, title, content, date)
VALUES
  (1, 'Con Mèoo kêu Meow', 'Con mèo: meow meow meow.', '2024-07-23 10:20:30'),
  (2, 'Bão', 'Cơn bão đã và đang đổ bộ vào các tỉnh Quảng Ninh , Hải Phòng với sức gió giật cấp 10, 11.', '2024-07-22 15:12:00'),
  (3, 'Mưa Hà Nội', 'Nay đi làm mà trời mưa quá.', '2024-07-23 08:35:17');

INSERT INTO post (id, title, content, date) VALUES
(1, 'My Journey Learning a New Language', 'Share your experiences of learning a new language, including the challenges, rewards, and tips for others.', '2024-07-24 10:00:00'),
(2, 'Latest Tech Breakthroughs and Their Impact on Society ', 'Discuss recent technological advancements and their potential implications for various aspects of society. ', '2024-07-23 15:30:00'),
(3, 'Optimizing Website Performance for Better User Experience', 'Provide a guide on optimizing website performance, including techniques for improving loading speed, reducing page size, and enhancing user experience.', '2024-07-22 12:15:00'),
(4, 'Chào mọi người!', 'Lại là Linh đây hihi.', '2024-07-22 12:15:00'),
(1, 'Bão', 'Hôm nay do ảnh hưởng của bão đổ bộ, trời mưa rất to.', '2024-07-23 17:55:00'),
(2, 'Tôi thích nuôi mèo', 'Con mèo nhà tôi rất dễ thương và ngoan.', '2024-07-22 13:39:00'),
(3, 'Bầu cử Tổng thống Mỹ', 'Tổng thống Mỹ Joe Biden vừa tuyên bố rút lui khỏi cuộc đua vào nhà trắng nhiệm kỳ II.', '2024-07-23 19:15:33'),
(4, 'Thật không thể tin nổi!', 'Linh vừa đạt điểm 10 môn toán.', '2024-07-22 22:19:55'),
(2, 'Ngày đi làm trời không MƯA', 'Hôm nay 24/7/2024 , lúc đi làm trời không mưa =))', '2024-07-24 05:16:47'),
(2, 'Tổng thống Mỹ rút lui tranh cử nhiệm kỳ tiếp theo', 'Tổng thống Mỹ Joe Biden vừa tuyên bố rút lui khỏi cuộc đua vào Nhà Trắng . Tuyên bố vừa được đưa ra mới đây. Ông cũng công khai ủng hộ phó tổng thống Kamala Harris trong cuộc đua sắp tới.', '2024-07-24 11:07:38'),
(2, 'Test nội dung', 'hahaha , không có gì ở đây cả =))', '2024-07-24 14:50:45'),
(2, 'Nho nhem nhi nhơi nhới <3', 'Hôm nay , em muốn đi chơi!! .', '2024-07-24 15:36:57');



// tạo bảng chứa comment của user trên một bài post cụ thể.
CREATE TABLE comment (
  idcommt INT PRIMARY KEY AUTO_INCREMENT,
  idpost INT NOT NULL,
  commt_content TEXT  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  user_commt VARCHAR(255)  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  date DATETIME NOT NULL,
  FOREIGN KEY (idpost) REFERENCES post(idpost)
);

//dữ liệu mẫu cho bảng 'comment'
// Tự comment sẽ có :>>
INSERT INTO comment (idpost, commt_content, user_commt, date) VALUES
(1, 'hay quá men ơi!', 'tung', '2024-07-24 04:36:05'),
(10, 'Hay quá , ủng hộ tổng thống Trump nhé <3', 'tung', '2024-07-24 11:08:12'),
(9, 'nhưng lúc về trời lại mưa =((', 'tung', '2024-07-24 14:35:24'),
(12, 'Đi chơi k, tớ đèo đi chơi <33', 'toi', '2024-07-25 18:14:21'),
(11, 'Cuối cùng vẫn có nội dung mà :v', 'toi', '2024-07-25 18:14:54'),
(10, 'Ủng hộ Phó tổng thống Kamala Harris nhé =((', 'toi', '2024-07-25 18:15:39'),
(9, 'Về xong trời tạnh mưa haha', 'toi', '2024-07-25 18:16:25'),
(6, 'Nhưng mèo chê tôi nghèo =((', 'toi', '2024-07-25 18:16:41'),
(5, 'Thái Bình một đêm không ngủ =((', 'toi', '2024-07-25 18:16:58'),
(11, 'có cả bình luận luôn =))', 'linh', '2024-07-25 18:17:44'),
(10, 'ủng hộ Linh nhé, để Linh làm cho =))', 'linh', '2024-07-25 18:18:50'),
(7, 'hehe ', 'linh', '2024-07-25 18:19:11'),
(12, 'nhi nhơi nhi nhơi =))', 'tuan', '2024-07-25 18:19:59'),
(7, 'hoho', 'tuan', '2024-07-25 18:20:26'),
(8, 'Còn a thì được 11 môn toán nhé (1 + 1) =))', 'tuan', '2024-07-25 18:20:59'),
(4, 'Chào Linh nhé . Mình là Tuấn đây hehe', 'tuan', '2024-07-25 18:21:25'),
(3, 'Comment đầu =((', 'tuan', '2024-07-25 18:21:46'),
(3, 'hic hic', 'tuan', '2024-07-25 18:21:57');