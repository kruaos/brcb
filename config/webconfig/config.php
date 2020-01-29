<?php
$host = "localhost";
$user = "ka4dev_root";
$db = "ka4dev_brdbv2";
$pass="brcb2015";
$link = mysqli_connect($host,$user,$pass,$db);
mysqli_set_charset($link,'utf8');
$programname="การพัฒนาระบบออมทรัพย์ ชำระเงินกู้ กลุ่มออมทรัพย์เพื่อการผลิตบ้านไร่";
$update="12/07/58";
$version="0.6";
$foottext = $programname. "<br> BaanRai Community Bank @2015 
<font color='red'>lastupdate</font> ".$update." version ".$version;
$sql = "use ka4dev_brdbv2";

date_default_timezone_set('Asia/Bangkok');

$back="<img src='../image/back2.png' width='100'>";
$ac="<img src='../image/acc2.png' width='100'>";
$member="<img src='../image/member2.png' width='100'>";
$dep="<img src='../image/dep2.png' width='100'>";
$wit="<img src='../image/wit2.png' width='100'>";
$add="<img src='../image/add2.png' width='100'>";
$exit="<img src='../image/exit2.png' width='100'>";
$pay="<img src='../image/pay2.png' width='100'>";
$set="<img src='../image/setup.png' width='100'>";
$report="<img src='../image/report.png' width='100'>";
$addw="<img src='../image/addw.png' width='100'>";
$about="<img src='../image/about.png' width='100'>";
$login="<img src='../image/login.png' width='100'>";
$logini="<img src='image/login.png' width='100'>";
$can="<img src='../image/can.png' width='100'>";
$accep="<img src='../image/act.png' width='100'>";
$tol="<img src='../image/tol.png' width='100'>";
$meml="<img src='../image/meml.png' width='100'>";
$memf="<img src='../image/memf2.png' width='100'>";
$memw="<img src='../image/memw.png' width='100'>";
$summ="<img src='../image/summ.png' width='100'>";
$sumd="<img src='../image/sumd.png' width='100'>";
$glt="<img src='../image/glt.png' width='100'>";
$opb="<img src='../image/opb.png' width='100'>";	
$acb="<img src='../image/acb.png' width='100'>";
$depb="<img src='../image/depb.png' width='100'>";
$witb="<img src='../image/witb.png' width='100'>";

$jvback="javascript:history.back();";

$act="../image/act.png";



$month='substr(createdate,6,2)';
$day='substr(createdate,9,2)';



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