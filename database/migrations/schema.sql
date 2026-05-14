CREATE DATABASE IF NOT EXISTS plantify CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE plantify;

-- Xóa bảng cũ trước (đúng thứ tự để tránh lỗi khóa ngoại)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS news;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS contacts;
DROP TABLE IF EXISTS settings;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS faqs;
DROP TABLE IF EXISTS pages;
DROP TABLE IF EXISTS site_content;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    fullname VARCHAR(100) NOT NULL,
    avatar VARCHAR(255) DEFAULT NULL,
    role ENUM('admin', 'member') DEFAULT 'member',
    status ENUM('active', 'locked') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CREATE TABLE IF NOT EXISTS products (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     title VARCHAR(255) NOT NULL,
--     description TEXT,
--     price DECIMAL(15, 2) NOT NULL,
--     image VARCHAR(255) DEFAULT NULL,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );

CREATE TABLE IF NOT EXISTS products (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  category VARCHAR(120) NOT NULL,
  price DECIMAL(12,2) NOT NULL DEFAULT 0,
  image VARCHAR(255) DEFAULT NULL,
  description TEXT NOT NULL,
  is_featured TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    short_description TEXT,
    content TEXT NOT NULL,
    thumbnail VARCHAR(255) DEFAULT NULL,
    tags VARCHAR(255) DEFAULT NULL,
    seo_desc VARCHAR(255) DEFAULT NULL,
    author VARCHAR(100) DEFAULT 'Admin',
    status ENUM('published', 'draft', 'hidden') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    target_id INT NOT NULL,
    target_type ENUM('product', 'news') NOT NULL,
    content TEXT NOT NULL,
    status ENUM('pending', 'approved', 'hidden') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Phuc

CREATE TABLE IF NOT EXISTS services (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  icon VARCHAR(80) NOT NULL,
  description TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS faqs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  question VARCHAR(255) NOT NULL,
  answer TEXT NOT NULL,
  sort_order INT UNSIGNED NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS pages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(100) NOT NULL UNIQUE,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  image VARCHAR(255) DEFAULT NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS site_content (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  content_key VARCHAR(120) NOT NULL UNIQUE,
  content_group VARCHAR(80) NOT NULL DEFAULT 'general',
  label VARCHAR(180) NOT NULL,
  input_type ENUM('text','textarea','url') NOT NULL DEFAULT 'text',
  content_value TEXT NOT NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO services (title, icon, description) VALUES
('Thiết kế decor cây xanh', 'fa-seedling', 'Khảo sát mặt bằng, tư vấn concept và bố trí cây cảnh cho văn phòng, nhà mẫu, showroom.'),
('Cung cấp cây nội thất', 'fa-leaf', 'Tuyển chọn cây khỏe, dáng đẹp, chậu phù hợp với phong cách hiện đại.'),
('Chăm sóc định kỳ', 'fa-hand-holding-droplet', 'Bảo dưỡng cây, cắt tỉa, bổ sung dinh dưỡng và xử lý sâu bệnh theo lịch.');

INSERT INTO products (name, category, price, image, description, is_featured) VALUES
('Bàng Singapore', 'Cây nội thất cao cấp', 1250000, 'assets/images/Screenshot 2025-12-26 172140.png', 'Tán lá lớn, dáng cây sang, phù hợp sảnh lễ tân, phòng họp và góc sofa.', 1),
('Monstera Deliciosa', 'Cây decor hiện đại', 780000, 'assets/images/Screenshot 2025-12-26 172140.png', 'Lá xẻ độc đáo, tạo điểm nhấn xanh cho studio, căn hộ và không gian sáng tạo.', 1),
('Kim Tiền chậu gốm', 'Cây phong thủy', 520000, 'assets/images/Screenshot 2025-12-26 172140.png', 'Dễ chăm sóc, phù hợp bàn làm việc, quầy tiếp tân và quà tặng doanh nghiệp.', 1);

INSERT INTO faqs (question, answer, sort_order) VALUES
('Plantify có khảo sát trực tiếp trước khi thiết kế không?', 'Có. Đội ngũ tư vấn sẽ khảo sát ánh sáng, diện tích, luồng gió và phong cách nội thất để đề xuất loại cây, chậu và vị trí phù hợp.', 1),
('Cây có được bảo hành sau khi bàn giao không?', 'Tất cả cây trong gói decor doanh nghiệp được theo dõi sức khỏe trong 30 ngày đầu. Gói chăm sóc định kỳ có chính sách thay thế theo hợp đồng.', 2),
('Tôi có thể gửi ảnh mặt bằng để được tư vấn online không?', 'Có. Bạn có thể chuẩn bị ảnh tổng thể, kích thước khu vực và điều kiện ánh sáng để đội ngũ tư vấn phân tích phương án phù hợp.', 3);

INSERT INTO pages (slug, title, content, image) VALUES
('about', 'Giới thiệu Plantify Co', 'Plantify Co là công ty chuyên thiết kế và cung cấp giải pháp cây xanh cho không gian doanh nghiệp. Chúng tôi kết hợp thẩm mỹ, khoa học và dịch vụ để mang thiên nhiên vào văn phòng, showroom và căn hộ cao cấp.', 'assets/uploads/pages/about-20260514-063927-1ffd56a6.jpeg')
ON DUPLICATE KEY UPDATE title = VALUES(title), content = VALUES(content), image = VALUES(image);

INSERT INTO site_content (content_key, content_group, label, input_type, content_value) VALUES
('company.name', 'Công ty', 'Tên thương hiệu', 'text', 'Plantify Co'),
('company.tagline', 'Công ty', 'Khẩu hiệu', 'text', 'Cây xanh tinh tế cho không gian sống và làm việc'),
('company.phone', 'Công ty', 'Số điện thoại', 'text', '0908 246 136'),
('company.email', 'Công ty', 'Email', 'text', 'info@plantifyco.com'),
('company.address', 'Công ty', 'Địa chỉ', 'text', '268, Lý Thường Kiệt, Phường 14, Quận 10, TP. Hồ Chí Minh'),
('company.hours', 'Công ty', 'Giờ làm việc', 'text', 'Thứ 2 - Thứ 7: 08:00 - 18:00'),
('site.default_description', 'SEO', 'Mô tả mặc định', 'textarea', 'Website giới thiệu công ty cây cảnh, cây xanh và decor thiên nhiên cho văn phòng, showroom.'),
('about.hero_video', 'Trang giới thiệu', 'Video nền đầu trang giới thiệu', 'text', 'assets/videos/about/about-hero-20260514_063453.m3u8'),
('nav.about', 'Điều hướng', 'Menu giới thiệu', 'text', 'Giới thiệu'),
('nav.faq', 'Điều hướng', 'Menu FAQ', 'text', 'FAQ'),
('nav.toggle', 'Điều hướng', 'Nhãn mở menu mobile', 'text', 'Mở menu'),
('footer.description', 'Footer', 'Mô tả footer', 'textarea', 'Chúng tôi mang cây xanh vào không gian sống và làm việc bằng giải pháp tinh gọn, bền vững.'),
('footer.info_title', 'Footer', 'Tiêu đề thông tin', 'text', 'Thông tin'),
('footer.nav_title', 'Footer', 'Tiêu đề điều hướng', 'text', 'Điều hướng')
ON DUPLICATE KEY UPDATE
  content_group = VALUES(content_group),
  label = VALUES(label),
  input_type = VALUES(input_type),
  content_value = VALUES(content_value);

INSERT INTO site_content (content_key, content_group, label, input_type, content_value) VALUES
('about.meta_title', 'Trang giới thiệu', 'Meta title', 'text', 'Giới thiệu | Plantify Co'),
('about.meta_description', 'Trang giới thiệu', 'Meta description', 'textarea', 'Tìm hiểu Plantify Co, công ty thiết kế decor cây xanh.'),
('about.hero_video_label', 'Trang giới thiệu', 'Nhãn truy cập video hero', 'text', 'Video nền giới thiệu Plantify Co'),
('about.hero_kicker', 'Trang giới thiệu', 'Nhãn hero', 'text', 'Về Plantify'),
('about.hero_title', 'Trang giới thiệu', 'Tiêu đề hero', 'textarea', 'Thiết kế mảng xanh bền vững cho không gian sống và làm việc hiện đại.'),
('about.hero_description', 'Trang giới thiệu', 'Mô tả hero', 'textarea', 'Plantify kết hợp tư duy thiết kế, hiểu biết cây trồng và quy trình chăm sóc định kỳ để tạo nên những không gian xanh đẹp, khỏe và dễ duy trì.'),
('about.hero_primary_button', 'Trang giới thiệu', 'Nút hero chính', 'text', 'Xem FAQ'),
('about.hero_secondary_button', 'Trang giới thiệu', 'Nút hero phụ', 'text', 'Xem câu hỏi thường gặp'),
('about.hero_card_title', 'Trang giới thiệu', 'Tiêu đề thẻ hero', 'text', 'Không chỉ đặt cây vào phòng'),
('about.hero_card_text', 'Trang giới thiệu', 'Nội dung thẻ hero', 'textarea', 'Chúng tôi tính ánh sáng, luồng di chuyển, độ ẩm, chất liệu chậu và chi phí bảo dưỡng trước khi đề xuất phương án.'),
('about.metric_1_value', 'Trang giới thiệu', 'Chỉ số 1', 'text', '120+'),
('about.metric_1_label', 'Trang giới thiệu', 'Nhãn chỉ số 1', 'text', 'không gian đã tư vấn'),
('about.metric_2_value', 'Trang giới thiệu', 'Chỉ số 2', 'text', '30 ngày'),
('about.metric_2_label', 'Trang giới thiệu', 'Nhãn chỉ số 2', 'text', 'theo dõi sau bàn giao'),
('about.metric_3_value', 'Trang giới thiệu', 'Chỉ số 3', 'text', '24h'),
('about.metric_3_label', 'Trang giới thiệu', 'Nhãn chỉ số 3', 'text', 'phản hồi hồ sơ online'),
('about.metric_4_value', 'Trang giới thiệu', 'Chỉ số 4', 'text', '4 bước'),
('about.metric_4_label', 'Trang giới thiệu', 'Nhãn chỉ số 4', 'text', 'quy trình triển khai rõ ràng'),
('about.image_alt', 'Trang giới thiệu', 'Alt ảnh giới thiệu', 'text', 'Chăm sóc cây xanh trong không gian nội thất'),
('about.image_note_title', 'Trang giới thiệu', 'Tiêu đề ghi chú ảnh', 'text', 'Khảo sát trước khi chọn cây'),
('about.image_note_text', 'Trang giới thiệu', 'Nội dung ghi chú ảnh', 'textarea', 'Ánh sáng, hướng gió và thói quen sử dụng quyết định 70% độ bền của mảng xanh.'),
('about.story_kicker', 'Trang giới thiệu', 'Nhãn câu chuyện', 'text', 'Câu chuyện'),
('about.story_title', 'Trang giới thiệu', 'Tiêu đề câu chuyện', 'textarea', 'Từ những chậu cây nhỏ đến giải pháp xanh cho doanh nghiệp'),
('about.story_paragraph_1', 'Trang giới thiệu', 'Đoạn câu chuyện 1', 'textarea', 'Chúng tôi phục vụ văn phòng, căn hộ dịch vụ, showroom, nhà hàng và không gian bán lẻ cần một hình ảnh xanh chỉn chu. Mỗi dự án bắt đầu bằng khảo sát thực tế, sau đó đội ngũ thiết kế chọn cây theo ánh sáng, độ ẩm, mật độ sử dụng và phong cách nội thất.'),
('about.story_paragraph_2', 'Trang giới thiệu', 'Đoạn câu chuyện 2', 'textarea', 'Plantify không chạy theo bố cục rườm rà. Chúng tôi tập trung vào cây khỏe, chậu đẹp, tỷ lệ hài hòa và quy trình chăm sóc sau bàn giao.'),
('about.check_1', 'Trang giới thiệu', 'Gạch đầu dòng 1', 'text', 'Tư vấn theo ngân sách'),
('about.check_2', 'Trang giới thiệu', 'Gạch đầu dòng 2', 'text', 'Bố trí theo mặt bằng'),
('about.check_3', 'Trang giới thiệu', 'Gạch đầu dòng 3', 'text', 'Chọn cây theo điều kiện sáng'),
('about.check_4', 'Trang giới thiệu', 'Gạch đầu dòng 4', 'text', 'Theo dõi sức khỏe cây'),
('about.capability_kicker', 'Trang giới thiệu', 'Nhãn năng lực', 'text', 'Năng lực cốt lõi'),
('about.capability_title', 'Trang giới thiệu', 'Tiêu đề năng lực', 'textarea', 'Thiết kế đẹp nhưng vẫn dễ vận hành mỗi ngày'),
('about.capability_text', 'Trang giới thiệu', 'Mô tả năng lực', 'textarea', 'Plantify xây dựng phương án theo cả thẩm mỹ lẫn chi phí duy trì, phù hợp cho không gian có nhiều người sử dụng.'),
('about.feature_1_title', 'Trang giới thiệu', 'Tiêu đề năng lực 1', 'text', 'Thiết kế đúng không gian'),
('about.feature_1_text', 'Trang giới thiệu', 'Nội dung năng lực 1', 'textarea', 'Mỗi loại cây được chọn theo ánh sáng, diện tích, luồng di chuyển và chất liệu nội thất.'),
('about.feature_2_title', 'Trang giới thiệu', 'Tiêu đề năng lực 2', 'text', 'Cây khỏe, nguồn rõ'),
('about.feature_2_text', 'Trang giới thiệu', 'Nội dung năng lực 2', 'textarea', 'Cây được kiểm tra rễ, lá, sâu bệnh và khả năng thích nghi trước khi bàn giao.'),
('about.feature_3_title', 'Trang giới thiệu', 'Tiêu đề năng lực 3', 'text', 'Bảo dưỡng đều đặn'),
('about.feature_3_text', 'Trang giới thiệu', 'Nội dung năng lực 3', 'textarea', 'Lịch chăm sóc định kỳ giúp không gian xanh luôn sạch, an toàn và giữ hình ảnh chuyên nghiệp.'),
('about.process_kicker', 'Trang giới thiệu', 'Nhãn quy trình', 'text', 'Quy trình'),
('about.process_title', 'Trang giới thiệu', 'Tiêu đề quy trình', 'textarea', 'Rõ từng bước để khách hàng dễ theo dõi'),
('about.process_text', 'Trang giới thiệu', 'Mô tả quy trình', 'textarea', 'Từ ảnh không gian ban đầu đến chăm sóc định kỳ, mỗi giai đoạn đều có đầu ra cụ thể để bạn duyệt nhanh và kiểm soát ngân sách.'),
('about.process_1_title', 'Trang giới thiệu', 'Tiêu đề bước 1', 'text', 'Tiếp nhận nhu cầu'),
('about.process_1_text', 'Trang giới thiệu', 'Nội dung bước 1', 'textarea', 'Nhận ảnh, mặt bằng, phong cách mong muốn và mức ngân sách dự kiến.'),
('about.process_2_title', 'Trang giới thiệu', 'Tiêu đề bước 2', 'text', 'Khảo sát điều kiện'),
('about.process_2_text', 'Trang giới thiệu', 'Nội dung bước 2', 'textarea', 'Đánh giá ánh sáng, gió, ổ cắm, lối đi, vị trí tưới và rủi ro bẩn sàn.'),
('about.process_3_title', 'Trang giới thiệu', 'Tiêu đề bước 3', 'text', 'Đề xuất phương án'),
('about.process_3_text', 'Trang giới thiệu', 'Nội dung bước 3', 'textarea', 'Gợi ý cây, chậu, bố cục, tần suất chăm sóc và phương án thay thế khi cần.'),
('about.process_4_title', 'Trang giới thiệu', 'Tiêu đề bước 4', 'text', 'Bàn giao và duy trì'),
('about.process_4_text', 'Trang giới thiệu', 'Nội dung bước 4', 'textarea', 'Lắp đặt gọn, hướng dẫn chăm sóc, theo dõi cây sau bàn giao và bảo dưỡng định kỳ.'),
('about.testimonial_kicker', 'Trang giới thiệu', 'Nhãn phản hồi', 'text', 'Khách hàng nói gì'),
('about.testimonial_title', 'Trang giới thiệu', 'Tiêu đề phản hồi', 'textarea', 'Phản hồi từ các dự án đã triển khai'),
('about.testimonial_1_quote', 'Trang giới thiệu', 'Phản hồi 1', 'textarea', 'Plantify thiết kế mảng xanh gọn gàng, đúng tinh thần văn phòng của chúng tôi và chăm sóc cây rất đều.'),
('about.testimonial_1_name', 'Trang giới thiệu', 'Tên khách hàng 1', 'text', 'Ms. Linh Nguyễn'),
('about.testimonial_1_role', 'Trang giới thiệu', 'Vai trò khách hàng 1', 'text', 'Office Manager, Aster Tech'),
('about.testimonial_2_quote', 'Trang giới thiệu', 'Phản hồi 2', 'textarea', 'Đội ngũ tư vấn kỹ về ánh sáng và chất liệu chậu. Không gian studio sau khi decor trông ấm hơn nhưng vẫn rất tinh tế.'),
('about.testimonial_2_name', 'Trang giới thiệu', 'Tên khách hàng 2', 'text', 'Mr. Minh Trần'),
('about.testimonial_2_role', 'Trang giới thiệu', 'Vai trò khách hàng 2', 'text', 'Founder, Annam Studio'),
('about.map_kicker', 'Trang giới thiệu', 'Nhãn vị trí', 'text', 'Vị trí'),
('about.map_title', 'Trang giới thiệu', 'Tiêu đề vị trí', 'textarea', 'Ghé Plantify để chọn cây và chậu trực tiếp'),
('about.map_iframe_title', 'Trang giới thiệu', 'Tiêu đề iframe bản đồ', 'text', 'Bản đồ Plantify Co'),
('about.cta_title', 'Trang giới thiệu', 'Tiêu đề CTA', 'textarea', 'Muốn biết không gian của bạn hợp cây gì?'),
('about.cta_text', 'Trang giới thiệu', 'Mô tả CTA', 'textarea', 'Gửi ảnh hiện trạng, Plantify sẽ gợi ý nhóm cây, kích thước chậu và cách chăm sóc phù hợp.'),
('about.cta_button', 'Trang giới thiệu', 'Nút CTA', 'text', 'Xem FAQ')
ON DUPLICATE KEY UPDATE
  content_group = VALUES(content_group),
  label = VALUES(label),
  input_type = VALUES(input_type),
  content_value = VALUES(content_value);

--

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS settings (
    `key` VARCHAR(50) PRIMARY KEY,
    `value` TEXT
);


-- Tài khoản mặc định (password: 123456)
INSERT IGNORE INTO users (username, password, email, fullname, role) VALUES 
('admin', '$2y$10$85RR.k4boZvRpouPtxFkY.yURRPvHwoZe5F/8JrzQehuqyqllBZwS', 'admin@localhost.com', 'Admin System', 'admin'),
('thanhvien', '$2y$10$85RR.k4boZvRpouPtxFkY.yURRPvHwoZe5F/8JrzQehuqyqllBZwS', 'member@localhost.com', 'Thành Viên Demo', 'member');

-- Dữ liệu mẫu bài viết 
INSERT IGNORE INTO news (title, slug, short_description, content, thumbnail, tags, seo_desc, author, status) VALUES
(
    'Top 5 Cây Cảnh Phong Thủy Mang Lại May Mắn',
    'top-5-cay-canh-phong-thuy-may-man-1',
    'Khám phá 5 loại cây cảnh được các chuyên gia phong thủy khuyên dùng để thu hút tài lộc và may mắn cho gia đình bạn.',
    '<p>Cây cảnh phong thủy không chỉ tô điểm không gian sống mà còn mang ý nghĩa tâm linh sâu sắc theo quan niệm phương Đông.</p><h2>1. Cây Kim Tiền</h2><p>Cây kim tiền (Crassula ovata) tượng trưng cho tiền bạc và thịnh vượng. Đặt cây ở góc đông nam của ngôi nhà để kích hoạt năng lượng tài lộc.</p><h2>2. Cây Trầu Bà</h2><p>Trầu bà có khả năng lọc không khí tuyệt vời, đồng thời mang lại sinh khí và sức sống cho không gian sống.</p><h2>3. Cây Phát Tài</h2><p>Với thân cây xoắn đặc trưng, cây phát tài (Pachira aquatica) được coi là biểu tượng của may mắn và thịnh vượng.</p>',
    NULL,
    'phong thủy,may mắn,cây cảnh,tài lộc',
    'Top 5 cây cảnh phong thủy giúp thu hút may mắn và tài lộc cho gia đình',
    'Admin',
    'published'
),
(
    'Cách Chăm Sóc Cây Cảnh Trong Nhà Đúng Cách',
    'cach-cham-soc-cay-canh-trong-nha-dung-cach-2',
    'Hướng dẫn chi tiết cách tưới nước, bón phân và đặt vị trí phù hợp để cây cảnh trong nhà luôn xanh tốt.',
    '<p>Chăm sóc cây cảnh trong nhà đòi hỏi sự kiên nhẫn và kiến thức cơ bản về nhu cầu của từng loại cây.</p><h2>Tưới nước đúng cách</h2><p>Kiểm tra độ ẩm đất trước khi tưới bằng cách cắm ngón tay vào đất khoảng 2-3cm. Nếu đất còn ẩm, chưa cần tưới.</p><h2>Ánh sáng</h2><p>Hầu hết cây cảnh trong nhà cần ánh sáng gián tiếp. Đặt cây gần cửa sổ nhưng tránh ánh nắng trực tiếp có thể làm cháy lá.</p><h2>Bón phân</h2><p>Bón phân 2 tuần/lần trong mùa sinh trưởng (xuân-hè) bằng phân hòa tan loãng.</p>',
    NULL,
    'chăm sóc cây,tưới nước,bón phân,cây trong nhà',
    'Hướng dẫn chăm sóc cây cảnh trong nhà đúng cách để cây luôn xanh tốt',
    'Admin',
    'published'
),
(
    'Xu Hướng Cây Cảnh 2026: Mini Garden Trong Căn Hộ',
    'xu-huong-cay-canh-2026-mini-garden-trong-can-ho-3',
    'Mini garden đang trở thành xu hướng hot nhất năm 2026, giúp người thành thị kết nối với thiên nhiên ngay tại căn hộ.',
    '<p>Trong nhịp sống đô thị hối hả, mini garden mang đến không gian xanh mát ngay tại nhà cho người yêu thiên nhiên.</p><h2>Mini garden là gì?</h2><p>Mini garden là vườn thu nhỏ được thiết kế trong không gian nhỏ như ban công, góc phòng hoặc windowsill.</p><h2>Các loại cây phù hợp</h2><p>Succulent, xương rồng mini, cỏ nhật, dương xỉ nhỏ và các loại herb như húng quế, bạc hà rất phù hợp cho mini garden.</p>',
    NULL,
    'mini garden,xu hướng 2026,căn hộ,không gian xanh',
    'Xu hướng mini garden 2026 - tạo không gian xanh trong căn hộ nhỏ',
    'Admin',
    'published'
),
(
    'Gợi Ý 10 Loại Cây Lọc Không Khí Tốt Nhất',
    'goi-y-10-loai-cay-loc-khong-khi-tot-nhat-4',
    'NASA đã nghiên cứu và chứng minh 10 loại cây này có khả năng lọc các chất độc hại trong không khí nhà bạn.',
    '<p>Nghiên cứu của NASA đã chỉ ra rằng một số loại cây cảnh có khả năng lọc các chất độc hại như formaldehyde, benzene và carbon monoxide.</p><h2>Top cây lọc không khí</h2><ul><li><strong>Cây lưỡi hổ</strong> - Lọc formaldehyde và trichloroethylene</li><li><strong>Trầu bà</strong> - Hiệu quả với benzene và CO</li><li><strong>Cây hòa bình</strong> - Loại bỏ nhiều chất độc hại</li><li><strong>Dracaena</strong> - Lọc xylene và toluene</li></ul>',
    NULL,
    'lọc không khí,NASA,cây xanh,sức khỏe',
    '10 loại cây lọc không khí tốt nhất được NASA nghiên cứu và khuyên dùng',
    'Admin',
    'published'
),
(
    'Cây Cảnh Văn Phòng: Tăng Năng Suất Làm Việc',
    'cay-canh-van-phong-tang-nang-suat-lam-viec-5',
    'Nghiên cứu khoa học chứng minh đặt cây xanh trong văn phòng giúp tăng năng suất lên 15% và giảm stress hiệu quả.',
    '<p>Môi trường làm việc xanh không chỉ đẹp mắt mà còn tác động tích cực đến hiệu suất và tâm lý nhân viên.</p><h2>Lợi ích của cây văn phòng</h2><p>Theo nghiên cứu của Đại học Exeter, cây xanh trong văn phòng giúp tăng năng suất lên 15%, tăng sự sáng tạo và giảm mức độ stress đáng kể.</p><h2>Cây phù hợp cho văn phòng</h2><p>Lựa chọn các loại cây chịu ánh sáng yếu, ít cần chăm sóc như lưỡi hổ, cactus mini, pothos và ZZ plant.</p>',
    NULL,
    'cây văn phòng,năng suất,stress,làm việc',
    'Cây cảnh văn phòng giúp tăng năng suất và giảm stress cho nhân viên',
    'Admin',
    'published'
);
