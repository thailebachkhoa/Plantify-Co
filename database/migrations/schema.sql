CREATE DATABASE IF NOT EXISTS btlweb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE btlweb;

-- Xóa bảng cũ trước (đúng thứ tự để tránh lỗi khóa ngoại)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS news;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS contacts;
DROP TABLE IF EXISTS settings;
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

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(15, 2) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Part #4: thêm slug, short_description, thumbnail, author, status, updated_at
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

-- Part #4: thêm status, updated_at
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

-- Dữ liệu mẫu bài viết (Part #4)
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
