<?php

$conn = new mysqli("localhost","root","","ql_thietbi");

if($conn->connect_error)
{
    die("Loi ket noi");
}

if(isset($_POST['luu']))
{
    $ma = $_POST['ma'];
    $ten = $_POST['ten'];

    $sql = "INSERT INTO thietbi (ma_thietbi, ten_thietbi) VALUES ('$ma', '$ten')";

    if($conn->query($sql))
    {
        $message = '<div class="alert success">Lưu thành công</div>';
    }
    else
    {
        $message = '<div class="alert error">Lỗi: '.$conn->error.'</div>';
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
                <div class="form-row">
                    <label for="ma">Mã thiết bị</label>
                    <input type="text" id="ma" name="ma" placeholder="Ví dụ: PC001">
                </div>
                <div class="form-row">
                    <label for="ten">Tên thiết bị</label>
                    <input type="text" id="ten" name="ten" placeholder="Ví dụ: Máy tính để bàn">
                </div>
                <input type="submit" name="luu" value="Lưu thông tin">
            </form>
        </section>
    </div>
</body>
</html>