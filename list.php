<?php

$conn = new mysqli("localhost","root","","ql_thietbi");
if ($conn->connect_error) {
    die("Lỗi kết nối cơ sở dữ liệu");
}

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

    if ($oldId !== '' && $newId !== '' && $newName !== '') {
        $stmt = $conn->prepare('UPDATE thietbi SET ma_thietbi = ?, ten_thietbi = ? WHERE ma_thietbi = ?');
        $stmt->bind_param('sss', $newId, $newName, $oldId);
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
        $stmt = $conn->prepare('SELECT ma_thietbi, ten_thietbi FROM thietbi WHERE ma_thietbi = ?');
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
                    <div class="form-row">
                        <label for="edit_ma">Mã thiết bị</label>
                        <input type="text" id="edit_ma" name="edit_ma" value="<?php echo htmlspecialchars($editDevice['ma_thietbi']); ?>" required>
                    </div>
                    <div class="form-row">
                        <label for="edit_ten">Tên thiết bị</label>
                        <input type="text" id="edit_ten" name="edit_ten" value="<?php echo htmlspecialchars($editDevice['ten_thietbi']); ?>" required>
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