<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php
	error_reporting( error_reporting() & ~E_NOTICE );
// หน้า index ระบบสัจจะ  fund 
include('library.php'); include('../config/config.php');
session_start();
// ชุดคำสั่ง ก๊อกมา เป็นการแก้ไขคำสั่งเตือนแบบ notice
	if (!(($_SESSION['workroleid']=="b")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='../brcb/index.php'>$login</a> ";	
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
$bankid=$_GET['bankid'];

if (!isset($_POST['send'])) {
include ('../config/config.php');
	$sql="select * from memberbank where bankid=".$bankid;
	$query= mysqli_query($link,$sql);		
	$result=mysqli_fetch_array($query);
?>
<div id="container">
<div id="header"><?php echo$title;?> : ตารางเพิ่ม </div>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div id="tab">
	<div id="menu">1. เลขบัญชี</div>
    <div id="content"><input type="name" name="bankid" value="<?php echo $result['bankid'];?>"></div>
</div>
<div id="tab">
	<div id="menu">2. ชื่อบัญชี</div>
    <div id="content"><input type="text" name="bankname"value="<?php echo $result['bankname'];?>">* ชื่อบัญชีที่ต้องการใช้</div>
</div>	
<div id="tab">
	<div id="menu">ข้อมูลเจ้าของบัญชี</div>
	<div id="content">..</div>
</div>
<div id="tab">
	<div id="menu">3. คำนำหน้า</div>
        <div id="content"><input type="text" name="pname"value="<?php echo $result['pname'];?>" >*ด.ช. ด.ญ. นาย นาง นางสาว ฯลฯ</div>


<div id="tab">
	<div id="menu">4. </div>
    <div id="content">ชื่อ<input type="text" name="mname"value="<?php echo $result['mname'];?>" >
	สกุล<input type="text" name="lname" value="<?php echo $result['lname'];?>"></div>    
</div>	

<div id="tab">
	<div id="menu">5. เบอร์โทรศัพท์ติดต่อ </div>
    <div id="content"><input type="text" name="telephone"value="<?php echo $result['telephone'];?>"></div>
</div>	
<div id="tab">
	<div id="menu">6. ยอดยกมา </div>
    <div id="content"><input type="text" name="bl" value="<?php 
		$sql2="select * from bookbankbalance2 where bankid=".$bankid;
		$query2= mysqli_query($link,$sql2)or die ("Error Query [".$sql2."]");		
		$result2=mysqli_fetch_array($query2);
	
	
	
	echo $result2['bookbalance'];?>"> บาท</div>
</div>

<div id="tab">
        <button type="submit" name="send" id="btsave">
		<button type="submit" formaction="../bank/deposit.php?bankid=<?=$bankid;?>" id="btcan">

</div>
</form>
</div>

<?php 
/*
เปลี่ยนเป็นการ update ข้อมูล เนื่องจากเป็ฯการแก้ไข 
*/
}
else {
$mname=$_POST['mname'];
$lname=$_POST['lname'];
$telephone=$_POST['telephone'];
$lastupdate=date('Y-m-d H:m:s');
$bankid=$_POST['bankid'];
$pname = $_POST['pname'];
$bankname=$_POST['bankname'];
	include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$sql = "update memberbank set
		pname='$pname',	mname='$mname',lname='$lname',
		bankname='$bankname',
		telephone='$telephone',
		lastupdate='$lastupdate'
		where bankid=".$bankid;
	$result = mysqli_query($link, $sql);
	if ($result){
		echo "<center><span class='h1'>บันทึกข้อมูลเรียบร้อย<br></span>";
		mysqli_close($link);
	}else{
		echo "<center><span class='h1'>ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br></span>";
	}
	echo "<a href=../bank/deposit.php?bankid=".$bankid.">$back</a><br>";
	}
		}

?>