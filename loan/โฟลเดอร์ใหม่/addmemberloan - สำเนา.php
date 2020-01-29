<?php // หน้าที่สอง จากการเพิ่มสมาชิกเงินกู้ 
session_start();
include('/library.php'); include('../config/config.php'); 
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="l")or($_SESSION['workroleid']=="a"))){
			echo "ท่านไม่มีสิทธิ์เข้าถึง <br><a href='http://localhost/brcb/index.php'>".$login."</a> ";	
		}else{
?>
<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title><?php echo$title.": สมัครสมาชิก";?></title>
<?php 
$fundno = $_POST['fundno'];
include('../config/config.php');
	$sql = "select * from memberfund where fundno = '$fundno';";
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
	if 	((!(is_numeric($fundno)))or($dbarr['fundno']=="")){
			echo "<center><span class='h1'>รหัสไม่ถูกต้อง</span><br><a href='/brcb/loan/addmemberloanload.php'>".$back."</a>";
	}else{
		
/* เข้าสู่ช่วงการจัดการโปรแกรม   */
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
<form name="คืนเงินกู้" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div id="container">
<div id="header"><?php echo$title." : สมัครสมาชิก";?></div>
<div id="tab"><?php $numrows;?>
	<div id="menu">รหัสสมาชิก</div>
	<div id="content"><input type="text" name="fundno" value="<?php echo $fundno;?>" /></div>
</div>
<div id="tab">
	<div id="menu">ชื่อ – สกุล</div>
	<div id="content"><?php echo $dbarr["pname"].$dbarr["mname"]."  ".$dbarr["lname"] ;?></div>
</div>
<div id="tab">
	<div id="menu">จำนวนเงินกู้</div>
	<div id="content"><input type="text" name="principle" />บาท</div>
</div>
<div id="tab">
	<div id="menu">จำนวนเดือนชำระ</div>
	<div id="content"><input type="text" name="timeloan" />เดือน</div>
</div>
<div id="tab">
	<div id="menu">ดอกเบี้ย</div>
	<div id="content">
	<input name="interestloan" type="radio" value="1" checked >ปกติ<br />
    <input name="interestloan" type="radio" value="2" />คณะกรรมการ<br />
</div>
<div id="tab">
	
<!-- ประเภทหลักทรัพย์ เขียน แบบ PHP !-->
<?php  
if (($_POST['typeloan'])==1){
	echo "		
		<div id='menu'>ประเภทหลักทรัพย์</div>
		<div id='content'><input name='typeloan' type='radio' value='1' checked > ประเภทคนค้ำประกัน</div>
	</div>
	<div id='tab'>		
		<div id='menu'>คนค้ำคนที่ 1</div>
		<div id='content'> <input type='text' name='guatantee1' /></div>
	<div id='tab'>	
		<div id='menu'>คนค้ำคนที่ 2</div> 
		<div id='content'><input type='text' name='guatantee2' /></div>
";
}else if(($_POST['typeloan'])==2){
	echo "
		<div id='menu'>ประเภทหลักทรัพย์</div>
		<div id='content'><input name='typeloan' type='radio' value='2' checked >ประเภทหลักทรัพย์ค้ำประกัน</div>
	</div>
	<div id='tab'>		
		<div id='menu'>รายละเอียด </div>
		<div id='content'><textarea name='collateral'/></textarea><br>";
	
}else if(($_POST['typeloan'])==3){
	echo"
		<div id='menu'>ประเภทหลักทรัพย์</div>
		<div id='content'><input name='typeloan' type='radio' value='3' checked >ประเภทสมุดธนาคารค้ำประกัน</div>
	</div>
	<div id='tab'>		
		<div id='menu'>เลขบัญชี </div>	
		<div id='content'><input type='text' name='bookbank' /></div>";
}else{
	echo "ผิดพลาด <a href='http://localhost/brcb/loan/addmemberloanload.php'>ย้อนกลับ</a>";
};?>
</div>
</div>

<div id="tab">
	<div id="menu">ทำรายการวันที่ / เวลา </div>
	<div id="content">        
	<input type="text" value="<?php echo date("Y-m-d H:i:s")?>">   
	</div>
</div>
<div id="tab">
	<div id="bar1">
		<input type="submit" name="send2" value="ทำรายการ" />    <input type="reset" name="reset" value="ล้างข้อมูล" />
	</form><br>
	<a href="../loan/">กลับสู่หน้าเมนูย่อย </a>
</div>
</div>
</div>

<?php 
//ส่วนการเพิ่มข้อมูล 
}else{
include('../config/config.php');
	$sql1 = "select * from memberfund where fundno =".$_POST['guatantee1'];
		$result1 = mysqli_query($link, $sql1);
		$dbarr1 = mysqli_fetch_array($result1);	 
	if ((($_POST['principle'])or($_POST['timeloan']))==null){
		echo "กรุณากรอกยอดเงิน หรือ จำนวนงวด <br>"."<input name='btnButton' type='button' post='$fundno'  value='ย้อนกลับ' onClick='JavaScript:history.back();'>"; 	
	}else if($typeloan=$_POST['typeloan']<>null ){
		if (($typeloan==1)and(($_POST['guatantee1']==null)or($_POST['guatantee2']==null))){
			if (($_POST['guatantee1']==null)or($_POST['guatantee2']==null)){
			echo "ข้อมูลเป็นค่าว่าง กรอกใหม่<br><input name='btnButton' type='button' value='ย้อนกลับ' onClick='JavaScript:history.back();'>";
			}else if (!(is_numeric($_POST['guatantee1']or$_POST['guatantee2']))){
			echo "ข้อมูลไม่ใช่ตัวเลข กรอกใหม่<br><input name='btnButton' type='button' value='ย้อนกลับ' onClick='JavaScript:history.back();'>";
			}else if(	
			($_POST['guatantee1']<>$dbarr1['fundno'])or($_POST['guatantee2']<>$dbarr22['fundno'])){
			echo "กรอกรหัสผู้ค้ำใหม่<br><input name='btnButton' post='$fundno' type='button' value='ย้อนกลับ' onClick='JavaScript:history.back();'>";
			}else{
			}
		}else if (($typeloan==2)and($_POST['collateral']==null)){
		echo "กรอกข้อมูลหลักทรัพย์ใหม่<br><input name='btnButton' post='$fundno' type='button' value='ย้อนกลับ' onClick='JavaScript:history.back();'>";
		}else if (($typeloan==3)and($_POST['bookbank']==null)){
		echo "กรอกข้อมูลบัญชีใหม่<br><input name='btnButton' post='$fundno' type='button' value='ย้อนกลับ' onClick='JavaScript:history.back();'>";
		}
	}else{
	$fundno= $_POST['fundno'];
	$workrid=$_SESSION['workno'];
	$createdate=date("Y-m-d H:i:s");
	$lastupdate=date("Y-m-d H:i:s");
	$principle=$_POST['principle'];
	$timeloan=$_POST['timeloan'];
	$statusloan="1";
include('../config/config.php');
	$sql="SELECT * FROM memberloan";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
	$loanno=$numrows+1; 
	
	if ($_POST['interestloan']==1){
		$interestloan=1;
	} else{
		$interestloan=0.5;
	}
mysqli_close($link);	
		if ($typeloan==1){
			$guatantee1=$_POST['guatantee1'];
			$guatantee2=$_POST['guatantee2'];
			$collateral=0;	$bookbank=0;
		}else if($typeloan==2) {
			$guatantee1=0;	$guatantee2=0;
			$collateral=$_POST['collateral'];
			$bookbank=0;
		}else {
			$guatantee1=0;	$guatantee2=0;	$collateral=0;
			$bookbank=$_POST['bookbank'];
		}	

include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link, $sql);
	$sql = "Insert into memberloan values(
		'$loanno','$fundno','$workrid',
		'$createdate',
		'$typeloan','$principle','$interestloan','$timeloan',
		'$statusloan',
		'$lastupdate',
		'$guatantee1','$guatantee2',
		'$collateral',
		'$bookbank'
		)";
	$result = mysqli_query($link, $sql);
	if($result)	{
		echo "การเพิ่มข้อมูลลงในฐานข้อมูลประสบความสำเร็จ<br>";
		mysqli_close($link);
	}	else	{
		echo "ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br>";
	}
	echo "<a href=../loan/addmemberloanload.php>กลับหน้าเว็บการเพิ่มข้อมูล</a><br>";
	echo "<a href=../loan/>กลับเมนูย่อย </a><br>";
}
		}
	}
}
?>