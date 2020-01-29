<?php
$title = "ระบบธนาคารชุมชน";

$programname="การพัฒนาระบบออมทรัพย์ ชำระเงินกู้ กลุ่มออมทรัพย์เพื่อการผลิตบ้านไร่";
$update="13/03/60";
$version="0.8";
$foottext = $programname. "<br> BaanRai Community Bank @2015
<font color='red'>lastupdate</font> ".$update." version ".$version;
$sql = "use brdbv2";

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
$person="<img src='../image/person.png' width='100'>";
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

$mname=array("ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ตุ.ค.","พ.ย.","ธ.ค.");


$month='substr(createdate,6,2)';
$day='substr(createdate,9,2)';
$yearf='substr(createdate,1,4)';

?>