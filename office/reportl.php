<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php 
session_start();
include('/library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="o")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
?>

<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title><?=$title;?> : ตารางสรุป</title>
<div id="container">
<?php 
include('../config/config.php');
$user=$_GET['user'];
	$sql1="SELECT a.*,b.pname, b.mname, b.lname,b.fundno FROM worker a, memberfund b where a.fundno=b.fundno and user='$user'";
	$query1=mysqli_query($link,$sql1);
	$worker=mysqli_fetch_array($query1);
	$wfullname=$worker['pname'].$worker['mname']."  ".$worker['lname'];
?>
<div id="container">
<table  class="header" width="1000" align="center" >
<tr><th colspan="10" > <?=$worktitle." วันที่ ".date("Y-m-d");?> : ฝ่ายสินเชื่อ เงินกู้  </th></tr>
<tr><th colspan="10" > <?php echo $wfullname."  รหัสเจ้าหน้าที่ ".sprintf('%04d',$worker['workno']); ?>   </th></tr>
<tr>
	<td class="c1">รหัสสมาชิก</td>
	<td class="c2">ยอดชำระเงินกู้</td>
	<td class="c1">ยอดดอกเบี้ย</td>
	<td class="c2">งวดที่</td>
	<td class="c1">วันที่ฝาก</td>
	<td class="c2">ประเภท</td>

</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
include('../config/config.php');
$workno=$worker['workno'];
if ($_GET['report']==day){
	$set1=$day;
	$set2=date("d");
}else if ($_GET['report']=='month'){
	$set1=$month;
	$set2=date("m");
}

	$sql="SELECT * FROM eventloan where workerid=$workno and $set1=$set2";
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		
	$sql1="SELECT a.*,b.* FROM eventloan a , evcode b 
	where a.code = b.codeid  and num = " .$result['num'];
	$query1 = mysqli_query($link,$sql1);
	$dbarr=mysqli_fetch_array($query1);		
	if ($dbarr['code']=='pa'){
		$color="class='c6'";
	}else if($dbarr['code']=='ac'){
		$color="class='c5'";
	}
	
?> 

<tr>
	<td <?=$color;?>><?=$result["loanno"];?></td>
	<td <?=$color;?>><span id='totlel1'><?=$result["payment"];?></span></td>
	<td <?=$color;?>><?=$result["reciveinterest"];?></td>
	<td <?=$color;?>><?=$result["loantime"];?></td>
	<td <?=$color;?>><?=$result["createdate"];?></td>
	<td <?=$color;?>><?=$dbarr["codename"];?></td>

</tr>
<?php
		}
if (($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i")){$workroleid="admin";}else{$workroleid="office/report.php";}
echo "</table><div id='container'><div id='tab'><a href=../$workroleid>$back</a></div></div>";}
?>