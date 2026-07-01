<?php
$active = 'home';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - Quản lý thiết bị</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="page-shell">
        <div class="topbar">
            <div>
                <h1>Hệ thống quản lý thiết bị</h1>
                <p>Giao diện dành cho cán bộ, công chức thao tác nhanh và thuận tiện</p>
            </div>
            <nav class="topnav">
                <a class="active" href="index.php">Trang chủ</a>
                <a href="add.php">Thêm thiết bị</a>
                <a href="list.php">Danh sách thiết bị</a>
            </nav>
        </div>

        <section class="hero">
            <h2>Quản lý thiết bị nhanh, minh bạch và hiện đại</h2>
            <p>Hệ thống giúp cán bộ ghi nhận thiết bị, theo dõi danh sách và truy xuất thông tin một cách thuận tiện.</p>
        </section>

        <section class="content-card">
            <div class="page-head">
                <div>
                    <h2>Chức năng chính</h2>
                    <p>Đi tới các mục quản lý theo nhu cầu công việc</p>
                </div>
            </div>
            <div class="grid">
                <a class="card" href="add.php">
                    <h3>Thêm thiết bị</h3>
                    <p>Nhập mã và tên thiết bị mới vào hệ thống.</p>
                </a>
                <a class="card" href="list.php">
                    <h3>Danh sách thiết bị</h3>
                    <p>Xem toàn bộ thiết bị đang được quản lý.</p>
                </a>
                <a class="card" href="taoqr.php">
                    <h3>Tạo mã QR</h3>
                    <p>Phát sinh file QR cho các thiết bị.</p>
                </a>
            </div>
        </section>
    </div>
</body>
</html>