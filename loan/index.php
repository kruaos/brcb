<link rel="stylesheet" href="../config/css1.css" type="text/css" />
<?php // หน้า index ระบบสินเชื่อ ชำระเงินกู้ loan
include('/library.php');include('../config/config.php');
session_start();
// ชุดคำสั่ง ก๊อกมา เป็นการแก้ไขคำสั่งเตือนแบบ notice
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="l")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
?>		

<meta charset="utf-8">

<title><?php  echo $title;?> </title>
<div id="container">
<div id="titlebar3"><br><?php echo $title;?> </div>
	<div id="menu">ฝ่ายสินเชื่อ (เงินกู้)<br><?php 

$sql="select a.*,b.pname,b.mname, b.lname,c.* from worker a , memberfund b ,workrole_result c
where a.fundno=b.fundno and a.workroleid=c.workroleid and workno=".$_SESSION['workno'];
$result = mysqli_query($link, $sql);
$dbarr = mysqli_fetch_array($result);
echo $dbarr['pname'].$dbarr['mname']."  ".$dbarr['lname']."<br>";
echo $dbarr['rolename'];
?></div>
	<div id="content">
		<a href="addmemberloanload.php"><?php echo$meml;?></a>
		<a href="loanpaymentload.php"><?php echo$pay;?></a>
		<a href="reportl.php"><?php echo $report;?></a> 
		<a href="/brcb/index.php"><?php echo $exit;?> </a></div>
<div id="tab">
<?php include('../config/config.php'); echo $foottext; 
		}
		?> 
</div>
</div>