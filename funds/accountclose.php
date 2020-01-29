<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php 
session_start();
include('/library.php'); 
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="f")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
?>

<meta charset=utf8>
<title>ตารางปิดบัญชี ออมทรัพย์สัจจะ</title>
<?php 
$fundno = $_POST['fundno'];
include('../config/config.php');
	$sql = "select * from memberfund where fundno = '$fundno';";
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
	if 	((!(is_numeric($fundno)))or($dbarr['fundno']==null)){
			echo "<center><span class='h1'>พิมพ์รหัสสมาชิกไม่ถูกต้อง</span><br><a href='/brcb/funds/accountcloseload.php'>".$back."</a>";
	}else if($dbarr['fundstatusid']<>1){	
			echo "<center><span class='h1'>สมาชิกรหัส ".sprintf('%04d',$fundno)." หมดสภาพความเป็นสมาชิก <br>กรุณากรอกข้อมูลใหม่</span><br><a href='/brcb/funds/accountcloseload.php'>".$back."</a>";
	}else{

if (!isset($_POST['send2'])){
	$fundno = $_POST['fundno'];
include('../config/config.php');
	$sql="SELECT * FROM memberfund";
		$query= mysqli_query($link,$sql);
		$numrows= mysqli_num_rows($query);
		$result = mysqli_query($link, $sql);
	$sql = "select * from memberfund where fundno = '$fundno';";
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
?>
<form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div id="container">
<div id="header">ตารางปิดบัญชี </div>
<div id="tab">
<?php $numrows;?>
	<div id="menu">รหัสสมาชิก</div>
	<div id="content"><input type="text" name="fundno" value="<?php echo sprintf('%04d',$fundno);?>" readonly /></div>
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
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
			$result=mysqli_fetch_array($query);	
		}
?>
	<div id="content"><?php echo $result["rfund"] ;?> บาท</div>
</div>
<div id="tab">
	<div id="menu">การปิดบัญชี</div>
	<div id="content">        
	<input name="statusfunds" type="radio" value="3" checked >   ลาออก <br />
    <input name="statusfunds" type="radio" value="4" />       เสียชีวิต <br /></div>
</div>
<div id="tab">
	<div id="menu">ทำรายการวันที่ / เวลา</div>
	<div id="content"><?php echo date("Y-m-d H:i:s")?> 
	</div>
</div>
<div id="tab">
	<div id="menu"> สาเหตุ </div>
	<div id="content"><input type="text" name="takenote"/></div>
</div>
<div id="tab">
		<button type="submit" value=" " name="send2" id="button">
		<button type="submit" formaction="../funds/accountcloseload.php"/ id="button2">	</form>
</form>
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


<?php 
//ส่วนการเพิ่มข้อมูล 


		}
}else{	$fundno= $_POST['fundno'];
	$lastupdate=date("Y-m-d H:i:s");
	$takenote=$_POST['takenote'];
	$fundstatusid=$_POST['statusfunds'];
include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$sql = "update memberfund set lastupdate='$lastupdate',fundstatusid ='$fundstatusid' 
	WHERE fundno='$fundno'";
	$result = mysqli_query($link, $sql);
	if($result)	{
		echo "การเพิ่มข้อมูลลงในฐานข้อมูลประสบความสำเร็จ<br>";
		mysqli_close($link);
	}	else	{
		echo "ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br>";
	}
	echo "<a href=../funds/accountcloseload.php>กลับหน้าเว็บการเพิ่มข้อมูล</a><br>";
	echo "<a href=../funds/>กลับหน้าเว็บหลัก</a><br>";
}
		}}
?>


