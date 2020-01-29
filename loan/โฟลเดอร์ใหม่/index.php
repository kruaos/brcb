<?php // หน้า index ระบบสินเชื่อ ชำระเงินกู้ loan
include('/library.php');
session_start();
// ชุดคำสั่ง ก๊อกมา เป็นการแก้ไขคำสั่งเตือนแบบ notice
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="l")or($_SESSION['workroleid']=="a"))){
			echo "ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>กรุณาล๊อกอิน</a> ";	
		}else{
?>		

<meta charset="utf-8">
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title><?php include('../config/config.php'); echo $title;?> </title>
<div id="container">
<div id="titlebar3"><br><?php echo $title;?> </div>
	<div id="menu">ฝ่ายสินเชื่อ (เงินกู้)</div>
	<div id="content">
		<a href="addmemberloanload.php"><?php echo$member;?></a>
		<a href="loanpaymentload.php"><?php echo$pay;?></a>
		<a href="/brcb/index.php"><?php echo $exit;?> </a></div>
<div id="tab">
<?php include('../config/config.php'); echo $foottext; 
		}
		?> 
</div>
</div>