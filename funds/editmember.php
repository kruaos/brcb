<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php
// หน้า index ระบบสัจจะ  fund 
include('/library.php'); include('../config/config.php');
session_start();
// ชุดคำสั่ง ก๊อกมา เป็นการแก้ไขคำสั่งเตือนแบบ notice
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="f")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
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
$fundno=$_GET['fundno'];	
	
include('../config/config.php');
	$sql="SELECT * FROM memberfund where fundno=".$fundno;
	$query= mysqli_query($link,$sql);
	$result = mysqli_fetch_array($query);

?>
<div id="container">
<div id="header"><?php echo$title;?> : ตารางเพิ่ม </div>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div id="tab">
	<div id="menu">รหัสสมาชิก</div>
    <div id="content"><input type="text" name="fundno" value="<?php  echo sprintf('%04d',$fundno);?>" readonly ></div>
</div>	
<div id="tab">
	<div id="menu">คำนำหน้า</div>
    <div id="content">	
<?php  if ($result['pname']=='นาย'){
	$ckk1="checked";
}else if ($result['pname']=="นาง"){
	$ckk2="checked";
}else if ($result['pname']=="นางสาว"){
	$ckk3="checked";
}else if ($result['pname']=="ด.ช."){
	$ckk4="checked";
}else if ($result['pname']=="ด.ญ."){
	$ckk5="checked";
}else if ($result['pname']=="1"){
	$ckk6="checked";
	$ckk66=$result['pname'];
}else {
	$ckk=" ";
}?>
		<input type="radio" name="pname1" value="นาย" <?=$ckk1?>>นาย 
		<input type="radio" name="pname1" value="นาง" <?=$ckk2?>>นาง 
		<input type="radio" name="pname1" value="นางสาว"<?=$ckk3?>>นางสาว <br>
		<input type="radio" name="pname1" value="ด.ช."<?=$ckk4?>>ด.ช. 
		<input type="radio" name="pname1" value="ด.ญ."<?=$ckk5?>>ด.ญ. <br>
		<input type="radio" name="pname1" value="1"<?=$ckk6?>>อื่นๆ 
		<input type="text" name="pname2" value="<?=$ckk66?>">
	</div>
</div>
<div id="tab">
	<div id="menu">ชื่อ*</div>
    <div id="content"><input type="name" name="mname" value="<?=$result['mname']?>" ></div>
</div>	
<div id="tab">
	<div id="menu">สกุล*</div>
    <div id="content"><input type="text" name="lname" value="<?=$result['lname']?>"></div>
</div>	
<div id="tab">
	<div id="menu">รหัสบัตรประชาชน*</div>
    <div id="content"><input type="text" name="idcard" maxlength="13" value="<?=$result['idcard']?>"><span id='red'>* เลข 13 หลัก (ตัวเลขเท่านั้น)</span></div>
</div>	
<div id="tab">
	<div id="menu">ที่อยู่ *</div>
    <div id="content"><textarea name="address" id="textadd" ><?=$result['address']?></textarea></div>
</div>	
<div id="tab">
	<div id="menu">วันเกิด</div>
    <div id="content"><input type="text" name="birthday" id="dateInput" value="<?=$result['birthday']?>"></div>
</div>	
<div id="tab">
	<div id="menu">แบบสมาชิก</div>
    <div id="content">   			
		<input type="radio" name="typefunds" value="1" checked>สัจจะ + พชพ. 
		<input type="radio" name="typefunds" value="2">สัจจะ  </div>
</div>
<div id="tab">
	<div id="menu">วันที่สมัคร </div>
    <div id="content"><?php echo date("Y-m-d H:i:s");?></div>
</div>

<div id="tab">
        <button type="submit" name="send" id="btadd">
		<button type="submit" formaction="../funds/showmembers.php" id="btcan">

</div>
</form>
</div>

<?php 
//ส่วนการเพิ่มข้อมูล 
}
else {
include ('../config/config.php');
// ส่วนการตรวจสอบค่าว่าง ============== เริ่ม 
	$mname= $_POST['mname'];
	$lname= $_POST['lname'];
	$idcard= $_POST['idcard'];
	$address= $_POST['address'];
if ($mname==null or $lname==null or $idcard==null or $address==null){
	if ($mname==null or $lname==null){
		echo "<center><span class='h1'>ชื่อ หรือ นามสกุล  เป็นค่าว่าง กรอกใหม่</span><br><a href='/brcb/funds/addmember.php'>".$back."</a>";
	}else if (($idcard==null)or(!is_numeric($idcard))){
		echo "<center><span class='h1'>รหัสบัตรประชาชน  เป็นค่าว่างหรือเป็นตัวอักษร กรอกใหม่</span><br><a href='/brcb/funds/addmember.php'>".$back."</a>";
	}else{
		echo "<center><span class='h1'>ที่อยู่  เป็นค่าว่าง กรอกใหม่</span><br><a href='/brcb/funds/addmember.php'>".$back."</a>";
	}
}else{

// ส่วนการตรวจสอบค่าว่าง ============== หมด
	$fundno= $_POST['fundno'];
	$birthday= $_POST['birthday'];
	$typefunds= $_POST['typefunds'];
	$createdate=date("Y-m-d H:i:s");
	$lastupdate=date("Y-m-d H:i:s");
	$statusfunds=1;
if (($_POST['pname1']==1)){
		$pname = $_POST['pname2'];
}else{
		$pname = $_POST['pname1'];
	}	
/*---------- สำหรับตรวจสอบค่าว่าง --------------------------------*/
	
include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link, $sql);

	$sql = "update memberfund set
		fundno='$fundno',
		pname='$pname',mname='$mname',lname='$lname',
		idcard='$idcard',address='$address',
		birthday='$birthday',fundtypeid='$typefunds',
		lastupdate='$lastupdate'		
		where fundno=".$fundno;
	$result = mysqli_query($link, $sql);
	if ($result)
	{
		echo "<center><span class='h1'>บันทึกข้อมูลเรียบร้อย<br></span>";
		mysqli_close($link);
	}
	else
	{
		echo "<center><span class='h1'>ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br></span>";
	}
	echo "<a href=../funds/showmembers.php>$back</a><br>";
	}
		}
	}

?>