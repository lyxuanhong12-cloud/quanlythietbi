<?php
include 'db.php';
include 'auth.php';
requireRole(['admin', 'staff']);
ensureDeviceTableColumns($conn);

$message = '';
if (isset($_POST['luu'])) {
    $ma = trim($_POST['ma'] ?? '');
    $ten = trim($_POST['ten'] ?? '');
    $loai = trim($_POST['loai_thietbi'] ?? '');
    $hang = trim($_POST['hang_sx'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $seri = trim($_POST['so_seri'] ?? '');
    $ngayMua = trim($_POST['ngay_mua'] ?? '');
    $giaTri = trim($_POST['gia_tri'] ?? '');
    $phong = trim($_POST['phong_su_dung'] ?? '');
    $nguoi = trim($_POST['nguoi_quan_ly'] ?? '');
    $tinhTrang = trim($_POST['tinh_trang'] ?? '');
    $ghiChu = trim($_POST['ghi_chu'] ?? '');
    $hinhAnh = trim($_POST['hinh_anh'] ?? '');
    $maQr = 'info.php?id=' . $ma;

    if ($ma !== '' && $ten !== '') {
        $stmt = $conn->prepare('INSERT INTO thietbi (ma_thietbi, ten_thietbi, loai_thietbi, hang_sx, model, so_seri, ngay_mua, gia_tri, phong_su_dung, nguoi_quan_ly, tinh_trang, ghi_chu, hinh_anh, ma_qr) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssssssssssss', $ma, $ten, $loai, $hang, $model, $seri, $ngayMua, $giaTri, $phong, $nguoi, $tinhTrang, $ghiChu, $hinhAnh, $maQr);
        if ($stmt->execute()) {
            $message = '<div class="alert success">Lưu thành công</div>';
        } else {
            $message = '<div class="alert error">Lỗi: ' . $conn->error . '</div>';
        }
        $stmt->close();
    } else {
        $message = '<div class="alert error">Vui lòng nhập mã và tên thiết bị</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm thiết bị - Quản lý thiết bị</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="page-shell">
        <div class="topbar">
            <div>
                <h1>Hệ thống quản lý thiết bị</h1>
                <p>Quản lý thiết bị theo quy trình đơn giản, chuyên nghiệp</p>
            </div>
            <nav class="topnav">
                <a href="index.php">Trang chủ</a>
                <a class="active" href="add.php">Thêm thiết bị</a>
                <a href="list.php">Danh sách thiết bị</a>
                <a href="logout.php">Đăng xuất</a>
            </nav>
        </div>

        <section class="content-card">
            <div class="page-head">
                <div>
                    <h2>Nhập thông tin thiết bị</h2>
                    <p>Thông tin sẽ được lưu vào hệ thống để tra cứu sau này</p>
                </div>
            </div>

            <?php if(isset($message)) echo $message; ?>

            <form method="post" class="form-card">
                <div class="form-grid">
                    <div class="form-row">
                        <label for="ma">Mã thiết bị</label>
                        <input type="text" id="ma" name="ma" placeholder="Ví dụ: PC001">
                    </div>
                    <div class="form-row">
                        <label for="ten">Tên thiết bị</label>
                        <input type="text" id="ten" name="ten" placeholder="Ví dụ: Máy tính để bàn">
                    </div>
                    <div class="form-row">
                        <label for="loai_thietbi">Loại thiết bị</label>
                        <input type="text" id="loai_thietbi" name="loai_thietbi" placeholder="Ví dụ: Máy tính">
                    </div>
                    <div class="form-row">
                        <label for="hang_sx">Hãng sản xuất</label>
                        <input type="text" id="hang_sx" name="hang_sx" placeholder="Ví dụ: Dell">
                    </div>
                    <div class="form-row">
                        <label for="model">Model</label>
                        <input type="text" id="model" name="model" placeholder="Ví dụ: Latitude 5440">
                    </div>
                    <div class="form-row">
                        <label for="so_seri">Số sê-ri</label>
                        <input type="text" id="so_seri" name="so_seri" placeholder="Ví dụ: SN12345">
                    </div>
                    <div class="form-row">
                        <label for="ngay_mua">Ngày mua</label>
                        <input type="text" id="ngay_mua" name="ngay_mua" placeholder="Ví dụ: 2026-01-15">
                    </div>
                    <div class="form-row">
                        <label for="gia_tri">Giá trị</label>
                        <input type="text" id="gia_tri" name="gia_tri" placeholder="Ví dụ: 15000000">
                    </div>
                    <div class="form-row">
                        <label for="phong_su_dung">Phòng sử dụng</label>
                        <input type="text" id="phong_su_dung" name="phong_su_dung" placeholder="Ví dụ: Phòng CNTT">
                    </div>
                    <div class="form-row">
                        <label for="nguoi_quan_ly">Người quản lý</label>
                        <input type="text" id="nguoi_quan_ly" name="nguoi_quan_ly" placeholder="Ví dụ: Nguyễn Văn A">
                    </div>
                    <div class="form-row">
                        <label for="tinh_trang">Tình trạng</label>
                        <input type="text" id="tinh_trang" name="tinh_trang" placeholder="Ví dụ: Bình thường">
                    </div>
                    <div class="form-row">
                        <label for="hinh_anh">Hình ảnh</label>
                        <input type="text" id="hinh_anh" name="hinh_anh" placeholder="Đường dẫn hoặc tên file ảnh">
                    </div>
                    <div class="form-row full-width">
                        <label for="ghi_chu">Ghi chú</label>
                        <textarea id="ghi_chu" name="ghi_chu" placeholder="Ghi chú thêm về thiết bị"></textarea>
                    </div>
                </div>
                <input type="submit" name="luu" value="Lưu thông tin">
            </form>
        </section>
    </div>
</body>
</html>