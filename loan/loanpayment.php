<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php 
session_start();
include('/library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="l")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
?>

<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title>ระบบสินเชื่อ(คืนเงินกู้)</title>
<?php 
	$loanno = $_POST['loanno'];
include('../config/config.php');
	$sql = "select * from memberloan where loanno = '$loanno'";
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
	if 	(($dbarr['loanno']==null)){
			echo "<center><span class='h1'>"."รหัสเงินกู้ไม่ถูกต้อง หรือเป็นค่าว่าง </span><br><a href='/brcb/loan/loanpaymentload.php'>".$back."</a>";
	}else if(($dbarr['statusloan']=="ac")){
			echo "<center><span class='h1'>สมาชิกเงินกู้ รหัส ".$loanno." <br>ทำการปิดบัญชีแล้ว </span><br><a href='/brcb/loan/loanpaymentload.php'>".$back."</a>";
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
		$sql = "select a.*,b.mname ,b.lname ,b.pname ,b.fundno 
		from memberloan a,memberfund b 
		where a.fundno=b.fundno and loanno = '$loanno'";
		$query=mysqli_query($link,$sql);
		$rname=mysqli_fetch_array($query);	
		echo $rname["pname"].$rname["mname"]."  ".$rname["lname"] ;?></div>
</div>
<div id="tab">
	<div id="menu">เงินคงเหลือ</div>
<?php 
include('../config/config.php');

	$sql="SELECT sum(payment) as 'rloan' FROM eventloan where loanno = '$loanno'";
	$query = mysqli_query($link,$sql);
	$rpay=mysqli_fetch_array($query);
	
	$sql1="SELECT count(payment) as 'cpay' FROM eventloan where loanno ='$loanno'";
	$query1 = mysqli_query($link,$sql1);
	$cpay=mysqli_fetch_array($query1);
	$time=$cpay['cpay']+1;
	$amount=$rname['principle']-$rpay['rloan'];
setcookie('amount',$amount,time()+30);
?>
	<div id="content"><?php echo number_format($amount,2,'.',',') ;?> บาท</div>
</div>
<div id="tab">
	<div id="menu">งวดที่ </div>
	<div id="content"><input type="text" name="timeloan" value="<?php echo $time."/".$rname['timeloan']; ?>" readonly /></div>
</div>
<div id="tab">
	<div id="menu">ชำระเงินต้น</div>
	<div id="content"><input type="text" name="payment" value="<?php echo ($rname['principle']/$rname['timeloan']);?>" /> บาท</div>
<div id="tab">
	<div id="menu">ชำระดอกเบี้ย</div>
	<div id="content"><input type="text" name="reciveinterest" value="<?php echo($amount*($rname['interestloan']/100));?>"readonly /> บาท
<?php 
	if($rname['interestloan']<1){
	echo	"<font color='red'>* สิทธิกรรมการ ดอกเบี้ย 0.5 </font>";
} ?>		
	</div>
</div>
<div id="tab">
	<div id="menu">รวมเป็นเงิน </div>
<div id="content"><span class="h1"><?php echo number_format(($rname['principle']/$rname['timeloan'])+($amount*($rname['interestloan']/100)),2,'.',',')."  บาท";?></span></div>
</div>
<div id="tab">
	<div id="menu">ทำรายการวันที่ / เวลา</div>
	<div id="content"> <?php echo date("Y-m-d H:i:s")?>   
	</div>
</div>
<div id="tab">
	<div id="bar1">
		<button type="submit"  name="send2" id="button">
		<button type="submit" formaction="../loan/loanpaymentload.php" id="button2">	</form>
	</form></div>
</div>
<div id="tab">
<table class="header" width="1000" align="center" >
<th  colspan="10"  > ตารางถอนเงินออมทรัพย์สัจจะ </th>
<tr>
	<td class="c1">รหัสเงินกู้</td>
	<td class="c2">ชำระเงินต้น</td>
	<td class="c1">ชำระดอกเบี้ย</td>
	<td class="c2">ยอดชำระรวม</td>
	<td class="c1">งวดที่</td>
	<td class="c2">วันที่ทำรายการ</td>
	<td class="c1">สถานะ</td>

</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
include('../config/config.php');
// สูตร ค่อยทำแยกตามกรรมการ อ้างอิงตม sestion
	$sql="SELECT * FROM eventloan where loanno = '$loanno' order by createdate" ;
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
	?> 
<tr>
	<td class="c1"><?=$result["loanno"];?></td>
	<td class="c2"><?=$result["payment"];?></td>
	<td class="c1"><?=$result["reciveinterest"];?></td>
	<td class="c2"><?php echo $amount;?></td>
	<td class="c1"><?=$result["loantime"];?></td>
	<td class="c2"><?=$result["createdate"];?></td>
	<td class="c1"><?php 
	$code=$result['code'];
	include('../config/config.php');
		$sql1="SELECT * FROM evcode where codeid='$code'";
			$query1=mysqli_query($link,$sql1);
			$dbarr=mysqli_fetch_array($query1);
		echo $dbarr['codename'];
	?></td>

</tr>
	<?php }
	?>
</table>
</div>
</div>

		<?php 
//ส่วนการเพิ่มข้อมูล 
}else{
	$payment= $_POST['payment'];
	$amount=$_COOKIE['amount'];
	setcookie('payment',$payment,time()+30);
	if(!is_numeric($payment)){
			echo "<center><span class='h1'>"."ป้อนค่าเป็นตัวเลขเท่านั้น </span><br><a href='/brcb/loan/loanpaymentload.php'>".$back."</a>";
	}else if ($payment>$amount){
			echo "<center><span class='h1'>"."ชำระเกินยอดคงเหลือ <br>ส่งยอดไม่เกิน ".number_format(($amount),2,'.',',')." บาท  </span><br><a href='/brcb/loan/loanpaymentload.php'>".$back."</a>";
	}else{
	$loanno= $_POST['loanno'];
	$reciveinterest= $_POST['reciveinterest'];
	$workrid=$_SESSION['workno'];
	$createdate=date("Y-m-d H:i:s");
	$timeloan=$_POST['timeloan'];
	
if ((($amount-($_POST['payment']))<0)or($amount-($_POST['payment']))==0){
	$code="ac";	
// ว่าด้วยการ update สถานะบัญชี 
	include('../config/config.php');
		mysqli_set_charset($link,'utf8');
		$sql = "update memberloan set statusloan='$code' where loanno = '$loanno'";
		$query= mysqli_query($link,$sql);
		if($result)	{
			echo "<center><span class='h1'>ปิดบัญชีเรียบร้อย <br>";
			mysqli_close($link);
		}	else	{
		echo "ไม่สามารถปิดบัญชีได้<br>";}
}else{
	$code="pa";	
}
setcookie('amount');
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
		'$payment','$reciveinterest','$timeloan',
		'$createdate','$code'
		)";
	$result = mysqli_query($link, $sql);
	if($result)	{
		echo "<center><span class='h1'>รวมรับเงินทั้งสิ้น ".number_format(($payment+$reciveinterest),2,'.',',')." บาท  <br>บันทึกข้อมูลสำเร็จ<br>";
		mysqli_close($link);
	}	else	{
		echo "<center><span class='h1'>ไม่สามารถบันทึกข้อมูลใหม่ลงในฐานข้อมูลได้<br>";
	}
	echo "<a href=../loan/loanpaymentload.php>$back</a><br>";
			}
		}
	}
}
?>