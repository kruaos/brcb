<link rel="stylesheet" href="../config/css1.css" type="text/css" /> <?php 
session_start();
include('library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="o")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
?>
<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php include('/library.php'); ?>
<title><?php echo $title;?></title>
<div id="container">
	<div id="header"><b><?php echo $title;?></b></div>
	<div id="header">บันทึกการปรับปรุงระบบ</div>
	<div id="tab">
		<div id="menu">version 0.1</div>
		<div id="content">- พัฒนาขึ้นช่วงต้นเดือน กุมภาพันธ์ ลักษณะเป็นผังความคิดและต้นร่างระบบ <br>
		</div>
	</div>	
	<div id="tab">
		<div id="menu">version 0.2</div>
		<div id="content">- เพิ่มตารางรูปแบบของโปรแกรม มีความชัดเจนขึ้น  <br>
		</div>
	</div>
	<div id="tab">
		<div id="menu">version 0.3</div>
		<div id="content">- มีการเชื่อมฐานข้อมูลเข้ากับระบบโปรแกรม <br>- มีการปรับฐานข้อมูลครั้งที่ 2<br>
		</div>
	</div>
	<div id="tab">
		<div id="menu">version 0.4</div>
		<div id="content">5 มิย 58 <br>- มีการใช้ CSS เข้ามาประกอบกับระบบมากขึ้น  <br>
		</div>
	</div>
	<div id="tab">
		<div id="menu">version 0.5</div>
		<div id="content">25 มิย 58 <br>- มีการปรับฐานข้อมูล เป็นครั้งที่ 3 <br>เปลี่ยนชื่อเป็น "ระบบบริหารสารสนเทศกิจการกลุ่มออมทรัพย์เพื่อการผลิตบ้านไร่"<br>
		1 กรกฎา 58 <br>
		- แก้ไขการเช็คค่า ที่ป้อนผิด  <br>
		- ปรับหน้าตาส่วนการฝาก ถอน ให้มีสีแตกต่างกัน 
		</div>
	</div>
	<div id="tab">
		<div id="menu">version 0.6</div>
		<div id="content">12 กรกฎา 58<br>
		- เพิ่มระบบ ธนาคารชุมชน คงค้างการคิดดอกเบี้ย 
		</div>
	</div>
</div>
<?php 
if (($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i")){$workroleid="admin";}else{$workroleid="office";}
		echo "</table><div id='container'><div id='tab'><a href=../$workroleid/>$back</a>" ;}
?>
</div>

