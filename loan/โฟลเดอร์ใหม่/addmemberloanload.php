<?php //หน้าสมัครสมาชิกเงินกู้ หน้าแรก 
session_start();
include('/library.php'); include('../config/config.php'); 
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="l")or($_SESSION['workroleid']=="a"))){
			echo "ท่านไม่มีสิทธิ์เข้าถึง <br><a href='http://localhost/brcb/index.php'>".$login."</a> ";	
	}else{
		if (!isset($_POST['send'])){
	
		?>
			

<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title>ระบบสินเชื่อ(เปิดบัญชี)</title>
<div id="container">
<form name="เปิดบัญชี" method="post" >
	<div id="header">กรอกรหัสสมาชิกสัจจะ</div>
	<div id="tab">
		<div id="menu">รหัสสมาชิก</div>
		<div id="content"><input type="text" name="fundno" /></div>
	<div>
		<div id="tab">
		<div id="menu">วงเงินกู้</div>
		<div id="content"><input type="text" name="principle" />บาท</div>
	<div>
		<div id="tab">
		<div id="menu">จำนวนเดือนชำระ</div>
		<div id="content"><input type="text" name="timeloan" />งวด</div>
	<div>
	<div id="tab">
		<div id="menu">ประเภทหลักทรัพย์</div>
		<div id="content">
			<input name="typeloan" type="radio" value="1" checked >คนค้ำประกัน
			<input name="typeloan" type="radio" value="2"  >หลักทรัพย์
			<input name="typeloan" type="radio" value="3"  >บัญชีเงินฝาก
		</div>
	</div>
	<input type="submit" name="send" value="ค้นหา" /></div>
</form>	</div>
</div>

<br>
<div id="container">
<table class="header" width="1000" align="center" >
<th colspan="10" > ตารางฝากเงินออมทรัพย์สัจจะ </th>
<tr >
	<td class="c1">รหัสเงินกู้</td>
	<td class="c2">รหัสสมาชิกสัจจะ</td>
	<td class="c1">จำนวนเงินกู้</td>
	<td class="c2">จำนวนเดือน</td>
	<td class="c1">ประเภทหลักทรัพย์</td>
	<td class="c2">วันที่สมัคร</td>
	
</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
include('../config/config.php');
// สูตร ค่อยทำแยกตามกรรมการ อ้างอิงตม sestion

	$sql="SELECT * FROM memberloan";
	$query=mysqli_query($link,$sql);
	
	
	//ใช้ numrows ในการนับแถว
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		if ($result['typeloan']==1){
			$typeloan='คนค้ำประกัน';
		} else if($result['typeloan']==2){
			$typeloan='หลักทรัพย์';
		} else{
			$typeloan='สมุดธนาคาร';
		}
		
?> 
<tr>
	<td class="c1"><?=$result['loanno'];?></td>
	<td class="c2"><?=$result['fundno'];?></td>
	<td class="c1"><?=$result['principle'];?></td>
	<td class="c2"><?=$result['timeloan'];?></td>
	<td class="c1"><?php echo $typeloan ;?></td>
	<td class="c2"><?=$result['createdate'];?></td>

</tr>
<?php
		}
	
	echo"</table></div><a href='../loan/'><?php echo$back;?></a>";
	}else{
setcookie('guatantee1');
setcookie('guatantee2');
$data1=$_POST['fundno'];
$data2=$_POST['principle'];
$data3=$_POST['timeloan'];
$data4=$_POST['typeloan'];
setcookie('fundno',$data1,time()+300);	
setcookie('principle',$data2,time()+300);		
setcookie('timeloan',$data3,time()+300);	
setcookie('typeloan',$data4,time()+300);	
header( "location: /brcb/loan/addmemberloan.php" );

	}		
}
?>

