<?php

$conn = new mysqli("localhost", "root", "", "ql_thietbi");
if ($conn->connect_error) {
    die("Lỗi kết nối");
}

function ensureDeviceTableColumns($conn) {
    $existingColumns = [];
    $result = $conn->query("SHOW COLUMNS FROM thietbi");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $existingColumns[] = $row['Field'];
        }
    }

    $columns = [
        'loai_thietbi' => 'VARCHAR(100) DEFAULT NULL',
        'hang_sx' => 'VARCHAR(100) DEFAULT NULL',
        'model' => 'VARCHAR(100) DEFAULT NULL',
        'so_seri' => 'VARCHAR(100) DEFAULT NULL',
        'ngay_mua' => 'VARCHAR(50) DEFAULT NULL',
        'gia_tri' => 'VARCHAR(100) DEFAULT NULL',
        'phong_su_dung' => 'VARCHAR(100) DEFAULT NULL',
        'nguoi_quan_ly' => 'VARCHAR(100) DEFAULT NULL',
        'tinh_trang' => 'VARCHAR(100) DEFAULT NULL',
        'ghi_chu' => 'TEXT DEFAULT NULL',
        'hinh_anh' => 'VARCHAR(255) DEFAULT NULL',
        'ma_qr' => 'VARCHAR(255) DEFAULT NULL'
    ];

    foreach ($columns as $name => $definition) {
        if (!in_array($name, $existingColumns, true)) {
            $conn->query("ALTER TABLE thietbi ADD COLUMN $name $definition");
        }
    }
}
?>