<?php
include 'db.php';
include 'auth.php';
requireLogin();
ensureDeviceTableColumns($conn);

$currentUser = currentUser();

$result_total = $conn->query("SELECT COUNT(*) as total FROM thietbi");
$row_total = $result_total->fetch_assoc();
$total_devices = $row_total['total'] ?? 0;

$result_active = $conn->query("SELECT COUNT(*) as count FROM thietbi WHERE tinh_trang = 'Bình thường' OR tinh_trang IS NULL OR tinh_trang = ''");
$row_active = $result_active->fetch_assoc();
$active_devices = $row_active['count'] ?? 0;

$result_broken = $conn->query("SELECT COUNT(*) as count FROM thietbi WHERE tinh_trang = 'Hỏng'");
$row_broken = $result_broken->fetch_assoc();
$broken_devices = $row_broken['count'] ?? 0;

$result_repair = $conn->query("SELECT COUNT(*) as count FROM thietbi WHERE tinh_trang = 'Đang sửa chữa'");
$row_repair = $result_repair->fetch_assoc();
$repair_devices = $row_repair['count'] ?? 0;

$result_by_room = $conn->query("SELECT phong_su_dung, COUNT(*) as count FROM thietbi WHERE phong_su_dung IS NOT NULL AND phong_su_dung != '' GROUP BY phong_su_dung ORDER BY count DESC LIMIT 10");
$devices_by_room = [];
while ($row = $result_by_room->fetch_assoc()) {
    $devices_by_room[] = $row;
}

$result_by_type = $conn->query("SELECT loai_thietbi, COUNT(*) as count FROM thietbi WHERE loai_thietbi IS NOT NULL AND loai_thietbi != '' GROUP BY loai_thietbi ORDER BY count DESC LIMIT 10");
$devices_by_type = [];
while ($row = $result_by_type->fetch_assoc()) {
    $devices_by_type[] = $row;
}

$result_by_status = $conn->query("SELECT tinh_trang, COUNT(*) as count FROM thietbi GROUP BY tinh_trang");
$devices_by_status = [];
while ($row = $result_by_status->fetch_assoc()) {
    $status = $row['tinh_trang'] ?: 'Chưa xác định';
    $devices_by_status[$status] = $row['count'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Quản lý thiết bị</title>
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="page-shell">
        <div class="topbar">
            <div>
                <h1>Hệ thống quản lý thiết bị</h1>
                <p>Xin chào, <?php echo htmlspecialchars($currentUser['fullname'] ?: $currentUser['username']); ?> - <?php echo roleLabel($currentUser['role']); ?></p>
            </div>
            <nav class="topnav">
                <a class="active" href="index.php">Trang chủ</a>
                <a href="dashboard.php">Thống kê</a>
                <a href="add.php">Thêm thiết bị</a>
                <a href="list.php">Danh sách</a>
                <a href="logout.php">Đăng xuất</a>
            </nav>
        </div>

        <section class="content-card">
            <div class="page-head">
                <div>
                    <h2>Dashboard Thống kê</h2>
                    <p>Tổng quan về tình trạng thiết bị trong hệ thống</p>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Tổng số thiết bị</div>
                    <div class="stat-number"><?php echo $total_devices; ?></div>
                </div>
                <!-- 
                <div class="stat-card active">
                    <div class="stat-label">Thiết bị hoạt động</div>
                    <div class="stat-number"><?php echo $active_devices; ?></div>
                </div>
                <div class="stat-card broken">
                    <div class="stat-label">Thiết bị hỏng</div>
                    <div class="stat-number"><?php echo $broken_devices; ?></div>
                </div>
                <div class="stat-card repair">
                    <div class="stat-label">Đang sửa chữa</div>
                    <div class="stat-number"><?php echo $repair_devices; ?></div>
                </div>
                -->
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
                <div class="content-card">
                    <h3>Thiết bị theo tình trạng</h3>
                    <canvas id="statusChart" height="200"></canvas>
                </div>
                <?php if (!empty($devices_by_room)): ?>
                <div class="content-card">
                    <h3>Thiết bị theo phòng</h3>
                    <canvas id="roomChart" height="200"></canvas>
                </div>
                <?php endif; ?>
                <?php if (!empty($devices_by_type)): ?>
                <div class="content-card">
                    <h3>Thiết bị theo loại</h3>
                    <canvas id="typeChart" height="200"></canvas>
                </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($devices_by_room)): ?>
            <div class="content-card" style="margin-top: 20px;">
                <h3>Danh sách thiết bị theo phòng</h3>
                <div class="table-wrap">
                    <table>
                        <tr>
                            <th>Phòng</th>
                            <th>Số lượng thiết bị</th>
                        </tr>
                        <?php foreach ($devices_by_room as $room): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($room['phong_su_dung'] ?: 'Không xác định'); ?></td>
                            <td><?php echo $room['count']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <div class="content-card" style="margin-top: 20px;">
                <h3>Tùy chọn xuất báo cáo</h3>
                <div class="inline-actions">
                    <a class="button-link" href="export_excel.php">Xuất Excel</a>
                    <a class="button-link secondary" href="export_excel.php?format=csv">Xuất CSV</a>
                </div>
            </div>
        </section>
    </div>

    <script>
        const statusLabels = <?php echo json_encode(array_keys($devices_by_status)); ?>;
        const statusData = <?php echo json_encode(array_values($devices_by_status)); ?>;

        const ctx = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: ['#10b981', '#ef4444', '#f59e0b', '#3b82f6', '#8b5cf6'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        <?php if (!empty($devices_by_room)): ?>
        const roomLabels = <?php echo json_encode(array_map(function($r) { return $r['phong_su_dung'] ?: 'Chưa xác định'; }, $devices_by_room)); ?>;
        const roomData = <?php echo json_encode(array_map(function($r) { return $r['count']; }, $devices_by_room)); ?>;

        const roomCtx = document.getElementById('roomChart').getContext('2d');
        new Chart(roomCtx, {
            type: 'bar',
            data: {
                labels: roomLabels,
                datasets: [{
                    label: 'Số thiết bị',
                    data: roomData,
                    backgroundColor: '#3b82f6',
                    borderColor: '#1d4ed8',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        <?php endif; ?>

        <?php if (!empty($devices_by_type)): ?>
        const typeLabels = <?php echo json_encode(array_map(function($t) { return $t['loai_thietbi'] ?: 'Chưa xác định'; }, $devices_by_type)); ?>;
        const typeData = <?php echo json_encode(array_map(function($t) { return $t['count']; }, $devices_by_type)); ?>;

        const typeCtx = document.getElementById('typeChart').getContext('2d');
        new Chart(typeCtx, {
            type: 'bar',
            data: {
                labels: typeLabels,
                datasets: [{
                    label: 'Số thiết bị',
                    data: typeData,
                    backgroundColor: '#10b981',
                    borderColor: '#059669',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
        <?php endif; ?>
    </script>
</body>
</html>
