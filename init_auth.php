<?php
$conn = new mysqli('localhost', 'root', '', 'ql_thietbi');
if ($conn->connect_error) {
    die('DB connect failed: ' . $conn->connect_error);
}

$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$adminHash = password_hash('admin123', PASSWORD_DEFAULT);
$staffHash = password_hash('staff123', PASSWORD_DEFAULT);

$conn->query("INSERT INTO users (username, password, fullname, role) VALUES ('admin', '$adminHash', 'Quản trị viên', 'admin') ON DUPLICATE KEY UPDATE username=username");
$conn->query("INSERT INTO users (username, password, fullname, role) VALUES ('staff', '$staffHash', 'Cán bộ văn phòng', 'staff') ON DUPLICATE KEY UPDATE username=username");

echo "Authentication initialized";
