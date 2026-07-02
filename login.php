<?php
include 'db.php';
include 'auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username !== '' && $password !== '') {
        $stmt = $conn->prepare('SELECT id, username, password, fullname, role FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];
            header('Location: index.php');
            exit;
        }

        $message = '<div class="alert error">Tên đăng nhập hoặc mật khẩu không đúng.</div>';
    } else {
        $message = '<div class="alert error">Vui lòng nhập đầy đủ thông tin.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Quản lý thiết bị</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="page-shell">
        <section class="content-card" style="max-width: 480px; margin: 40px auto;">
            <div class="page-head">
                <div>
                    <h2>Đăng nhập hệ thống</h2>
                    <p>Quản lý thiết bị bằng mã QR trong mạng nội bộ</p>
                </div>
            </div>
            <?php echo $message; ?>
            <form method="post" class="form-card">
                <div class="form-row">
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-row">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <input type="submit" value="Đăng nhập">
            </form>
            <p class="small" style="margin-top: 12px;">Tài khoản mặc định: admin / admin123</p>
        </section>
    </div>
</body>
</html>
