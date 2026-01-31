CREATE DATABASE buoi2_php
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE buoi2_php;

-- ===============================
-- Bảng products
-- ===============================
DROP TABLE IF EXISTS products;
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price FLOAT NOT NULL,
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO products (name, price, description, image) VALUES
('iPhone 15 Pro Max', 29990000, 'Smartphone cao cấp từ Apple', 'iphone15.jpg'),
('Samsung Galaxy S24', 22990000, 'Flagship Android mới nhất', 'galaxys24.jpg'),
('MacBook Air M3', 28990000, 'Laptop siêu mỏng nhẹ', 'macbookair.jpg'),
('Sony WH-1000XM5', 8990000, 'Tai nghe chống ồn cao cấp', 'sony-headphone.jpg'),
('iPad Pro 12.9', 25990000, 'Máy tính bảng chuyên nghiệp', '697dd28ad01d7_1769853578.jpg'),
('AirPods Pro 2', 1000000, 'Tai nghe không dây Apple', 'https://shopdunk.com/images/thumbs/000211_airpods-pro-2.png');

-- ===============================
-- Bảng students
-- ===============================
DROP TABLE IF EXISTS students;
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    student_code VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students (fullname, student_code, email) VALUES
('Nguyễn Văn A', 'SV001', 'sva@gmail.com'),
('Trần Thị B', 'SV002', 'svb@gmail.com'),
('Lê Văn C', 'SV003', 'svc@gmail.com');