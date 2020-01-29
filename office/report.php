<link rel="stylesheet" href="../config/css1.css" type="text/css" />
<?php 
session_start(); include('/library.php'); include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="o")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
	
	if ($_GET['report']==null){
	$set1=$day;
	$set2=date('d');
	$set3="ประจำวันที่  ".date("d/m/Y");
	}else if ($_GET['report']=="month"){
	$set1=$month;
	$set2=date('m');
	$set3="ประจำเดือน  ".date('m');
	}else if ($_GET['report']=="day"){
	$set1=$day;
	$set2=date('d');
	$set3="ประจำวันที่  ".date("d/m/Y");}	
			
?>
<meta charset=utf8>
<title><?=$title;?> : ตารางสรุป</title>
<div id="container">
<div id="header"><b>
<?php echo $title." : สรุปภาพรวม  ".$set3;?>
</div>
<?//  ตารางเจ้าหน้าที่ สัจจะ ?>
<div id="tab">
<table class="header" width="1000" >
<th colspan="6" align="left" >ตารางสรุป เจ้าหน้าที่ฝ่ายออมทรัพย์สัจจะ</th>
<tr>
	<td class="c1"><b>ลำดับที่</td>
	<td class="c2"><b>รหัสผู้ใช้</td>
	<td class="c1"><b>ชื่อเจ้าหน้าที่</td>
	<td class="c2"><b>สรุปยอดรายรับ/บาท</td>
	<td class="c3"><b>สรุปยอดจ่าย/บาท</td>
	<td class="c2"><b>จำนวนรายที่ให้บริการ</td>
</tr>
<?php

	
include('../config/config.php');
	$sql="SELECT a.*,b.* FROM worker a,memberfund b where a.fundno=b.fundno and workstatusid='1' and workroleid='f'";
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		$fullname=$result['pname'].$result['mname']."  ".$result['lname'];$workno=$result['workno'];
		$sql1="sELECT sum(recivefunds) as 'sdep' FROM eventfund where code='de' and workerid =$workno and $set1='$set2'";
		$query1=mysqli_query($link,$sql1);
		$sdep=mysqli_fetch_array($query1);	
		$sql2="sELECT sum(recivefunds) as 'swit' FROM eventfund where code='wi' and workerid =$workno and $set1='$set2'";
		$query2=mysqli_query($link,$sql2);
		$swit=mysqli_fetch_array($query2);
		$sql3="sELECT count(code) as 'suse' FROM eventfund where workerid =$workno and $set1='$set2'";
		$query3=mysqli_query($link,$sql3);
		$suse=mysqli_fetch_array($query3);
if ($_GET['report']<>null){
	$setreport=$_GET['report'];	
}else{
	$setreport="day";	
}
			
  ?>
<tr>
	<td class="c1"><?=$i;?></td>
	<td class="c2"><a href="reportf.php? user=<?=$result['user'].'& report='.$setreport;?>"><?=$result['user'];?></a></td>
	<td class="c1"><?=$fullname;?></td>
	<td class="c2"><?php echo number_format($sdep['sdep'],2,'.',',');?> บาท</td>
	<td class="c3"><?php echo number_format($swit['swit'],2,'.',',');?> บาท</td>
	<td class="c2"><?=$suse['suse'];?> ราย </td>
</tr>
</div>
<?php }
?>	
<div id="tab">
<table class="header" width="1000" >
<th colspan="7" align="left" >ตารางสรุป เจ้าหน้าที่ฝ่ายสินเชื่อ</th>
<tr>
	<td class="c1"><b>ลำดับที่</td>
	<td class="c2"><b>รหัสผู้ใช้</td>
	<td class="c1"><b>ชื่อเจ้าหน้าที่</td>
	<td class="c2"><b>ยอดรับเงินกู้/บาท</td>
	<td class="c1"><b>ยอดดอกเบี้ยรับ/บาท</td>
	<td class="c2"><b>ยอดรวมปิดบัญชี</td>
	<td class="c1"><b>จำนวนรายที่ให้บริการ</td>
</tr>
<?php
include('../config/config.php');
	$sql="SELECT a.*,b.* FROM worker a,memberfund b where a.fundno=b.fundno and workstatusid='1' and workroleid='l'";
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		$fullname=$result['pname'].$result['mname']."  ".$result['lname'];$workno=$result['workno'];
		$sql1="sELECT sum(payment) as 'sdep',sum(reciveinterest) as 'sint'FROM eventloan where code='pa' and workerid =$workno and $set1='$set2'";
		$query1=mysqli_query($link,$sql1);
		$sdep=mysqli_fetch_array($query1);	
		$sql2="sELECT count(code) as 'sac' FROM eventloan where code='ac' and workerid =$workno and $set1='$set2'";
		$query2=mysqli_query($link,$sql2);
		$sac=mysqli_fetch_array($query2);
		$sql3="sELECT count(code) as 'suse' FROM eventloan where workerid =$workno and $set1='$set2'";
		$query3=mysqli_query($link,$sql3);
		$suse=mysqli_fetch_array($query3);		
  ?>
<tr>
	<td class="c1"><?=$i;?></td>
	<td class="c2"><a href="reportl.php? user=<?=$result['user'].'& report='.$setreport;?>"><?=$result['user'];?></a></td>
	<td class="c1"><?=$fullname;?></td>
	<td class="c2"><?php echo number_format($sdep['sdep'],2,'.',',');?> บาท</td>
	<td class="c1"><?php echo number_format($sdep['sint'],2,'.',',');?> บาท</td>
	<td class="c2"><?php echo $sac['sac'];?> ราย</td>
	<td class="c1"><?=$suse['suse'];?> ราย </td>
</tr>
</div>	

<?php	
		}
if (($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i")){$workroleid="admin";}else{$workroleid="office";}
if ($_GET['report']==month){$btn=$sumd;$go="? report=day";}else{$btn=$summ;$go="? report=month";}
echo "</table><div id='container'><div id='tab'><a href='report.php$go'>$btn</a> <a href=../".$workroleid."/>$back</a> <a href='../office/ckkglt.php'>$glt</a></div></div>";
}
?>