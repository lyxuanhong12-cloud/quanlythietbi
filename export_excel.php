<?php
include 'db.php';
include 'auth.php';
requireLogin();

$format = isset($_GET['format']) ? trim($_GET['format']) : 'excel';

$result = $conn->query("SELECT ma_thietbi, ten_thietbi, loai_thietbi, hang_sx, model, so_seri, ngay_mua, gia_tri, phong_su_dung, nguoi_quan_ly, tinh_trang, ghi_chu, hinh_anh FROM thietbi ORDER BY ma_thietbi");
$devices = [];
while ($row = $result->fetch_assoc()) {
    $devices[] = $row;
}

if ($format === 'csv') {
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="thietbi_' . date('Y-m-d_His') . '.csv"');

    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

    fputcsv($output, [
        'Mã thiết bị',
        'Tên thiết bị',
        'Loại thiết bị',
        'Hãng sản xuất',
        'Model',
        'Số sê-ri',
        'Ngày mua',
        'Giá trị',
        'Phòng sử dụng',
        'Người quản lý',
        'Tình trạng',
        'Ghi chú',
        'Hình ảnh'
    ]);

    foreach ($devices as $device) {
        fputcsv($output, [
            $device['ma_thietbi'],
            $device['ten_thietbi'],
            $device['loai_thietbi'] ?: '',
            $device['hang_sx'] ?: '',
            $device['model'] ?: '',
            $device['so_seri'] ?: '',
            $device['ngay_mua'] ?: '',
            $device['gia_tri'] ?: '',
            $device['phong_su_dung'] ?: '',
            $device['nguoi_quan_ly'] ?: '',
            $device['tinh_trang'] ?: '',
            $device['ghi_chu'] ?: '',
            $device['hinh_anh'] ?: ''
        ]);
    }

    fclose($output);
} else {
    header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
    header('Content-Disposition: attachment; filename="thietbi_' . date('Y-m-d_His') . '.xls"');
    
    echo '<html><head><meta charset="UTF-8"></head><body>';
    echo '<table border="1" cellpadding="10">';
    echo '<tr>';
    echo '<th>Mã thiết bị</th>';
    echo '<th>Tên thiết bị</th>';
    echo '<th>Loại thiết bị</th>';
    echo '<th>Hãng sản xuất</th>';
    echo '<th>Model</th>';
    echo '<th>Số sê-ri</th>';
    echo '<th>Ngày mua</th>';
    echo '<th>Giá trị</th>';
    echo '<th>Phòng sử dụng</th>';
    echo '<th>Người quản lý</th>';
    echo '<th>Tình trạng</th>';
    echo '<th>Ghi chú</th>';
    echo '<th>Hình ảnh</th>';
    echo '</tr>';

    foreach ($devices as $device) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($device['ma_thietbi']) . '</td>';
        echo '<td>' . htmlspecialchars($device['ten_thietbi']) . '</td>';
        echo '<td>' . htmlspecialchars($device['loai_thietbi'] ?: '') . '</td>';
        echo '<td>' . htmlspecialchars($device['hang_sx'] ?: '') . '</td>';
        echo '<td>' . htmlspecialchars($device['model'] ?: '') . '</td>';
        echo '<td>' . htmlspecialchars($device['so_seri'] ?: '') . '</td>';
        echo '<td>' . htmlspecialchars($device['ngay_mua'] ?: '') . '</td>';
        echo '<td>' . htmlspecialchars($device['gia_tri'] ?: '') . '</td>';
        echo '<td>' . htmlspecialchars($device['phong_su_dung'] ?: '') . '</td>';
        echo '<td>' . htmlspecialchars($device['nguoi_quan_ly'] ?: '') . '</td>';
        echo '<td>' . htmlspecialchars($device['tinh_trang'] ?: '') . '</td>';
        echo '<td>' . htmlspecialchars($device['ghi_chu'] ?: '') . '</td>';
        echo '<td>' . htmlspecialchars($device['hinh_anh'] ?: '') . '</td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '</body></html>';
}
