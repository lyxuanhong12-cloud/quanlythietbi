<?php

include 'phpqrcode/qrlib.php';

QRcode::png("PC001","qrcode/PC001.png");
QRcode::png("PC002","qrcode/PC002.png");
QRcode::png("PC003","qrcode/PC003.png");
QRcode::png("PR001","qrcode/PR001.png");
QRcode::png("SC001","qrcode/SC001.png");
QRcode::png("TV001","qrcode/TV001.png");

echo "Da tao QR";

?>