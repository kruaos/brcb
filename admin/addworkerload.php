<?php 
session_start();
include('library.php'); include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="i")or($_SESSION['workroleid']=="o")or($_SESSION['workroleid']=="a"))){
			echo "ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>กรุณาล๊อกอิน</a> ";	
		}else{
?>
<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title><?php echo $title;?></title>
<div id="container">
<?php if ($_SESSION['workroleid']<>'o'){?>
<form name="ฝาก" method="post" action="addworker.php">
	<div id="header"><b><?php echo $title;?></b></div>
	<div id="tab">
		<div id="menu"><b>เพิ่มเจ้าหน้าที่</b></div>
		<div id="content"><input type="text" name="fundno" /><font color=red>* พิมพ์รหัสสมาชิก</div></b></div>
	<div id="tab">
	<?php if($_SESSION['workroleid']=='o'){$workrole="office";}else{$workrole="admin";}?>

		<button type="submit" value=" " name="send" id="btfind">
		<button type="submit" formaction="../<?=$workrole?>/" id="button2">	
		
</div></form>
<?php }?>	<div id="tab">
<table  class="header" width="1000" align="center" >
<th colspan="10" > <?php echo $title;?> </th>
<tr>
	<td class="c1"><b>รหัสสมาชิก</td>
	<td class="c2"><b>ชื่อสกุล</td>
	<td class="c1"><b>สิทธิเข้าถึง</td>
	<td class="c2"><b>username</td>
	<td class="c1"><b>password</td>
	<td class="c2"><b>สถานะ</td>
	<td class="c1"><b>วันที่ลงทะเบียน</td>
<?php  if ($_SESSION['workroleid']<>'o'){
	echo "<td class='c2'><b>แก้ไข</td>";
}?>

</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
include('../config/config.php');
// สูตร ค่อยทำแยกตามกรรมการ อ้างอิงตม sestion
	$sql="SELECT a.*,b.fundno,b.pname,b.mname, b.lname
	FROM worker a, memberfund b
	WHERE a.fundno=b.fundno and workroleid<>'a'
	ORDER BY createdate ";
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		$fullname=$result['pname'].$result['mname']."  ".$result['lname'];
	
		$sql2="SELECT a.*,b.*,c.* FROM worker a,workrole_result b, workstatus_result c 
		WHERE workno=".$result["workno"]." and a.workroleid = b.workroleid and a.workstatusid=c.workstatusid 
		ORDER BY workno";
		$query1=mysqli_query($link,$sql2);
		$dbarr=mysqli_fetch_array($query1);	  

		?> 
<tr>
	<td class="c1"><?php echo sprintf("%04d", $result["fundno"]);?></td>
	<td class="c2"><?php echo $fullname;?></td>
	<td class="c1"><?=$dbarr["rolename"];?></td>
	<td class="c2"><?=$result["user"];?></td>
	<td class="c1"><?=$result["password"];?></td>
	<td class="c2"><?php echo
$dbarr["workstatusname"];?></td>
	<td class="c1"><?=$result["createdate"];?></td>
<?php  if ($_SESSION['workroleid']<>'o'){
		$workno=$result['workno'];
	echo "<td class='c2'><a href='editworker.php? workno=$workno'>แก้ไข</a></td>";
}

?>
</tr>
 <?php

		}
		}
if ($_SESSION['workroleid']=='o'){$workrole="office";}
 echo "</table></div>
 <div id='tab'><a href='../$workrole/'>$back</a></div>
 </div>";
?>

