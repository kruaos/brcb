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
<title>ระบบออมทรัพย์สัจจะ (รายการฝาก)</title>
<?php 
$fundno = $_POST['fundno'];
include('../config/config.php');
	$sql = "select * from memberfund where fundno = '$fundno';";
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
	if 	((!(is_numeric($fundno)))or($dbarr['fundno']==null)){
			echo "<center><span class='h1'>พิมพ์รหัสสมาชิกไม่ถูกต้อง</span><br><a href='/brcb/funds/depositload.php'>".$back."</a>";
	}else if($dbarr['fundstatusid']<>1){	
			echo "<center><span class='h1'>สมาชิกรหัส ".sprintf('%04d',$fundno)." หมดสภาพความเป็นสมาชิก <br>กรุณากรอกข้อมูลใหม่</span><br><a href='/brcb/funds/depositload.php'>".$back."</a>";
	
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
<form name="ฝากเงิน" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div id="container">
<div id="header">ตารางฝากเงินออมทรัพย์สัจจะ</div>
<div id="tab"><?php $numrows;?>
	<div id="menu">รหัสสมาชิก</div>
	<div id="content"><input type="text" name="fundno" value="<?php echo sprintf('%04d',$fundno);?>" readonly/></div>
</div>
<div id="tab">
	<div id="menu">ชื่อ – สกุล</div>
	<div id="content"><?php echo $fullname=$dbarr["pname"].$dbarr["mname"]."  ".$dbarr["lname"] ;?></div>
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
	<div id="menu">จำนวนที่ฝาก</div>
	<div id="content">        
	<input name="deposit" type="radio" value="1" checked >        สัจจะ 30 บาท พชพ 5        บาท
    <input name="deposit" type="radio" value="2" />        สัจจะ 30 บาท พชพ 10 บาท
    <input name="deposit" type="radio" value="3" />        สัสจะ 30 บาท พชพ 15 บาท 
	</div>
</div>	
<div id="tab">
	<div id="menu">ทำรายการวันที่ / เวลา</div>
	<div id="content">        
	<?php echo date("Y-m-d H:i:s");?>  
	</div>
</div>


<div id="tab">
	<div id="bar1">
		<input type="submit" value=" " name="send2" id="button">
		<button type="submit" formaction="../funds/depositload.php"/ id="button2">
	</form><br>
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
	if ($dbarr['code']=='wi'){	$code="red";}else{$code="black";}
	
?> 
<tr>
	<td class="c1"><font color="<?=$code;?>"><?=sprintf("%04d",$result["fundno"]);?></font></td>
	<td class="c2"><font color="<?=$code;?>"><?=$result["recivefunds"];?></font></td>
	<td class="c1"><font color="<?=$code;?>"><?=$result["reciveinsurance"];?></font></td>
	<td class="c2"><font color="<?=$code;?>"><?=sprintf("%04d",$result["workerid"]);?></font></td>
	<td class="c1"><font color="<?=$code;?>"><?=$result["createdate"];?></font></td>
	<td class="c2"><font color="<?=$code;?>"><?=$dbarr["codename"];?></font></td>

</tr>

</div>
</div>

		<?php }
//ส่วนการเพิ่มข้อมูล 
}else{

	$fundno= $_POST['fundno'];
	$code="de";

// ตรงนี้ รอแบ่ง session แล้วค่อย แยก กรรมการ 
	$workrid=$_SESSION['workno'];
	$createdate=date("Y-m-d H:i:s");
	$recivefunds = 30;	
//	$num=1;
include('../config/config.php');
	$sql="SELECT * FROM eventfund";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
mysqli_close($link);	
	$num=$numrows+1;
		if ($_POST['deposit']==1){
			$reciveinsurance=5;
		}else if($_POST['deposit']==2) {
			$reciveinsurance=10;
		}else {
			$reciveinsurance=15;
		}	

include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link, $sql);
	$sql = "Insert into eventfund values(
		'$num',
		'$fundno','$recivefunds','$reciveinsurance',
		'$workrid','$createdate','$code'
		)";
	$result = mysqli_query($link, $sql);
	if($result)	{
		echo "<center><span class='h1'>บันทึกข้อมูลลงในฐานข้อมูลประสบความสำเร็จ<br></span>";
		mysqli_close($link);
	}	else	{
		echo "<center><span class='h1'>ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br></span>";
	}
	echo "<a href=../funds/depositload.php>$back</a><br>";

}
		}}
?>