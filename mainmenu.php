<meta charset="utf-8">
<link rel="stylesheet" href="config/css1.css" type="text/css" /> 
<title><?php include('config/config.php'); echo $programname;?> </title>

<div id="container">
<div id="header"><?php echo $programname." ".$version;?> </div>
	<div id="menu">ฝ่าย IT</div>
	<div id="content">
		<a href="/brcb/Funds/"> ระบบออมทรัพย์สัจจะ</a><br> 
		<a href="/brcb/Loan/">ระบบสินเชื่อ (เงินกู้)</a> <br>
		<a href="/brcb/Bank/"> ระบบธนาคารชุมชน </a><br>
		<a href="/brcb/Admin/">ระบบคณะกรรมการ</a><br>
		บันทึกการทำงาน<br>
		การตั้งค่า <br>
		ออกจากระบบ 
	</div>
	<div id="menu">ฝ่ายออมทรัพย์</div>
	<div id="content">
		<a href="Funds/showmembers.php">ระบบสมาชิก</a> <br>
		<a href="Funds/depositload.php">รายการฝาก</a> <br>
		<a href="Funds/withdrawalsload.php">รายการถอน</a> <br>
		<a href="Funds/accountcloseload.php">ปิดบัญชี </a> <br>
		ออกจากระบบ 
	</div>
	<div id="menu">ฝ่ายสินเชื่อ</div>
	<div id="content">
		<a href="loan/addmemberloanload.php">เปิดบัญชี</a><br> 
		<a href="loan/loanpaymentload.php">รายการชำระเงินกู้</a><br>
		ตรวจสอบการส่งกู้ <br>
		ออกจากระบบ 
	</div>
	<div id="menu">ฝ่ายธนาคาร</div>
	<div id="content">
		<a href="Bank/addbookbank.php">เปิดบัญชี</a> <br>
		<a href="Bank/depositload.php"> รายการฝาก</a> <br> 
		<a href="Bank/withdrawalsload.php">รายการถอน</a><br>		
		<a href="Bank/accountcloseload.php">ปิดบัญชี</a><br>
		ออกจากระบบ 
 	</div>
	<div id="menu">ฝ่ายอำนวยการ</div>
	<div id="content">
		พิมพ์รายงานสรุป <br>
		ออกจากระบบ 
	</div>

	
	
	
<div id="tab">
	<?php include('config/config.php');echo $foottext; ?> 
</div>

	</div>
