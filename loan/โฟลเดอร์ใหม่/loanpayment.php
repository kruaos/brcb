<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title>ระบบสินเชื่อ(คืนเงินกู้)</title>
<?php 
	$loanno = $_POST['loanno'];
include('../config/config.php');
	$sql = "select * from memberloan where loanno = '$loanno'";
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
	if 	((!(is_numeric($loanno)))or($dbarr['loanno']=="")){
			echo "รหัสไม่ถูกต้อง<br><input name='btnButton' type='button' value='ย้อนกลับ' onClick='JavaScript:history.back();'>";
	}else{



if (!isset($_POST['send2'])){
	$loanno = $_POST['loanno'];
include('../config/config.php');
	$sql="SELECT * FROM memberloan";
		$query= mysqli_query($link,$sql);
		$numrows= mysqli_num_rows($query);
		$result = mysqli_query($link, $sql);
	$sql = "select * from memberloan where loanno = '$loanno'";
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
?>
<form name="คืนเงินกู้" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div id="container">
<div id="header">ระบบสินเชื่อ(คืนเงินกู้)</div>
<div id="tab">
<?php $numrows;?>
	<div id="menu">รหัสสมาชิก</div>
	<div id="content"><input type="text" name="loanno" value="<?php echo $loanno;?>" readonly /></div>
</div>
<div id="tab">
	<div id="menu">ชื่อ – สกุล</div>
	<div id="content">
	<?php 
include('../config/config.php');
		$sql = "select a.*,b.name ,b.lname ,b.prename ,b.fundno 
		from memberloan a,memberfund b 
		where a.fundno=b.fundno and loanno = '$loanno'";
		$query=mysqli_query($link,$sql);
		$rname=mysqli_fetch_array($query);	
		echo $rname["prename"].$rname["name"]."  ".$rname["lname"] ;?></div>
</div>
<div id="tab">
	<div id="menu">เงินคงเหลือ</div>
<?php 
include('../config/config.php');

	$sql="SELECT sum(payment) as 'rloan' FROM eventloan where loanno = " . $loanno;
	$query = mysqli_query($link,$sql);
	$rpay=mysqli_fetch_array($query);
	
	$sql="SELECT count(payment) as 'cpay' FROM eventloan where loanno = " . $loanno;
	$query = mysqli_query($link,$sql);
	$cpay=mysqli_fetch_array($query);
		
	$amount=$rname['principle']-$rpay['rloan'];
?>
	<div id="content"><?php echo $amount ;?> บาท</div>
</div>
<div id="tab">
	<div id="menu">งวดที่ </div>
	<div id="content"><?php echo $cpay['cpay']."/".$rname['timeloan']; ?></div>
</div>
<div id="tab">
	<div id="menu">ชำระเงินต้น</div>
	<div id="content"><input type="text" name="payment" value="<?php echo ($rname['principle']/$rname['timeloan']);?> " /> บาท</div>
<div id="tab">
	<div id="menu">ชำระดอกเบี้ย</div>
	<div id="content"><input type="text" name="reciveinterest" value="<?php echo($amount*($rname['interestloan']/100));?>" /> บาท</div>
<div id="tab">
	<div id="menu">รวมเป็นเงิน </div>
	<div id="content"><?php echo ($rname['principle']/$rname['timeloan'])+($amount*($rname['interestloan']/100))."  บาท";?></div>
</div>
<div id="tab">
	<div id="menu">ทำรายการวันที่ / เวลา</div>
	<div id="content">        
	<input type="text" value="<?php echo date("Y-m-d H:i:s")?>">   
	</div>
</div>
	<div id="tab">
	<div id="bar1">
		<input type="submit" name="send2" value="ทำรายการ" />
	</form>

    <input type="reset" name="reset" value="ล้างข้อมูล" />
	<br><a href="../loan/">ย้อนกลับเมูนย่อย </a>
</div>
</div>
</div>

<?php 
//ส่วนการเพิ่มข้อมูล 
}else{
	$loanno= $_POST['loanno'];
	$payment= $_POST['payment'];
	$reciveinterest= $_POST['reciveinterest'];

// ตรงนี้ รอแบ่ง session แล้วค่อย แยก กรรมการ 
	$workrid=1;
	$createdate=date("Y-m-d H:i:s");

	//	$num=1;
include('../config/config.php');
	$sql="SELECT * FROM eventloan";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
	mysqli_close($link);	
	$num=$numrows+1;
			

include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link, $sql);
	$sql = "Insert into eventloan values(
		'$num',
		'$loanno','$workrid',
		'$payment','$reciveinterest',
		'$createdate'
		)";
	$result = mysqli_query($link, $sql);
	if($result)	{
		echo "การเพิ่มข้อมูลลงในฐานข้อมูลประสบความสำเร็จ<br>";
		mysqli_close($link);
	}	else	{
		echo "ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br>";
	}
	echo "<a href=../loan/loanpaymentload.php>กลับหน้าเว็บการเพิ่มข้อมูล</a><br>";
	echo "<a href=../loan/>กลับหน้าเว็บหลัก</a><br>";
}
	}
	
?>