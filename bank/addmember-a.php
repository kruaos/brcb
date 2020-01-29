<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 

<?php
// หน้า index ระบบสัจจะ  fund 
include('library.php'); include('../config/config.php');
session_start();
// ชุดคำสั่ง ก๊อกมา เป็นการแก้ไขคำสั่งเตือนแบบ notice
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="f")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='../brcb/index.php'>$login</a> ";	
	}else if (!(($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง เฉพาะ ฝ่าย IT<br>"."<a href='../funds/showmembers.php'>$back</a> ";	
	}else{
		
?>
<html>
<head>
<meta charset=utf8>
<?/* จัดการ ปฏิทิน     เอามาจากส่วนนี้ http://goo.gl/93Tpgh */?>
<link rel="stylesheet" type="text/css" href="../config/jquery-ui-1.7.2.custom.css">  
<script type="text/javascript" src="../config/jquery-1.3.2.min.js"></script>  
<script type="text/javascript" src="../config/jquery-ui-1.7.2.custom.min.js"></script>  
<script type="text/javascript">  
$(function(){  
  $("#dateInput").datepicker({ dateFormat: 'dd-mm-yy' });  });  
</script>  
<?/* จัดการที่อยู่ ค่าว่าง เอามาจาก http://goo.gl/2Pa2FY */?>
<?php include('library.php');?>

<title><?php echo$title;?></title>
</head>
<body>
<?php
if (!isset($_POST['send'])) {

?>
<div id="container">
<div id="header"><?php echo$title;?> : ตารางเพิ่ม </div>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div id="tab">
	<div id="menu">รหัสสมาชิก</div>
    <div id="content"><input type="name" name="cbanktype" > ปี
	<input type="name" name="yy" value='57'></div>
</div>
<div id="tab">
	<div id="menu">ประเภทเงินฝาก</div>
    <div id="content">   			
		<input type="radio" name="banktype" value="1"checked >สะสมทรัพย<br>
		<input type="radio" name="banktype" value="2">ฝากประจำ 3 เดือน <br>
		<input type="radio" name="banktype" value="3">ฝากประจำ 6 เดือน  <br>
		<input type="radio" name="banktype" value="4">ฝากประจำ 12 เดือน <br>
</div>

<div id="tab">
	<div id="menu">คำนำหน้า</div>
    <div id="content">	  
		<input type="radio" name="pname1" value="นาย" checked>นาย 
		<input type="radio" name="pname1" value="นาง">นาง 
		<input type="radio" name="pname1" value="นางสาว">นางสาว <br>
		<input type="radio" name="pname1" value="ด.ช.">ด.ช. 
		<input type="radio" name="pname1" value="ด.ญ.">ด.ญ. <br>
		<input type="radio" name="pname1" value="1">อื่นๆ 
		<input type="text" name="pname2">
	</div>
</div>

<div id="tab">
	<div id="menu">ชื่อ*</div>
    <div id="content"><input type="name" name="mname" ></div>
</div>	
<div id="tab">
	<div id="menu">สกุล*</div>
    <div id="content"><input type="text" name="lname" ></div>
</div>	
<div id="tab">
	<div id="menu">รหัสบัตรประชาชน*</div>
    <div id="content"><input type="text" name="idcard" maxlength="13"><span id='red'>* เลข 13 หลัก (ตัวเลขเท่านั้น)</span></div>
</div>	
<div id="tab">
	<div id="menu">ที่อยู่ *</div>
    <div id="content"><textarea name="address" id="textadd"></textarea></div>
</div>
<div id="tab">
	<div id="menu">เบอร์โทรศัพท์ติดต่อ *</div>
    <div id="content"><input name="telephone" type="text"></textarea></div>
</div>	
<div id="tab">
	<div id="menu">วันเกิด</div>
    <div id="content"><input type="text" name="birthday" id="dateInput" ></div>
</div>	
<div id="tab">
	<div id="menu">เงื่อนไขการฝาก</div>
    <div id="content">
		<input type="radio" name="bankformat" value="1" checked>สำหรับตัวเอง<br>
		<input type="radio" name="bankformat" value="2">เพื่อ........ <br>
		<input type="radio" name="bankformat" value="3">นิติบุคคล<br>		
		<input type="radio" name="bankformat" value="4">และ/หรือ<br>
		<input type="text" name="bankformatdetail" >
	</div>
</div>	

<div id="tab">
	<div id="menu">วันที่สมัคร </div>
    <div id="content"><?php echo date("Y-m-d H:i:s");?></div>
</div>

<div id="tab">
        <button type="submit" name="send" id="btadd">
		<button type="submit" formaction="../bank/addmemberload.php" id="btcan">

</div>
</form>
</div>

<?php 
//ส่วนการเพิ่มข้อมูล 
}
else {
include ('../config/config.php');
// ส่วนการตรวจสอบค่าว่าง ============== เริ่ม 
// ปิดก่อนตรวจสอบค่าก่อน 11 ตุลา 58 ========= 
/*
	$mname= $_POST['mname'];
	$lname= $_POST['lname'];
	$idcard= $_POST['idcard'];
	$address= $_POST['address'];
	$telephone=$_POST['telephone'];
if ($mname==null or $lname==null or $idcard==null or $address==null){
	if ($mname==null or $lname==null){
		echo "<center><span class='h1'>ชื่อ หรือ นามสกุล  เป็นค่าว่าง กรอกใหม่</span><br><a href='/brcb/bank/addmember.php'>".$back."</a>";
	}else if (($idcard==null)or(!is_numeric($idcard))){
		echo "<center><span class='h1'>รหัสบัตรประชาชน  เป็นค่าว่างหรือเป็นตัวอักษร กรอกใหม่</span><br><a href='/brcb/bank/addmember.php'>".$back."</a>";
	}else if (($telephone==null)or(!is_numeric($telephone))){
		echo "<center><span class='h1'>เบอร์โทรศัพท์  เป็นค่าว่างหรือเป็นตัวอักษร กรอกใหม่</span><br><a href='/brcb/bank/addmember.php'>".$back."</a>";
	}else{
		echo "<center><span class='h1'>ที่อยู่  เป็นค่าว่าง กรอกใหม่</span><br><a href='/brcb/bank/addmember.php'>".$back."</a>";
	}
}else{
include('../config/config.php');
*/
	$sql="SELECT * FROM memberbank";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
if (($_POST['bankformat'])==1){
		$bankformatdetail="null";
		}else{
		$bankformatdetail=$_POST['bankformatdetail'];
	}
// ส่วนการตรวจสอบค่าว่าง ============== หมด
	$cbanktype=$_POST['cbanktype'];
	$mname= $_POST['mname'];
	$lname= $_POST['lname'];	
	$bankno= $numrows;
	$bankformat=$_POST['bankformat'];
	$workno=$_SESSION['workerid'];
	$birthday= $_POST['birthday'];
	$banktype= $_POST['banktype'];
	$createdate=date("Y-m-d H:i:s");
	$lastupdate=date("Y-m-d H:i:s");
	$bankstatus='op';
	$yy=$_POST['yy'];
//====ชุดคำสั่งนับจำนวนสมาชิกแต่ละประเภท =======================
/*
$sqlcbt="select count(bankno) as 'cbanktype' from memberbank where banktype=".$banktype;
$query=mysqli_query($link,$sqlcbt);
$sqlcbt=mysqli_fetch_array($query);
$cbanktype=$sqlcbt['cbanktype']+1;*/
//============================
	$bankid=sprintf('%02d',$banktype).$yy.sprintf('%04d',$cbanktype);
;
if (($_POST['pname1']==1)){
		$pname = $_POST['pname2'];
}else{
		$pname = $_POST['pname1'];
	}	
/*---------- สำหรับตรวจสอบค่าว่าง --------------------------------*/
include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link, $sql);
	$sql = "Insert into memberbank values(
		'$bankno','$bankid',
		'$pname','$mname','$lname',
		'$idcard','$address',
		'$telephone',
		'$birthday','$bankformat','$bankformatdetail','$banktype','$bankstatus',
		'$workno',
		'$createdate','$lastupdate'		
		);";
	$result = mysqli_query($link, $sql);
	if ($result)
	{
		echo "<center><span class='h1'>บันทึกข้อมูลเรียบร้อย<br></span>".$bankformatdetail.$bankformat;
		mysqli_close($link);
	}
	else
	{
		echo "<center><span class='h1'>ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br></span>";
	}
	echo "<a href=../bank/addmember-a.php>$back</a><br>";
	}
		}

?>