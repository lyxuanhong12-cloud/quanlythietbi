<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin() {
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

function requireRole($allowedRoles) {
    requireLogin();

    $role = $_SESSION['role'] ?? 'staff';
    if (!in_array($role, $allowedRoles, true)) {
        http_response_code(403);
        echo '<div style="padding: 20px; font-family: Arial;">Bạn không có quyền truy cập chức năng này.</div>';
        exit;
    }
}

function currentUser() {
    return [
        'id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? '',
        'fullname' => $_SESSION['fullname'] ?? '',
        'role' => $_SESSION['role'] ?? 'staff',
    ];
}

function roleLabel($role) {
    return $role === 'admin' ? 'Quản trị viên' : 'Cán bộ';
}
