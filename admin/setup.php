<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php 
session_start();
include('library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
?>
<div id='container'>
<div id='header'>เงื่อนไขต่างๆ </div>
<div id='tab'>
	<div id='menu'>ระบบสัจจะ</div>
	<div id='content'>- </div>
</div>
<div id='tab'>
	<div id='menu'>ระบบเงินกู้</div>
	<div id='content'>- ขาดส่งเงินต้น เกิน 3 เดือน ปรับดอกเป็น 1.5</div>
</div>
<div id='tab'>
	<div id='menu'>ระบบธนาคาร</div>
	<div id='content'>- </div>
</div>
<div id='tabb'><a href='../admin/'><?=$back?></a>
</div>
</div>
<?php 
		}

?>