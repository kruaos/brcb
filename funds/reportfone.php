<?php 
session_start();
include('/library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="f")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
?>

<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title><?=$title;?> : ตารางสรุป</title>
<div 
id="container">
<div id='tab'>
<?php $fundno=$_GET['fundno'];
include('../config/config.php');
	$sql = "select * from memberfund where fundno = '$fundno';";
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
		$fullname=$dbarr["pname"].$dbarr["mname"]."  ".$dbarr["lname"] ;
?>


<table  class="header" width="1000" align="center" ><tr>
<th colspan="10" > ข้อมูลการฝากเงินของ <?=$fullname; ?> </th></tr>
<tr><th  colspan="10">รหัสสมาชิก <?php echo sprintf('%04d',$fundno);?></th></tr>
<tr>
	<td class="c1"><b>รหัสสมาชิก</td>
	<td class="c2"><b>เงินสัจจะ</td>
	<td class="c1"><b>เงิน พชพ</td>
	<td class="c2"><b>รหัสเจ้าหน้าที่</td>
	<td class="c1"><b>วันที่ฝาก</td>
	<td class="c2">ประเภท</td>

</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
include('../config/config.php');
// สูตร ค่อยทำแยกตามกรรมการ อ้างอิงตม sestion

	$sql="SELECT * FROM eventfund where fundno=".$fundno;
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

</div>
<?php
echo"</font>";
		}
if (($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i")){$workroleid="admin";}else{$workroleid="funds";}
echo "</table><div id='container'><div id='tab'><a href=../".$workroleid."/>$back</a></div></div>";}
?>