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
			// เริ่มรับค่า การถอนถอน 
?>
<title>ถอนเงินธนาคารชุมชน</title>
<div id="container">
<div id="header">ระบบถอนเงินธนาคาร</div>
<form name='ถอนเงินธนาคารชุมชน'>
<div id="tab">
	<div id="menu">เลขบัญชี</div>
	<div id="content"><input type="text" name="bankid"></div>
</div>
<div id="tab">
<button type="submit"id="btfind">
<button formaction='../bank/' id="btback"></form>
</div>
</div>
<?php 

}else if($_GET['withdrawal']==null){
/*
การถอน เพื่อแยก
>> ส่วนต่อจากนี้จะมีการต้องคัดกรอง ตัวเลข หากมี 6 ตัว ต้องจัดสรร แบบหนึ่ง หากมา 8 ตัว ต้องจัดสรร อีกแบบหนึ่ง  


*/
$dep1=substr($_GET['bankid'],0,2);
$dep2=substr($_GET['bankid'],2,4);	
include('../config/config.php');
	$sql="select * from memberbank  where bankid like '".$dep1."%%".$dep2."'";
	$query= mysqli_query($link,$sql);		
	$result=mysqli_fetch_array($query);
	if(($result['bankid']==null)or($_GET['bankid']==0)){
		echo "รหัสไม่ถูกต้อง กรุณากรอกรหัสใหม่ <br> <a href='../bank/deposit.php'>$back</a>";
	}else{	
	
?>
<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title>ถอนเงินธนาคารชุมชน</title>
<div id="container">
<div id="header">ระบบถอนเงินธนาคาร</div>
<form name='ถอนเงินธนาคารชุมชน'>
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
	echo $fullnamen=$resultn['pname'].$resultn['mname']."  ".$resultn['lname'];
	
?></div>
</div>
<div id="tab">
	<div id="menu">จำนวนเงินคงเหลือ </div>
	<div id="content"><?php 
	$sql="select sum(income) as 'sincom' from eventbank where bankid like '".$result['bankid']."'";
	$query= mysqli_query($link,$sql);		
	$resultn=mysqli_fetch_array($query);
	echo $sincom=$resultn['sincom'];?> บาท</div>
</div>
<div id="tab">
	<div id="menu">ยอดถอน</div>
	<div id="content"><input type="text" name="withdrawal"></div>
</div>
<div id="tab">
	<div id="menu">วัน / เวลา ทำรายการ</div>
	<div id="content"><?php echo date('Y-m-d h:m:s')?></div>
</div>
<div id="tab">
<button type='submit' id='button' name='sincom' value='<?=$sincom?>'>
<?php if($_SESSION['workroleid']==i or $_SESSION['workroleid']==a){$back="admin";}else{$back="bank";}						?>
<button type='submit' formaction='../<?=$back?>/' id='btback' >
</form>
</div>
<div id="tab" >

<table width='1000'>
<tr>
	<td>เลขบัญชี</td>
	<td>งวดที่</td>
	<td>วันที่ทำรายการ</td>
	<td>รายการฝาก</td>
	<td>รายการถอน</td>
	<td>คงเหลือ</td>
	<td> สถานะ</td>
</tr>
<?php 
include('../config/config.php');
	$sql="select * from eventbank where bankid ='".$result['bankid']."' order by createdate";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		$code=$result['code'];
?>
<tr>
	<td><?=$result['bankid']?></td>
	<td><?php echo $result['num'];?></td>
	<td><?php echo $result['deptime'];?></td>
	<td><?php if ($code=='de'){echo $result['income'];}else{echo "-";} ?></td>
	<td><?php if ($code=='wi'){echo $result['income'];}else{echo "-";} ?></td>		
	<td><?php echo $balance= $balance+$result['income'];?></td>
	<td><?=$result['code']?></td>
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
// ตัดส่วนเกินออก
$sincom=$_GET['sincom'];
$code="wi";	
$bankid=$_GET['bankid'];
$income-=$_GET['withdrawal'];
	if(($sincom+$income)<0){
		$bankid=substr($_GET['bankid'],0,2).substr($_GET['bankid'],4,4);
		echo "<center><span class='h1'>ยอดการถอนไม่ถูกต้อง <br>ท่านถอนได้ไม่เกิน ".$sincom."<br><a href='../bank/withdrawals.php?bankid=$bankid'>$back</a></span>";
	}else{
include('../config/config.php');
	$sql="SELECT * FROM eventbank";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
	mysqli_close($link);	
	$num=$numrows+1;	
$workno=$_SESSION['workno'];
$createdate=date("Y-m-d H:i:s");	
include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link, $sql);
	$sql = "Insert into eventbank values(
		'$num',
		'$bankid','$workno',
		'$income','$code',
		'$createdate'
		)";
	$sql2="update memberbank set lastupdate='$createdate' where bankid ='$bankid'";
	$result2 = mysqli_query($link, $sql2);		
	$result = mysqli_query($link, $sql);
	if($result)	{
		echo "<center><span class='h1'>รวมยอดถอนทั้งสิ้น  ".number_format(($payment+$income),2,'.',',')." บาท  <br>บันทึกข้อมูลสำเร็จ<br>";
		mysqli_close($link);
	}	else	{
		echo "<center><span class='h1'>ไม่สามารถบันทึกข้อมูลใหม่ลงในฐานข้อมูลได้<br>";
	}
	echo "<a href=../bank/withdrawals.php>$back</a><br>";
		  }
		}
	}
		?>