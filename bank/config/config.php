<?php
$host = "localhost";
$user = "root";
$db = "finance2";
$pass="";
$link = mysqli_connect($host,$user,$pass,$db);
mysqli_set_charset($link,'utf8');



//ตรวจสอบการเชื่อมต่อ
if (mysqli_connect_errno())
{
echo "ไม่สามารถติดต่อ MySQL: " . mysqli_connect_error();
}
//เปลี่ยน character set to utf8
if (!$link->set_charset("utf8")) {
printf("Error loading character set utf8: %s\n", $link->error);
}
?>
