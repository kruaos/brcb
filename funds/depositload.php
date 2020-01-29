<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php 
session_start();
include('/library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="f")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
?>

<meta charset=utf8>
<title><?=$title;?> : ตารางฝากเงิน</title>
<div id="container">
<form name="ฝาก" method="post" action="deposit.php">
	<div id="header"><?=$title;?> : ตารางฝากเงิน </div>
	<div id="tab">
		<div id="menu">รหัสสมาชิก</div>
		<div id="content"><input type="text" name="fundno" />
		  <input type="submit" name="send" value="ค้นหา" /></div>
</form>	</div>
</div>

<br>
<div id="container">
<table  class="header" width="1000" align="center" >
<th colspan="10" > <?=$worktitle." วันที่ ".date("Y-m-d");?></th>
<tr>
	<td class="c1">รหัสสมาชิก</td>
	<td class="c2">เงินสัจจะ</td>
	<td class="c1">เงิน พชพ</td>
	<td class="c2">รหัสเจ้าหน้าที่</td>
	<td class="c1">วันที่ฝาก</td>
	<td class="c2">ประเภท</td>

</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
include('../config/config.php');
// สูตรแยกตามกรรมการ อ้างอิงตาม sestion
$workno=$_SESSION['workno'];
		$sql="SELECT * FROM eventfund where workerid=$workno and substr(createdate,9,2)=".date("d");
	$query=mysqli_query($link,$sql);
	
	
	//ใช้ numrows ในการนับแถว
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		
	$sql1="SELECT a.*,b.* FROM eventfund a , evcode b where a.code = b.codeid and num = " .$result['num'];
	$query1 = mysqli_query($link,$sql1);
	$dbarr=mysqli_fetch_array($query1);
	if ($dbarr['code']=='wi'){	$code="red";}else{$code="black";}
	
?> 
<tr>
	<td class="c1"><font color="<?=$code;?>"><?=sprintf("%04d",$result["fundno"]);?></font></td>
	<td class="c2"><font color="<?=$code;?>"><?=$result["recivefunds"];?></font></td>
	<td class="c1"><font color="<?=$code;?>"><?=$result["reciveinsurance"];?></font></td>
	<td class="c2"><font color="<?=$code;?>"><?=sprintf("%04d",$result["workerid"]);?></font></td>
	<td class="c1"><font color="<?=$code;?>"><?=$result["createdate"];?></font></td>
	<td class="c2"><font color="<?=$code;?>"><?=$dbarr["codename"];?></font></td>

</tr>
<?php
}
if (($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i")){$workroleid="admin";}else{$workroleid="funds";}
echo "</table><div id='container'><div id='tab'><a href=../".$workroleid."/>$back</a></div></div>";}
?>  
