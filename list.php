<?php

$conn = new mysqli("localhost","root","","ql_thietbi");

$sql = "SELECT * FROM thietbi";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách thiết bị - Quản lý thiết bị</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="page-shell">
        <div class="topbar">
            <div>
                <h1>Hệ thống quản lý thiết bị</h1>
                <p>Danh sách các thiết bị đang được quản lý</p>
            </div>
            <nav class="topnav">
                <a href="index.php">Trang chủ</a>
                <a href="add.php">Thêm thiết bị</a>
                <a class="active" href="list.php">Danh sách thiết bị</a>
            </nav>
        </div>

        <section class="content-card">
            <div class="page-head">
                <div>
                    <h2>Danh sách thiết bị</h2>
                    <p>Thông tin được cập nhật theo dữ liệu trong hệ thống</p>
                </div>
                <span class="badge">Đã đăng ký</span>
            </div>

            <div class="table-wrap">
                <table>
                    <tr>
                        <th>Mã thiết bị</th>
                        <th>Tên thiết bị</th>
                        <th>Chi tiết</th>
                        <th>QR Code</th>
                    </tr>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['ma_thietbi']; ?></td>
                        <td><?php echo $row['ten_thietbi']; ?></td>
                        <td><a class="button-link" href="info.php?id=<?php echo urlencode($row['ma_thietbi']); ?>">Xem</a></td>
                        <td><a class="button-link" href="taoqr.php?id=<?php echo urlencode($row['ma_thietbi']); ?>" target="_blank">QR</a></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </section>
    </div>
</body>
</html>