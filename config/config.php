<?php
$setup=4;
if($setup==1){
// sever ออมทรัพย์
	$host = "192.168.1.1";
	$user = "root";
	$db = "finance";
	$pass="village";

}else if($setup==2){
// เครื่องเรา notebook ตัวเล็ก 
	$host = "localhost";
	$user = "root";
	$db = "brdbv2";
	$pass = "";

}else if($setup==3){
// เครื่องserver ออมทรัพย์ 
	$host = "192.168.1.1";
	$user = "root";
	$db = "brdbv2";
	$pass = "village";

}else if($setup==4){
// notebook lenovo
	$host = "localhost";
	$user = "root";
	$db = "brdbv2";
	$pass = "";

}else if($setup==5){
// เครื่องที่บ้าน ตัวใหญ่
	$host = "192.168.1.1";
	$user = "root";
	$db = "brdbv2";
	$pass = "village";
			
}else{
// เครื่องฝ่ายธนาคาร 
	$host = "127.168.1.55";
	$user = "root";
	$db = "brdbv2";
	$pass = "brcb2015";

}


$link = mysqli_connect($host,$user,$pass,$db)or die("ติดต่อไม่ได้".mysql_error());
mysqli_set_charset($link,'utf8');
$programname="การพัฒนาระบบออมทรัพย์ ชำระเงินกู้ กลุ่มออมทรัพย์เพื่อการผลิตบ้านไร่";
$update="13/08/2560";
$version="0.9";
$foottext = $programname. "<br> BaanRai Community Bank @2015
<font color='red'>lastupdate</font> ".$update." version ".$version;
$sql = "use brdbv2";

date_default_timezone_set('Asia/Bangkok');
//ตรวจสอบการเชื่อมต่อ
if (mysqli_connect_errno())
{
echo "ไม่สามารถติดต่อ MySQL: " . mysqli_connect_error();
}
//เปลี่ยน character set to utf8
if (!$link->set_charset("utf8")) {
printf("Error loading character set utf8: %s\n", $link->error);
}

include('figicon.php');
?>
