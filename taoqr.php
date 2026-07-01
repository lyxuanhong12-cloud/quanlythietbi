<?php
include 'phpqrcode/qrlib.php';

$id = isset($_GET['id']) ? trim($_GET['id']) : '';
if (!$id) {
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Tham số id không hợp lệ.';
    exit;
}

$host = $_SERVER['HTTP_HOST'];
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$base = dirname($_SERVER['SCRIPT_NAME']);
$base = rtrim($base, '/\\');
$url = sprintf('%s://%s%s/info.php?id=%s', $scheme, $host, $base, urlencode($id));

header('Content-Type: image/png');
QRcode::png($url, false, QR_ECLEVEL_L, 4);
?>