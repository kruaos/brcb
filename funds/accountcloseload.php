<?php 
session_start();
include('/library.php'); include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="f")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
?>

<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 

<title>ตารางปิดบัญชี ออมทรัพย์สัจจะ</title>
<div id="container">
<form name="form1" method="post" action="accountclose.php">
	<div id="header">ตารางปิดบัญชี ออมทรัพย์สัจจะ</div>
	<div id="tab">
		<div id="menu">รหัสสมาชิก</div>
		<div id="content"><input type="text" name="fundno" />
		  <input type="submit" name="send" value="ค้นหา" /></div>
</form>	</div>
</div>
<br>
<table  width="1000" align="center" class="header">
<th  colspan="10"> ตารางสมาชิก ออมทรัพย์สัจจะ </th>
<tr>
	<td class="c1">รหัส</td>
	<td class="c2">ชื่อ สกุล</td>
	<td class="c1">บัตรประชาชน</td>

	<td class="c1">วันที่ปรับปรุง</td>
	<td class="c2">ประเภทสมาชิก</td>
	<td class="c1">สถานะ</td>
</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
include('../config/config.php');
	$sql="SELECT * FROM memberfund where fundstatusid=3 or fundstatusid=2 ";
	$query=mysqli_query($link,$sql);
	
	//ใช้ numrows ในการนับแถว
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
	include('../config/config.php');
	$sql1="SELECT a.*, b.*,c.* FROM memberfund a, fundtype_result b, fundstatus_result c 
	where a.fundtypeid=b.fundtypeid and  a.fundstatusid=c.fundstatusid and a.fundno=".$result["fundno"];
	$query1=mysqli_query($link,$sql1);
	$dbarr=mysqli_fetch_array($query1);
	
		?> 
<tr>
	<td class="c1"><?=sprintf('%04d',$result["fundno"]);?></td>
	<td class="c2"><?=$result["pname"];?><?=$result["mname"];?> <?=$result["lname"];?></td>
	<td class="c1"><?=$result["idcard"];?></td>
	<td class="c1"><?=$result["lastupdate"];?></td>
	<td class="c2"><?php echo $dbarr["fundtypename"];?></td>
	<td class="c1"><?php echo $dbarr["fundstatusname"];;?></td>

</tr>


<?php
		}
 
if (($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i")){$workroleid="admin";}else{$workroleid="funds";}
echo "</table><div id='container'><div id='tab'><a href=../".$workroleid."/>$back</a></div></div>";}
?> 