<?php
include 'db.php';
ensureDeviceTableColumns($conn);

$message = '';
$search = trim(isset($_GET['q']) ? $_GET['q'] : '');
$editDevice = null;

if (isset($_GET['delete'])) {
    $deleteId = trim($_GET['delete']);
    if ($deleteId !== '') {
        $stmt = $conn->prepare('DELETE FROM thietbi WHERE ma_thietbi = ?');
        $stmt->bind_param('s', $deleteId);
        if ($stmt->execute()) {
            $message = '<div class="alert success">Đã xóa thiết bị thành công.</div>';
        } else {
            $message = '<div class="alert error">Không thể xóa thiết bị.</div>';
        }
        $stmt->close();
    }
}

if (isset($_POST['save_edit'])) {
    $oldId = trim($_POST['edit_id']);
    $newId = trim($_POST['edit_ma']);
    $newName = trim($_POST['edit_ten']);
    $loai = trim($_POST['edit_loai_thietbi'] ?? '');
    $hang = trim($_POST['edit_hang_sx'] ?? '');
    $model = trim($_POST['edit_model'] ?? '');
    $seri = trim($_POST['edit_so_seri'] ?? '');
    $ngayMua = trim($_POST['edit_ngay_mua'] ?? '');
    $giaTri = trim($_POST['edit_gia_tri'] ?? '');
    $phong = trim($_POST['edit_phong_su_dung'] ?? '');
    $nguoi = trim($_POST['edit_nguoi_quan_ly'] ?? '');
    $tinhTrang = trim($_POST['edit_tinh_trang'] ?? '');
    $ghiChu = trim($_POST['edit_ghi_chu'] ?? '');
    $hinhAnh = trim($_POST['edit_hinh_anh'] ?? '');
    $maQr = 'info.php?id=' . $newId;

    if ($oldId !== '' && $newId !== '' && $newName !== '') {
        $stmt = $conn->prepare('UPDATE thietbi SET ma_thietbi = ?, ten_thietbi = ?, loai_thietbi = ?, hang_sx = ?, model = ?, so_seri = ?, ngay_mua = ?, gia_tri = ?, phong_su_dung = ?, nguoi_quan_ly = ?, tinh_trang = ?, ghi_chu = ?, hinh_anh = ?, ma_qr = ? WHERE ma_thietbi = ?');
        $stmt->bind_param('sssssssssssssss', $newId, $newName, $loai, $hang, $model, $seri, $ngayMua, $giaTri, $phong, $nguoi, $tinhTrang, $ghiChu, $hinhAnh, $maQr, $oldId);
        if ($stmt->execute()) {
            $message = '<div class="alert success">Cập nhật thiết bị thành công.</div>';
        } else {
            $message = '<div class="alert error">Không thể cập nhật thiết bị.</div>';
        }
        $stmt->close();
    } else {
        $message = '<div class="alert error">Vui lòng nhập đầy đủ mã và tên thiết bị.</div>';
    }
}

if (isset($_GET['edit'])) {
    $editId = trim($_GET['edit']);
    if ($editId !== '') {
        $stmt = $conn->prepare('SELECT ma_thietbi, ten_thietbi, loai_thietbi, hang_sx, model, so_seri, ngay_mua, gia_tri, phong_su_dung, nguoi_quan_ly, tinh_trang, ghi_chu, hinh_anh, ma_qr FROM thietbi WHERE ma_thietbi = ?');
        $stmt->bind_param('s', $editId);
        $stmt->execute();
        $resultEdit = $stmt->get_result();
        $editDevice = $resultEdit->fetch_assoc();
        $stmt->close();
    }
}

if ($search !== '') {
    $like = '%' . $search . '%';
    $stmt = $conn->prepare('SELECT * FROM thietbi WHERE ma_thietbi LIKE ? OR ten_thietbi LIKE ? ORDER BY ma_thietbi');
    $stmt->bind_param('ss', $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    $result = $conn->query('SELECT * FROM thietbi ORDER BY ma_thietbi');
}

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

            <?php echo $message; ?>

            <form method="get" class="search-row">
                <input class="search-input" type="text" name="q" value="<?php echo htmlspecialchars($search); ?>" placeholder="Tìm theo mã hoặc tên thiết bị">
                <input type="submit" value="Tìm kiếm">
            </form>

            <?php if ($editDevice): ?>
            <div class="content-card inner-card">
                <h3>Sửa thông tin thiết bị</h3>
                <form method="post" class="form-card">
                    <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($editDevice['ma_thietbi']); ?>">
                    <div class="form-grid">
                        <div class="form-row">
                            <label for="edit_ma">Mã thiết bị</label>
                            <input type="text" id="edit_ma" name="edit_ma" value="<?php echo htmlspecialchars($editDevice['ma_thietbi'] ?? ''); ?>" required>
                        </div>
                        <div class="form-row">
                            <label for="edit_ten">Tên thiết bị</label>
                            <input type="text" id="edit_ten" name="edit_ten" value="<?php echo htmlspecialchars($editDevice['ten_thietbi'] ?? ''); ?>" required>
                        </div>
                        <div class="form-row">
                            <label for="edit_loai_thietbi">Loại thiết bị</label>
                            <input type="text" id="edit_loai_thietbi" name="edit_loai_thietbi" value="<?php echo htmlspecialchars($editDevice['loai_thietbi'] ?? ''); ?>">
                        </div>
                        <div class="form-row">
                            <label for="edit_hang_sx">Hãng sản xuất</label>
                            <input type="text" id="edit_hang_sx" name="edit_hang_sx" value="<?php echo htmlspecialchars($editDevice['hang_sx'] ?? ''); ?>">
                        </div>
                        <div class="form-row">
                            <label for="edit_model">Model</label>
                            <input type="text" id="edit_model" name="edit_model" value="<?php echo htmlspecialchars($editDevice['model'] ?? ''); ?>">
                        </div>
                        <div class="form-row">
                            <label for="edit_so_seri">Số sê-ri</label>
                            <input type="text" id="edit_so_seri" name="edit_so_seri" value="<?php echo htmlspecialchars($editDevice['so_seri'] ?? ''); ?>">
                        </div>
                        <div class="form-row">
                            <label for="edit_ngay_mua">Ngày mua</label>
                            <input type="text" id="edit_ngay_mua" name="edit_ngay_mua" value="<?php echo htmlspecialchars($editDevice['ngay_mua'] ?? ''); ?>">
                        </div>
                        <div class="form-row">
                            <label for="edit_gia_tri">Giá trị</label>
                            <input type="text" id="edit_gia_tri" name="edit_gia_tri" value="<?php echo htmlspecialchars($editDevice['gia_tri'] ?? ''); ?>">
                        </div>
                        <div class="form-row">
                            <label for="edit_phong_su_dung">Phòng sử dụng</label>
                            <input type="text" id="edit_phong_su_dung" name="edit_phong_su_dung" value="<?php echo htmlspecialchars($editDevice['phong_su_dung'] ?? ''); ?>">
                        </div>
                        <div class="form-row">
                            <label for="edit_nguoi_quan_ly">Người quản lý</label>
                            <input type="text" id="edit_nguoi_quan_ly" name="edit_nguoi_quan_ly" value="<?php echo htmlspecialchars($editDevice['nguoi_quan_ly'] ?? ''); ?>">
                        </div>
                        <div class="form-row">
                            <label for="edit_tinh_trang">Tình trạng</label>
                            <input type="text" id="edit_tinh_trang" name="edit_tinh_trang" value="<?php echo htmlspecialchars($editDevice['tinh_trang'] ?? ''); ?>">
                        </div>
                        <div class="form-row">
                            <label for="edit_hinh_anh">Hình ảnh</label>
                            <input type="text" id="edit_hinh_anh" name="edit_hinh_anh" value="<?php echo htmlspecialchars($editDevice['hinh_anh'] ?? ''); ?>">
                        </div>
                        <div class="form-row full-width">
                            <label for="edit_ghi_chu">Ghi chú</label>
                            <textarea id="edit_ghi_chu" name="edit_ghi_chu"><?php echo htmlspecialchars($editDevice['ghi_chu'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    <div class="inline-actions">
                        <input type="submit" name="save_edit" value="Lưu thay đổi">
                        <a class="button-link secondary" href="list.php<?php echo $search !== '' ? '?q=' . urlencode($search) : ''; ?>">Hủy</a>
                    </div>
                </form>
            </div>
            <?php endif; ?>

            <div class="table-wrap">
                <table>
                    <tr>
                        <th>Mã thiết bị</th>
                        <th>Tên thiết bị</th>
                        <th>Chi tiết</th>
                        <th>QR Code</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php if ($result->num_rows === 0): ?>
                    <tr>
                        <td colspan="5" class="empty-state">Không tìm thấy thiết bị phù hợp.</td>
                    </tr>
                    <?php else: ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['ma_thietbi']); ?></td>
                        <td><?php echo htmlspecialchars($row['ten_thietbi']); ?></td>
                        <td><a class="button-link" href="info.php?id=<?php echo urlencode($row['ma_thietbi']); ?>">Xem</a></td>
                        <td>
                            <div class="inline-actions">
                                <a class="button-link" href="taoqr.php?id=<?php echo urlencode($row['ma_thietbi']); ?>" target="_blank">QR</a>
                                <a class="button-link secondary" href="taoqr.php?id=<?php echo urlencode($row['ma_thietbi']); ?>&download=1" download="qr_<?php echo urlencode($row['ma_thietbi']); ?>.png">Tải về</a>
                            </div>
                        </td>
                        <td>
                            <div class="inline-actions">
                                <a class="button-link secondary" href="list.php?edit=<?php echo urlencode($row['ma_thietbi']); ?><?php echo $search !== '' ? '&q=' . urlencode($search) : ''; ?>">Sửa</a>
                                <a class="button-link danger" href="list.php?delete=<?php echo urlencode($row['ma_thietbi']); ?><?php echo $search !== '' ? '&q=' . urlencode($search) : ''; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa thiết bị này?');">Xóa</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php endif; ?>
                </table>
            </div>
        </section>
    </div>
</body>
</html>