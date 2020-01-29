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
<title><?=$title;?> : ตารางสรุป</title>
<div id="container">
<div id="container">
<table  class="header" width="1000" align="center" >
<th colspan="10" > <?=$worktitle." วันที่ ".date("Y-m-d");?> : ตารางสรุป</th>
<tr>
	<td class="c7"><b>รหัสสมาชิก</td>
	<td class="c7"><b>ยอดชำระเงินกู้</td>
	<td class="c7"><b>ยอดดอกเบี้ย</td>
	<td class="c7"><b>งวดที่</td>
	<td class="c7"><b>วันที่ฝาก</td>
	<td class="c7"><b>ประเภท</td>

</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
include('../config/config.php');
// สูตร ค่อยทำแยกตามกรรมการ อ้างอิงตม sestion
$workno=$_SESSION['workno'];
	$sql="SELECT * FROM eventloan where workerid=$workno and $day=".date("d");
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		
	$sql1="SELECT a.*,b.* FROM eventloan a , evcode b 
	where a.code = b.codeid  and num = " .$result['num'];
	$query1 = mysqli_query($link,$sql1);
	$dbarr=mysqli_fetch_array($query1);		
	if ($dbarr["codeid"]=='ac'){
		$color="class='c3'";
	}else{
		$color="class='c1'";
	}
?> 

<tr>
	<td <?=$color;?>><?=$result["loanno"];?></td>
	<td <?=$color;?>><?=$result["payment"];?></td>
	<td <?=$color;?>><?=$result["reciveinterest"];?></td>
	<td <?=$color;?>><?=$result["loantime"];?></td>
	<td <?=$color;?>><?=$result["createdate"];?></td>
	<td <?=$color;?>><?=$dbarr["codename"];?></td>

</tr>
<?php
		}
if (($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i")){$workroleid="admin";}else{$workroleid="loan";}
echo "</table><div id='container'><div id='tab'><a href=../".$workroleid."/>$back</a></div></div>";}
?>