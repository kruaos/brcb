<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php 
session_start();
include('/library.php'); include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="f")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
?>
<meta charset=utf8>
<title>ระบบออมทรัพย์สัจจะ (รายการถอน)</title>
</head>
<?php 
$fundno=(int)$_GET['fundno'];
include('../config/config.php');
	$sql = "select * from memberfund where fundno =".$fundno;
	$result = mysqli_query($link, $sql);
	$dbarr = mysqli_fetch_array($result);
	if 	(($dbarr['fundno']==null)or($fundno==0)){
		if($fundno==0){
			echo "<center><span class='h1'>ข้อมูลไม่ถูกต้อง</span><br><a href='/brcb/funds/withdrawalsload.php'>".$back."</a>";
		}else{
			echo "<center><span class='h1'>ข้อมูลเป็นค่าว่าง</span><br><a href='/brcb/funds/withdrawalsload.php'>".$back."</a>";
		}
	}else if($dbarr['fundstatusid']<>1){	
			echo "<center><span class='h1'>สมาชิกรหัส ".sprintf('%04d',$fundno)." หมดสภาพความเป็นสมาชิก <br>กรุณากรอกข้อมูลใหม่</span><br><a href='/brcb/funds/withdrawalsload.php'>".$back."</a>";
	}else{

if (!isset($_GET['withdrawals'])){
include('../config/config.php');
	$sql="SELECT * FROM memberfund";
		$query= mysqli_query($link,$sql);
		$numrows= mysqli_num_rows($query);
	$sql = "select * from memberfund where fundno =$fundno";
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
?>
<form name="ถอนเงิน" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div id="container">
<div id="header">ตารางถอนเงินออมทรัพย์สัจจะ</div>
<div id="tab">
<?php $numrows;?>
	<div id="menu">รหัสสมาชิก</div>
	<div id="content"><input type="text" name="fundno" value="<?php echo sprintf('%04d',$fundno);?>" readonly/></div>
</div>
<div id="tab">
	<div id="menu">ชื่อ – สกุล</div>
	<div id="content"><?php echo $dbarr["pname"].$dbarr["mname"]."  ".$dbarr["lname"] ;?></div>
</div>
<div id="tab">
	<div id="menu">เงินคงเหลือ</div>
<?php 
include('../config/config.php');
	$sql="SELECT sum(recivefunds) as 'rfund' FROM eventfund where fundno = " . $fundno;
	$query = mysqli_query($link,$sql);
	$result=mysqli_fetch_array($query);	

?>
	<div id="content"><?php echo $result["rfund"] ;?> บาท</div>
</div>
<div id="tab">
	<div id="menu">จำนวนที่ถอน</div>
	<div id="content"><input type="text" name="withdrawals"  /> บาท</div>
<div id="tab">
	<div id="menu">ทำรายการวันที่ / เวลา</div>
	<div id="content"><?php echo date("Y-m-d H:i:s")?> 
	</div>
</div>
<div id="tab">
	<div id="bar1">
		<button type="submit" id="button">
		<button type="submit" formaction="../funds/withdrawalsload.php"/ id="button2">	</form>
		
	</div>
</div>
<div id='tab'>
<table  class="header" width="1000" align="center" >
<th colspan="10" > ข้อมูลการฝากเงินของ <?=$fullname; ?> </th>
<tr>
	<td class="c1">รหัสสมาชิก</td>
	<td class="c2">เงินสัจจะ</td>
	<td class="c1">เงิน พชพ</td>
	<td class="c2">รหัสเจ้าหน้าที่</td>
	<td class="c1">วันที่ฝาก</td>
	<td class="c2">ประเภท</td>
</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
include('../config/config.php');
// สูตร ค่อยทำแยกตามกรรมการ อ้างอิงตม sestion
	$sql="SELECT * FROM eventfund where fundno=".$fundno;
	$query=mysqli_query($link,$sql);
	//ใช้ numrows ในการนับแถว
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		
	$sql1="SELECT a.*,b.* FROM eventfund a , evcode b where a.code = b.codeid and num = " .$result['num'];
	$query1 = mysqli_query($link,$sql1);
	$dbarr=mysqli_fetch_array($query1);			
?> 
<tr>
	<td class="c1"><?=sprintf("%04d",$result["fundno"]);?></td>
	<td class="c2"><?=$result["recivefunds"];?></td>
	<td class="c1"><?=$result["reciveinsurance"];?></td>
	<td class="c2"><?=sprintf("%04d",$result["workerid"]);?></td>
	<td class="c1"><?=$result["createdate"];?></td>
	<td class="c2"><?=$dbarr["codename"];?></td>
</tr>
</div>
</div>

		<?php }
//ส่วนการเพิ่มข้อมูล 
}else{
$fundno=(int)$_GET['fundno'];
	include('../config/config.php');
	$sql="SELECT sum(recivefunds) as 'rfund' FROM eventfund where fundno = $fundno" ;
	$query = mysqli_query($link,$sql);
	$result=mysqli_fetch_array($query);	
$withdrawals=(int)$_GET['withdrawals'];		
	if 	(($withdrawals==null)or($withdrawals==0)){
			echo "<center><span class='h1'>ข้อมูลการถอนไม่ใช่ตัวเลข หรือ เป็นค่าว่าง <br><a href='../funds/withdrawals.php? fundno=$fundno'>$back</a> ";	
	}else if (($result["rfund"]-$withdrawals<0)){	
			echo "<center><span class='h1'>จำนวนที่ต้องการถอน เกินยอดเงินคงเหลือ <br>กรุณากรอกจำนวนที่จะถอนใหม่ไม่เกิน ".$result["rfund"]."  บาท<br><a href='../funds/withdrawals.php? fundno=$fundno'>$back</a>";
	}else{
$recivefunds = -$withdrawals;
$code="wi";
$workrid=$_SESSION['workno'];
$createdate=date("Y-m-d H:i:s");
$reciveinsurance=0;
include('../config/config.php');
	$sql="SELECT * FROM eventfund";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
	mysqli_close($link);	
	$num=$numrows+1;
include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link, $sql);
	$sql = "Insert into eventfund values(
		'$num',
		'$fundno','$recivefunds','$reciveinsurance',
		'$workrid','$createdate','$code'
		)";
	$result = mysqli_query($link, $sql);
	if($result){
		echo "<center><span class='h1'>บันทึกข้อมูลลงในฐานข้อมูลประสบความสำเร็จ<br></span>";
		mysqli_close($link);
		}else{
		echo "<center><span class='h1'>ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br></span>";
		}
	echo "<a href=../funds/withdrawalsload.php>$back</a><br>";
	}
	}
		}}
?>