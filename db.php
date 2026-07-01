<?php

$conn = new mysqli(
"localhost",
"root",
"",
"ql_thietbi"
);

if($conn->connect_error){
die("Lỗi kết nối");
}
?>