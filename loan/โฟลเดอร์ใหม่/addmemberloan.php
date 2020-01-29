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
$fundno=$_COOKIE['fundno'];
$principle=$_COOKIE['principle'];
$timeloan=$_COOKIE['timeloan'];
$typeloan=$_COOKIE['typeloan'];
$guatantee1=$_COOKIE['guatantee1'];
$guatantee2=$_COOKIE['guatantee2'];
$bookbank=$_COOKIE['bookbank'];
include('../config/config.php');
	$sql = "select * from memberfund where fundno =".$fundno;
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
	if 	((!(is_numeric($fundno)))or($dbarr['fundno']=="")or($fundno<>$dbarr['fundno'])){
			echo "<center><span class='h1'>".$fundno."พิมพ์รหัสสมาชิกไม่ถูกต้อง</span><br><a href='/brcb/loan/addmemberloanload.php' title='ส่วนที่ 1'>".$back."</a>";
	}else if((!(is_numeric($principle)))or($principle=="")) {
			echo "<center><span class='h1'>กรอกวงเงินกู้ไม่ถูกต้อง</span><br><a href='/brcb/loan/addmemberloanload.php'>".$back."</a>";
	}else if((!(is_numeric($timeloan)))or($timeloan=="")) {
			echo "<center><span class='h1'>กรอกระยะเวลาไม่ถูกต้อง</span><br><a href='/brcb/loan/addmemberloanload.php'>".$back."</a>";
	}else{
/* เข้าสู่ช่่วงการจัดการโปรแกรม   */
		if (!isset($_POST['send'])){
include('../config/config.php');
	$sql="SELECT * FROM memberfund";
		$query= mysqli_query($link,$sql);
		$numrows= mysqli_num_rows($query);
		$result = mysqli_query($link, $sql);
	$sql = "select * from memberfund where fundno = ".$fundno;
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
?>
<form name="คืนเงินกู้" method="post">
<div id="container">
<div id="header"><?php echo$title." : สมัครสมาชิก";?></div>
<div id="tab">
	<div id="menu">สัญญาเลขที่</div>
	<div id="content"><input type="text" name="loanno" readonly value="<?php echo $numrows;?>/58" /></div>
</div>

<div id="tab">
	<div id="menu">ข้อมูลสมาชิก</div>
	<div id="content"><?php echo $dbarr["pname"].$dbarr["mname"]."  ".$dbarr["lname"]."  <b>รหัสสมาชิก</b>  ".$fundno ;?></div>
</div>
<div id="tab">
	<div id="menu">จำนวนเงินกู้</div>
	<div id="content"><input type="text" value="<?php echo$principle;?>" name="principle" readonly />บาท</div>
</div>
<div id="tab">
	<div id="menu">จำนวนเดือนชำระ</div>
	<div id="content"><input type="text" value="<?php echo$timeloan;?>" name="timeloan" readonly />เดือน</div>
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
if (($typeloan)==1){
	echo "		
		<div id='menu'>ประเภทหลักทรัพย์</div>
		<div id='content'><input name='typeloan' type='radio' value='1' checked > ประเภทคนค้ำประกัน</div>
	</div>
	<div id='tab'>		
		<div id='menu'>คนค้ำคนที่ 1</div>";
	if($guatantee1==null){	
		echo"<div id='content'> <input type='text' name='guatantee1' /></div>";
	}else{
		include('../config/config.php');
		$sql1 = "select * from memberfund where fundno =".$guatantee1;
			$result1 = mysqli_query($link, $sql1);
			$dbarr1 = mysqli_fetch_array($result1);			
			echo"<div id='content'> <input type='text' name='guatantee1' value='$guatantee1'/>
			".$dbarr1['pname'].$dbarr1['mname']."  ".$dbarr1['lname']."
			</div>";
	}
	echo "	<div id='tab'>	
		<div id='menu'>คนค้ำคนที่ 2</div> ";
	if($guatantee2==null){	
		echo"<div id='content'> <input type='text' name='guatantee2' /></div>";
	}else{
		include('../config/config.php');
		$sql1 = "select * from memberfund where fundno =".$guatantee2;
			$result1 = mysqli_query($link, $sql1);
			$dbarr1 = mysqli_fetch_array($result1);			
			echo"<div id='content'> <input type='text' name='guatantee2' value='$guatantee2'/>
			".$dbarr1['pname'].$dbarr1['mname']."  ".$dbarr1['lname']."
			</div>";
	}
}else if(($typeloan)==2){
	echo "
		<div id='menu'>ประเภทหลักทรัพย์</div>
		<div id='content'><input name='typeloan' type='radio' value='2' checked >ประเภทหลักทรัพย์ค้ำประกัน</div>
	</div>
	<div id='tab'>		
		<div id='menu'>รายละเอียด </div>
		<div id='content'><textarea name='collateral'/></textarea><br>";
	
}else if(($typeloan)==3){
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
		<input type="submit" name="send" value="ทำรายการ" />    <input type="reset" name="reset" value="ล้างข้อมูล" />
	</form><br>
	<a href="../loan/">กลับสู่หน้าเมนูย่อย </a>
</div></div></div>
<?php 
		}// เช็คค่า คนค้ำประกัน
		else{
// ในส่วนนนี้จะแสดงหน้าตาซ็ำอีกรอบ และแสงหน้า	

$data5=$_POST['guatantee1'];
$data6=$_POST['guatantee2'];
$data7=$_POST['bookbank'];
$data8=$_POST['loanno'];
$data9=$_POST['interestloan'];
$data10=$_POST['collateral'];
setcookie('guatantee1',$data5,time()+300);	
setcookie('guatantee2',$data6,time()+300);		
setcookie('bookbank',$data7,time()+300);
setcookie('loanno',$data8,time()+300);	
setcookie('interestloan',$data9,time()+300);
setcookie('collateral',$data10,time()+300);

if ($typeloan==1){
		if ((($_POST['guatantee1'])==null)or(($_POST['guatantee2'])==null)){
			if(($_POST['guatantee1'])==null){
				echo "<center><span class='h1'>คนค้ำที่ 1 ว่างอยู่</span><br> <a href='/brcb/loan/addmemberloan.php'>".$back."</a></center>";
			}else {
				echo "<center><span class='h1'>คนค้ำที่ 2 ว่างอยู่</span><br> <a href='/brcb/loan/addmemberloan.php'>".$back."</a></center>";		
			}	
		}else if(!((is_numeric($_POST['guatantee1']))or(is_numeric($_POST['guatantee1'])))){
				echo "<center><span class='h1'>ข้อมูลต้องเป็นตัวเลขเท่านั้น</span><br> <a href='/brcb/loan/addmemberloan.php'>".$back."</a></center>";		
		}else{
			header( "location: /brcb/loan/addloan.php" );
		}
	}
else if ($typeloan==2){
		echo "หลักทรัพย์ โฉนด";
	}
else if ($typeloan==3){ 
		echo "สมุดธนาคาร";
	}
else{
		echo "ผิดพลาด";
	
		}
		}
	}// ปิดตัวรอง เช็คค่าว่าง ของ รหัส , ยอดเงิน, จำนวนเดือน 
}//ปิดตัวบนสุด การเช็กสถานะ 	
?>