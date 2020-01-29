<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php // หน้าที่สอง จากการเพิ่มสมาชิกเงินกู้ 
session_start();include('../config/config.php');include('/library.php');
// ชุดคำสั่ง ก๊อกมา เป็นการแก้ไขคำสั่งเตือนแบบ notice
	error_reporting( error_reporting() & ~E_NOTICE );
	if ($_SESSION['workroleid']==null){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
	}else if (!(($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง เฉพาะ ฝ่าย IT<br>"."<a href='../loan/addmemberloanload.php'>$back</a> ";	
	}else{
?>
<meta charset=utf8>
<title><?php echo$title.": สมัครสมาชิก";?></title>
<?php 
$fundno=(int)$_GET['fundno'];
$principle=(int)$_GET['principle'];
$timeloan=(int)$_GET['timeloan'];
$typeloan=$_GET['typeloan'];
$lunit=2;
include('../config/config.php');
	$loan1="select count(fundno) as 'sumloan' 
		from memberloan where fundno=".$fundno;
		$qloan1=mysqli_query($link,$loan1);
		$dbloan=mysqli_fetch_array($qloan1);	
	$sql = "select * from memberfund where fundno =".$fundno;
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
	if 	(($fundno==0)or($fundno<>$dbarr['fundno'])){
			echo "<center><span class='h1'>รหัสสมาชิกไม่ถูกต้อง</span><br><a href='/brcb/loan/addmemberloanload.php'>".$back."</a>";
	}else if(($dbloan['sumloan']>$lunit)or($dbloan['sumloan']>$lunit)){
			echo "<center><span class='h1'>ผู้กู้เกินกำหนด ต้องการทำรายการหรือไม่</span><br>
			<a href='/brcb/loan/addmemberloanload.php'>".$back."</a> ";
	}else{
/* เข้าสู่ช่่วงการจัดการโปรแกรม   */

if (!isset($_POST['fundno'])){
include('../config/config.php');
	$sql="SELECT * FROM memberloan";
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
	<div id="content"><input type="text" name="loanno" readonly value="<?php $a=date("y")+43; echo ($numrows+1).'/'.$a;?>" /></div>
</div>

<div id="tab">
	<div id="menu">ข้อมูลสมาชิก</div>
	<div id="content"><?php echo $dbarr["pname"].$dbarr["mname"]."  ".$dbarr["lname"];?></div>
</div>
<div id="tab">
	<div id="menu">รหัสสมาชิก</div>
	<div id="content"><input type="text" value="<?php echo$fundno;?>" name="fundno" readonly /></div>
</div>
<div id="tab">
	<div id="menu">จำนวนเงินกู้</div>
	<div id="content"><input type="text" value="<?php echo$principle;?>" name="principle" readonly />บาท</div>
</div>
<div id="tab">
	<div id="menu">จำนวนงวดชำระ</div>
	<div id="content"><input type="text" value="<?php echo$timeloan;?>" name="timeloan" readonly />งวด</div>
</div>
<div id="tab">
	<div id="menu">ดอกเบี้ย</div>
	<div id="content">
<?php
include('../config/config.php');
	$sql="SELECT * FROM worker where workstatusid='1' and fundno=$fundno";
	$query= mysqli_query($link,$sql);
	$ckk= mysqli_fetch_array($query);
	if ($ckk['fundno']<>$fundno){
	echo "<input name='interestloan' type='radio' value='1' checked > ปกติ<br />";	
	}else{
	echo "<input name='interestloan' type='radio' value='0.5' checked > คณะกรรมการ<br />";		
	}
?>	
	</div>
</div>

<!-- ประเภทหลักทรัพย์ เขียน แบบ PHP !-->
<?php  
if (($typeloan)==1){
	echo "	
	<div id='tab'>
		<div id='menu'>ประเภทหลักทรัพย์</div>
		<div id='content'><input name='typeloan' type='radio' value='1' checked > ประเภทคนค้ำประกัน</div>
	</div>
	<div id='tab'>		
		<div id='menu'>เลขสมาชิก คนค้ำคนที่ 1</div>
	";
		if($guatantee1==null){	
			echo"
		<div id='content'> 		<input type='text' name='guatantee1' />	</div>";
		}else{
		include('../config/config.php');
		$sql1 = "select * from memberfund where fundno =".$guatantee1;
			$result1 = mysqli_query($link, $sql1);
			$dbarr1 = mysqli_fetch_array($result1);	
			$fnameglt1=$dbarr1['pname'].$dbarr1['mname']."  ".$dbarr1['lname'];
			echo"
		<div id='content'> <input type='text' name='guatantee1' value='$guatantee1'/>$fnameglt1	</div>";
		}
	echo "	
	<div id='tab'>	
		<div id='menu'>เลขสมาชิก คนค้ำคนที่ 2
	</div> ";
		if($guatantee2==null){	
			echo"
		<div id='content'> <input type='text' name='guatantee2' /></div>";
		}else{
		include('../config/config.php');
		$sql2 = "select * from memberfund where fundno =".$guatantee2;
			$result2 = mysqli_query($link, $sql2);
			$dbarr2 = mysqli_fetch_array($result2);			
			$fnameglt2=$dbarr2['pname'].$dbarr2['mname']."  ".$dbarr2['lname'];

			echo"
		<div id='content'> <input type='text' name='guatantee2' value='$guatantee2'/>$fnameglt2</div>";
		}
	echo"</div>";	
}else if(($typeloan)==2){
	echo "
	<div id='tab'>
		<div id='menu'>ประเภทหลักทรัพย์</div>
		<div id='content'><input name='typeloan' type='radio' value='2' checked >ประเภทหลักทรัพย์ค้ำประกัน</div>
	</div>
	<div id='tab'>		
		<div id='menu'>รายละเอียด </div>
		<div id='content'><textarea name='collateral'/></textarea><br>
	</div>";
}else if(($typeloan)==3){
	echo"
	<div id='tab'>
		<div id='menu'>ประเภทหลักทรัพย์</div>
		<div id='content'><input name='typeloan' type='radio' value='3' checked >ประเภทสมุดธนาคารค้ำประกัน</div>
	</div>
	<div id='tab'>		
		<div id='menu'>เลขบัญชี </div>	
		<div id='content'><input type='text' name='bookbank' /></div>
	</div>";
}else{
	echo "ผิดพลาด <a href='http://localhost/brcb/loan/addmemberloanload.php'>ย้อนกลับ</a>";
};?>
<div id="tab">
	<div id="menu">ทำรายการวันที่ / เวลา </div>
	<div id="content">        
	<input type="text" value="<?php echo date("Y-m-d H:i:s")?>">   
	</div>
</div>
<div id="tab">
	<div id="bar1">
		<button type="submit" id="button"/>	
		<button formaction='addmemberloanload.php?' id="button2" /></form>
	</div>
</div>
</div>
<?php 
}// เช็คค่า คนค้ำประกัน
else{
$glt1=(int)$_POST['guatantee1'];
$glt2=(int)$_POST['guatantee2'];
	
	if ($_POST['typeloan']==1){
		if (($glt1==null)or($glt1==0)){
			echo "<center><span class='h1'>คนค้ำที่ 1 ว่างอยู่</span><br></center>";
		}else if(($glt2==null)or($glt2==0)){
			echo "<center><span class='h1'>คนค้ำที่ 2 ว่างอยู่</span><br></center>";		
		}	
		$glt1="select count(guatantee1 or guatantee2) as 'sumglt1' 
		from memberloan where guatantee1=".$glt1." or guatantee2=".$glt1;
		$qglt1=mysqli_query($link,$glt1);
		$dbglt1=mysqli_fetch_array($qglt1);	
		
		$glt2="select count(guatantee1 or guatantee2) as 'sumglt2' 
		from memberloan where guatantee1=".$glt2." or guatantee2=".$glt2;
		$qglt2=mysqli_query($link,$glt2);
		$dbglt2=mysqli_fetch_array($qglt2);	
		
		$gltnum=2;// การกำหนดค่า คนค้ำ ไม่เกิน 
		if(($dbglt1['sumglt1']>$gltnum)or($dbglt1['sumglt1']==$gltnum)or($glt1==0)){
				echo "<center><span class='h1'>คนค้ำที่ 1 ค้ำเกินกว่ากำหนด $gltnum คน หรือเป็นค่าว่าง </span><br> 
				<a href='/brcb/loan/addmemberloan.php?fundno=$fundno&principle=$principle&timeloan=$timeloan&typeloan=$typeloan'>".$back."</a></center>";
		}else if(($dbglt2['sumglt2']>$gltnum)or($dbglt2['sumglt2']==$gltnum)or($glt2==0)){
				echo "<center><span class='h1'>คนค้ำที่ 2 ค้ำเกินกว่ากำหนด $gltnum คน หรือเป็นค่าว่าง</span><br> 
				<a href='/brcb/loan/addmemberloan.php?fundno=$fundno&principle=$principle&timeloan=$timeloan&typeloan=$typeloan'>".$back."</a></center>";
		}else{
			$bookbank=0;	$collateral=0; 	$guatantee1=$glt1; $guatantee2=$glt2; $a1=1;
		}
	}else if ($_POST['typeloan']==2){
		if($_POST['collateral']==null){
				echo "<center><span class='h1'>กรอกข้อมูลเอกสารหลักทรัพย์</span><br> <a href='/brcb/loan/addmemberloan.php'>".$back."</a></center>";		
		}else{
			$guatantee1=0; $guatantee2=0; $bookbank=0; $collateral=$_POST['collateral'];$a1=1;
		}
	} else{ 
		if($_POST['bookbank']==null){
				echo "<center><span class='h1'>กรอกข้อมูลเลขบัญชี</span><br> <a href='/brcb/loan/addmemberloan.php'>".$back."</a></center>";		
		}else{
			$guatantee1=0; $guatantee2=0; $collateral=0; $bookbank=$_POST['bookbank'];$a1=1;
		}
	}
if (isset($a1)){
$loanno=$_POST['loanno'];
$fundno=$_POST['fundno'];
$workrid=$_SESSION['workno'];
$createdate=date("Y-m-d H:i:s");
$lastupdate=date("Y-m-d H:i:s");
$typeloan=$_POST['typeloan'];
$principle=$_POST['principle'];
$timeloan=$_POST['timeloan'];
$interestloan=$_POST['interestloan'];	

$statusloan="op";
	include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link, $sql);
	$sql = "Insert into memberloan value(
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
		echo "<center><span class='h1'>การเพิ่มข้อมูลลงในฐานข้อมูลประสบความสำเร็จ<br>";
		mysqli_close($link);
	}	else	{
		echo "<center><span class='h1'>ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br>";
	}
	echo "<a href=../loan/addmemberloanload.php>$back</a><br>";
}else{
}
}	
	}// ปิดตัวรอง เช็คค่าว่าง ของ รหัส , ยอดเงิน, จำนวนเดือน 
}//ปิดตัวบนสุด การเช็กสถานะ 	
?>