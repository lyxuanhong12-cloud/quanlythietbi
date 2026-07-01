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

    $sql = "INSERT INTO thietbi
    (ma_thietbi,ten_thietbi)
    VALUES
    ('$ma','$ten')";

    if($conn->query($sql))
    {
        echo "Luu thanh cong";
    }
    else
    {
        echo "Loi: ".$conn->error;
    }
}

?>

<h2>Nhap thiet bi</h2>

<form method="post">

Ma thiet bi:<br>
<input type="text" name="ma">
<br><br>

Ten thiet bi:<br>
<input type="text" name="ten">
<br><br>

<input type="submit" name="luu" value="Luu">

</form>