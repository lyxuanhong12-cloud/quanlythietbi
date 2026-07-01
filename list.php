<?php

$conn = new mysqli("localhost","root","","ql_thietbi");

$sql = "SELECT * FROM thietbi";

$result = $conn->query($sql);

echo "<h1>DANH SACH THIET BI</h1>";

echo "<table border='1' cellpadding='10'>";

echo "<tr>";
echo "<th>Ma thiet bi</th>";
echo "<th>Ten thiet bi</th>";
echo "<th>Chi tiet</th>";
echo "</tr>";

while($row = $result->fetch_assoc())
{
    echo "<tr>";

    echo "<td>".$row['ma_thietbi']."</td>";

    echo "<td>".$row['ten_thietbi']."</td>";

    echo "<td>";

    echo "<a href='info.php?id=".$row['ma_thietbi']."'>Xem</a>";

    echo "</td>";

    echo "</tr>";
}

echo "</table>";

?>