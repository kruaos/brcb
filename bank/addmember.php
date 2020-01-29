<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../config/css/bootstrap.min.css">
  <script src="../config/js/jquery.min.js"></script>
  <script src="../config/js/bootstrap.min.js"></script>
<?php
// หน้า index ระบบสัจจะ  fund 
include('library.php'); include('../config/config.php');
session_start();
// ชุดคำสั่ง ก๊อกมา เป็นการแก้ไขคำสั่งเตือนแบบ notice
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="b")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>1ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='../brcb/index.php'>$login</a> ";	
	}else if (!(($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i")or($_SESSION['workroleid']=="b"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง เฉพาะ ฝ่าย IT<br>"."<a href='../funds/showmembers.php'>$back</a> ";	
	}else{
		
?>
<html>
<head>
<meta charset=utf8>
<?php include('library.php');?>
<title><?php echo$title;?></title>
</head>
<body>
<?php
if (!isset($_POST['send'])) {

?>
<div id="container">
<div id="header"><b><?php echo$title;?> : ตารางเพิ่ม สมาชิก </b></div>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div id="tab">
	<div id="menu">1. รหัสสมาชิก</div>
    <div id="content"><input type="name" name="bankid" ></div>
</div>
<div id="tab">
	<div id="menu">2. คำนำหน้า</div>
    <div id="content">	
    <div id="content"><input type="text" name="pname" >*ด.ช. ด.ญ. นาย นาง นางสาว ฯลฯ</div>
</div>

<div id="tab">
	<div id="menu">3. ผู้เปิดบัญชี</div>
    <div id="content">ชื่อ<input type="text" name="mname" >สกุล<input type="text" name="lname" ></div>    <div id="content"></div>
</div>	

<div id="tab">
	<div id="menu">5. เบอร์โทรศัพท์ติดต่อ </div>
    <div id="content"><input type="text" name="telephone"></div>
</div>	
<div id="tab">
	<div id="menu">6. ชื่อบัญชี</div>
    <div id="content"><input type="text" name="bankname" >* ชื่อบัญชีที่ต้องการใช้</div>
</div>	
<div id="tab">
	<div id="menu">7. วันที่สมัคร </div>
    <div id="content"><?php echo date("Y-m-d H:i:s");?></div>
</div>
<div id="tab">
	<div id="menu">8. ยอดยกมา </div>
    <div id="content"><input type="text" name="bl" > บาท</div>
</div>

<div id="tab">
        <button type="submit" name="send" id="btadd">
		<button type="submit" formaction="../bank/deposit.php" id="btcan">

</div>
</form>
</div>

<?php 
//ส่วนการเพิ่มข้อมูล 
}else{
include ('../config/config.php');
	$sql="SELECT * FROM memberbank";
	$query= mysqli_query($link,$sql);
	$bankno= mysqli_num_rows($query);
	$bankid= $_POST['bankid'];
	$pname= $_POST['pname'];
	$mname= $_POST['mname'];
	$lname= $_POST['lname'];
	$bankname= $_POST['bankname'];	
	$telephone= $_POST['telephone'];
	$workno=$_SESSION['workerid'];
	$createdate=date("Y-m-d H:i:s");
	$lastupdate=date("Y-m-d H:i:s");
	$bankstatus='op';
include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$sql = "Insert into memberbank 
		(`bankno`, `bankid`, 
		`pname`, `mname`, `lname`, 
		`telephone`,`bankstatus`,`bankname`, 
		`workno`, `createdate`, `lastupdate`) 
		values(
		'$bankno','$bankid',
		'$pname','$mname','$lname',
		'$telephone','$bankstatus','$bankname',
		'$workno','$createdate','$lastupdate'		
		);";
	$result = mysqli_query($link, $sql);
if($_POST['bl']=0 or $_POST['bl']=null){
	$bookbankbalance='0';
}else{
	$bookbankbalance=$_POST['bl'];
}
	$sql2 = "Insert into bookbankbalance2 
		(`bankid`, `bookbankbalance`,`lastupdate`) 
		values(
		'$bankid','$bookbankbalance','$lastupdate'		
		);";
	$result2 = mysqli_query($link, $sql2);
	if ($result)
	{
		echo "<center><span class='h1'>บันทึกข้อมูลเรียบร้อย<br></span>".$bankformatdetail.$bankformat;
		mysqli_close($link);
		header('location:deposit.php');
		exit(0);
	}
	else
	{
		echo $sql;
		echo "<center><span class='h1'>ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br></span>";
		echo "<a href=../bank/addmember.php>$back</a><br>";
		
	}

	}
		}

?>