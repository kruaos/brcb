<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<link href="../config/css/bootstrap.min.css" rel="stylesheet">
<?php 
session_start();
include('library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="b")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='../brcb/index.php'>$login</a> ";	
		}else{
$bankid=$_GET['bankid'];		
$num=$_GET['num'];		
if (!isset($_GET['send'])) {
	include('../config/config.php');
		$sql="SELECT * FROM eventbank where bankid=$bankid and num=$num";
		$query= mysqli_query($link,$sql);
		$result = mysqli_fetch_array($query);
?>
<!--	
ส่วนนี้สำหรับแก้ไข การเพิ่มยอดเงินฝาก 
2 ทำตัวจับว่า กดปุ่ม และทำการบันทึก 
-->
<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title>ฝากเงินธนาคารชุมชน</title>
<div id="container">
<div id="header">แก้ไขการกรอกสถานะการเงิน </div>
<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div id="tab">
	<div id="menu">เลขบัญชี</div>
	<div id="content"><?=$result['bankid'];?></div>
	
</div>
<div id="tab">
	<div id="menu">วัน / เวลา ทำรายการ</div>
	<div id="content"><?=$result['deptime'];?></div>
	</div>
<div id="tab">
	<div id="menu">รายการ</div>
	<div id="content">
		<?php 
			if($result['code']=='de'){
				$ckkde="checked";
			}else if($result['code']=='wi'){
				$ckkwi="checked"; 
			}else if($result['code']=='in'){
				$ckkin="checked"; 
			}else if($result['code']=='bl'){
				$ckkbl="checked"; 
			}else{ 
			} ?>
		<input id="rc1" type="radio" name="code" value="de" <?=$ckkde;?>><label for="rc1" onclick>ฝาก</label>
		<input id="rc2" type="radio" name="code" value="wi"<?=$ckkwi;?>><label for="rc2" onclick>ถอน  </label>
		<input id="rc3" type="radio" name="code" value="in"<?=$ckkin;?>><label for="rc3" onclick>ดอกเบี้ย  </label>
		<input id="rc4" type="radio" name="code" value="bl"<?=$ckkbl;?>><label for="rc4" onclick>ยอดยกมา</label>
	 
		</div>	
</div>	
<div id="tab">
	<div id="menu">จำนวนเงินที่ทำรายการ</div>
	<div id="content"><input type="text" name="amount"  value="<?=$result['income']?>"></div>
</div>

<div id="tab">
	<input hidden name="num" value="<?=$result['num']?>">
	<input hidden name="bankid" value="<?=$result['bankid']?>">
	<input hidden name="num" value="<?=$result['num']?>">
</div>


<div id="tab">
<button type='submit' id='button' name="send"></button>
<?php if($_SESSION['workroleid']==i or $_SESSION['workroleid']==a){$back="admin";}else{$back="bank";}?>
<a href='../<?=$back?>/addstatment.php?bankid=<?=$_GET['bankid']?>'><img src='../image/back2.png'></a>
</form>

</div>
<!--
เพิ่มส่วน บันทึก update 
-->
<?php
}else{
	$income= $_GET['amount'];
	$code=$_GET['code'];
	$createdate=(((substr($deptime,-2,2))+2500)-543)."-".substr($deptime,3,2)."-".substr($deptime,0,2)." 00:00:00";
	$num=$_GET['num'];
include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$sql = "update eventbank set
		income='$income',
		code='$code'
		where num ='$num'";
	$result = mysqli_query($link, $sql);
	if ($result)
	{
		echo "<center><span class='h1'>บันทึกข้อมูลเรียบร้อย<br></span>";
		mysqli_close($link);
	}
	else
	{
		echo "<center><span class='h1'>ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br></span><br>".$sql."<br>";
	}
	echo "<a href=../bank/addstatment.php?bankid=".$_GET['bankid'].">$back</a><br>";


//------------------------	
		}
}
		?>