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
<tr><th colspan="10" > <?=$worktitle." วันที่ ".date("Y-m-d");?> : ฝ่ายออมทรัยพ์สัจจะ  </th></tr>
<tr><th colspan="10" > <?php echo $wfullname."  รหัสเจ้าหน้าที่ ".sprintf('%04d',$worker['workno']); ?>   </th></tr>
<tr>
	<td class="c1"><b>รหัสสมาชิก</td>
	<td class="c2"><b>เงินสัจจะ</td>
	<td class="c1"><b>เงิน พชพ</td>
	<td class="c2"><b>ชื่อสมาชิก</td>
	<td class="c1"><b>วันที่/ เวลา ที่ทำรายการ</td>
	<td class="c2"><b>ประเภท</td>

</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
include('../config/config.php');
// สูตร ค่อยทำแยกตามกรรมการ อ้างอิงตม sestion
if ($_GET['report']==day){
	$set1=$day;
	$set2=date("d");
}else if ($_GET['report']=='month'){
	$set1=$month;
	$set2=date("m");
}

	$sql="SELECT * FROM eventfund where workerid=".$worker['workno']." and $set1=$set2 order by createdate";
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		
	$sql1="SELECT a.*,b.*,c.* FROM eventfund a , evcode b , memberfund c
	where a.code = b.codeid and a.fundno=c.fundno and num = " .$result['num'];
	$query1 = mysqli_query($link,$sql1);
	$dbarr=mysqli_fetch_array($query1);	
	$fullname=$dbarr['pname'].$dbarr['mname']."  ".$dbarr['lname'];
	if ($result['code']=='wi'){	$code="red";}else{$code="black";}

?> 

<tr >
	<td class="c1"><font color="<?=$code;?>"><?= sprintf("%04d", $result["fundno"]);?></font></td>
	<td class="c2"><font color="<?=$code;?>"><?=$result["recivefunds"];?></font></td>
	<td class="c1"><font color="<?=$code;?>"><?=$result["reciveinsurance"];?></font></td>
	<td class="c2"><font color="<?=$code;?>"><?=$fullname;?></font></td>
	<td class="c1"><font color="<?=$code;?>"><?=$result["createdate"];?></font></td>
	<td class="c2"><font color="<?=$code;?>"><?=$dbarr["codename"];?></font></td>

</tr>
<?php
echo"</font>";
		}
if (($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i")){$workroleid="admin";}else{$workroleid="office/report.php";}
echo "</table><div id='container'><div id='tab'><a href=../".$workroleid.">$back</a></div></div>";}
?>