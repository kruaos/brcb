<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" />
<?php
session_start();
include('library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="b")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='../brcb/index.php'>$login</a> ";
		}else{
		if($_GET['bankid']==null){
?>
<title>ฝากเงินธนาคารชุมชน</title>
<div id="container">
<div id="header">ระบบฝากเงินธนาคาร</div>
<form name='ฝากเงินธนาคารชุมชน'>
<div id="tab">
	<div id="menu">เลขบัญชี</div>
	<div id="content"><input type="text" name="bankid"></div>
</div>
<div id="tab">
<button type="submit"id="btfind"><button formaction='../bank/' id="btback"></form>

</div>
</div>
<?php
}else if($_GET['deposit']==null){
include('../config/config.php');
	$sql="select * from memberbank  where bankid like '".$_GET['deposit']."'";
	$query= mysqli_query($link,$sql);
	$result=mysqli_fetch_array($query);
	if(($result['bankid']==null)or($_GET['bankid']==0)){
		echo "รหัสไม่ถูกต้อง กรุณากรอกรหัสใหม่ <br> <a href='../bank/deposit.php'>$back</a>";
	}else{
?>
<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" />


<title>ฝากเงินธนาคารชุมชน</title>
<div id="container">

<div id="header">ระบบฝากเงินธนาคาร</div>

<form name='ฝากเงินธนาคารชุมชน'>
<div id="tab">
	<div id="menu">เลขบัญชี</div>
	<div id="content"><input type="text" name="bankid" value="<?=$result['bankid']?>" readonly></div>
</div>
<div id="tab">
	<div id="menu">ชื่อ - สกุล </div>
	<div id="content">
<?php
include('../config/config.php');
	$sql="select bankid,pname,mname,lname from memberbank  where bankid like '".$result['bankid']."'";
	$query= mysqli_query($link,$sql);
	$resultn=mysqli_fetch_array($query);
	echo $fullname=$resultn['pname'].$resultn['mname']."  ".$resultn['lname'];

?></div>
</div>
<div id="tab">
	<div id="menu">จำนวนเงินคงเหลือ </div>
	<div id="content"><?php
	$sql="select sum(income) as 'sincom' from eventbank where bankid like '".$result['bankid']."'";
	$query= mysqli_query($link,$sql);
	$resultn=mysqli_fetch_array($query);
	echo $resultn['sincom']?> บาท</div>
</div>
<div id="tab">
	<div id="menu">ยอดฝาก</div>
	<div id="content"><input type="text" name="deposit"></div>
</div>
<div id="tab">
	<div id="menu">วัน / เวลา ทำรายการ</div>
	<div id="content"><?php echo date('Y-m-d h:m:s')?></div>
</div>
<div id="tab">
<button type='submit' id='button'>
<?php if($_SESSION['workroleid']==i or $_SESSION['workroleid']==a){$back="admin";}else{$back="bank";}						?>
<button type='submit' formaction='../<?=$back?>/' id='btback'>
</form>
</div>
<div id="tab" >

<table width='1000'>
<tr>
	<td class="c4"><b>เลขบัญชี</td>
	<td class="c4"><b>วันที่ทำรายการ</td>
	<td class="c4"><b>รายการฝาก</td>
	<td class="c4"><b>รายการถอน</td>
	<td class="c4"><b>คงเหลือ</td>
	<td class="c4"><b> สถานะ</td>
</tr>
<?php
include('../config/config.php');
	$sql="select * from eventbank where bankid ='".$result['bankid']."'";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);
		$code=$result['code'];
?>
<tr>
	<td class="c1"><?=$result['bankid']?></td>
	<td class="c2"><?php echo $result['deptime'];?></td>
	<td class="c1"><?php if ($code=='de'){echo $result['income'];}else{echo "-";} ?></td>
	<td class="c2"><?php if ($code=='wi'){echo $result['income'];}else{echo "-";} ?></td>
	<td class="c1"><?php echo $balance= $balance+$result['income'];?></td>
	<td class="c2"><?=$result['code']?></td>
</tr>
<?php
		}
	}
		?>
</table>
	</div>
	</div>
<?php
}else{
$code="de";
$bankid=$_GET['bankid'];
$income=$_GET['deposit'];
	include('../config/config.php');// เพื่อเพิ่ม รหัสสมาชิก
	$sql="SELECT * FROM eventbank";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
	mysqli_close($link);
$num=$numrows+1;
$workno=$_SESSION['workno'];
$createdate=date("Y-m-d H:i:s");
$deptime=date("d")."/".date("m")."/".(date("y")+43);
$time=1;
include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link, $sql);
	$sql = "Insert into eventbank values(
		'$num',
		'$bankid','$workno',
		'$income','$code',
		'$createdate',
		'$deptime','$time'
		)";
	$result = mysqli_query($link, $sql);
	if($result)	{
		echo "<center><span class='h1'>รวมรับเงินทั้งสิ้น ".number_format(($payment+$income),2,'.',',')." บาท  <br>บันทึกข้อมูลสำเร็จ<br>";
		mysqli_close($link);
	}	else	{
		echo "<center><span class='h1'>ไม่สามารถบันทึกข้อมูลใหม่ลงในฐานข้อมูลได้<br>";
	}
	echo "<a href=../bank/deposit.php>$back</a><br>";
		  }
}

		?>
