<?php
include 'db.php';
include 'auth.php';
requireLogin();
ensureDeviceTableColumns($conn);

$id = isset($_GET['id']) ? trim($_GET['id']) : '';
if (!$id) {
    $error = 'Mã thiết bị không được rỗng.';
} else {
    $stmt = $conn->prepare('SELECT ma_thietbi, ten_thietbi, loai_thietbi, hang_sx, model, so_seri, ngay_mua, gia_tri, phong_su_dung, nguoi_quan_ly, tinh_trang, ghi_chu, hinh_anh, ma_qr FROM thietbi WHERE ma_thietbi = ?');
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $device = $result->fetch_assoc();
    $stmt->close();
    if (!$device) {
        $error = 'Không tìm thấy thiết bị với mã đã chỉ định.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết thiết bị - Quản lý thiết bị</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="page-shell">
        <div class="topbar">
            <div>
                <h1>Chi tiết thiết bị</h1>
                <p>Thông tin đầy đủ và liên kết truy xuất thiết bị</p>
            </div>
            <nav class="topnav">
                <a href="index.php">Trang chủ</a>
                <a href="dashboard.php">Thống kê</a>
                <a href="add.php">Thêm thiết bị</a>
                <a href="list.php">Danh sách thiết bị</a>
                <a href="logout.php">Đăng xuất</a>
            </nav>
        </div>

        <section class="content-card">
            <div class="page-head">
                <div>
                    <h2>Thông tin thiết bị</h2>
                    <p>Chi tiết được lấy theo ID từ đường dẫn.</p>
                </div>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
            <?php else: ?>
                <div class="form-card">
                    <div class="form-grid">
                        <div class="form-row">
                            <label>Mã thiết bị</label>
                            <input type="text" value="<?php echo htmlspecialchars($device['ma_thietbi'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-row">
                            <label>Tên thiết bị</label>
                            <input type="text" value="<?php echo htmlspecialchars($device['ten_thietbi'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-row">
                            <label>Loại thiết bị</label>
                            <input type="text" value="<?php echo htmlspecialchars($device['loai_thietbi'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-row">
                            <label>Hãng sản xuất</label>
                            <input type="text" value="<?php echo htmlspecialchars($device['hang_sx'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-row">
                            <label>Model</label>
                            <input type="text" value="<?php echo htmlspecialchars($device['model'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-row">
                            <label>Số sê-ri</label>
                            <input type="text" value="<?php echo htmlspecialchars($device['so_seri'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-row">
                            <label>Ngày mua</label>
                            <input type="text" value="<?php echo htmlspecialchars($device['ngay_mua'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-row">
                            <label>Giá trị</label>
                            <input type="text" value="<?php echo htmlspecialchars($device['gia_tri'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-row">
                            <label>Phòng sử dụng</label>
                            <input type="text" value="<?php echo htmlspecialchars($device['phong_su_dung'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-row">
                            <label>Người quản lý</label>
                            <input type="text" value="<?php echo htmlspecialchars($device['nguoi_quan_ly'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-row">
                            <label>Tình trạng</label>
                            <input type="text" value="<?php echo htmlspecialchars($device['tinh_trang'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-row">
                            <label>Hình ảnh</label>
                            <input type="text" value="<?php echo htmlspecialchars($device['hinh_anh'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-row full-width">
                            <label>Ghi chú</label>
                            <textarea readonly><?php echo htmlspecialchars($device['ghi_chu'] ?? ''); ?></textarea>
                        </div>
                        <div class="form-row full-width">
                            <label>Mã QR</label>
                            <img src="taoqr.php?id=<?php echo urlencode($device['ma_thietbi']); ?>" alt="QR code thiết bị">
                            <div class="inline-actions" style="margin-top: 8px;">
                                <a class="button-link" href="taoqr.php?id=<?php echo urlencode($device['ma_thietbi']); ?>" target="_blank">Xem QR</a>
                                <a class="button-link secondary" href="taoqr.php?id=<?php echo urlencode($device['ma_thietbi']); ?>&download=1" download="qr_<?php echo urlencode($device['ma_thietbi']); ?>.png">Tải về</a>
                            </div>
                            <p class="small">Quét mã để mở trang chi tiết thiết bị trên điện thoại.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>