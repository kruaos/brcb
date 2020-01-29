<?php 
session_start();
include('/library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="f")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
$sql="select a.pname,a.mname,a.lname,c.rolename 
from memberfund a, worker b, workrole_result c
where b.workroleid=c.workroleid and a.fundno=b.fundno and b.workno=".$_SESSION['workno'];			
$query=mysqli_query($link,$sql);
$dbarr=mysqli_fetch_array($query);				
?>

<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title><?=$title;?> : ตารางสรุป</title>
<div id="container">
<div id="container">
<div id='titlebar'>
<b>ข้อมูลการส่งเงินฝาก ของ </b> <?php echo $dbarr['pname'].$dbarr['mname']."  ".$dbarr['lname'];?><br>
<b>ตำแหน่ง </b><?=$dbarr['rolename'];?>
</div>
<table  class="header" width="1000" align="center" >
<th colspan="10" > <?=$worktitle." วันที่ ".date("Y-m-d");?> : ตารางสรุป</th>
<tr>
	<td class="c1"><b>รหัสสมาชิก</td>
	<td class="c2"><b>ชื่อสมาชิก</td>
	<td class="c1"><b>ประเภท</td>
	<td class="c2"><b>วันที่/ เวลา ที่ทำรายการ</td>
	<td class="c1"><b>เงินสัจจะ/บาท</td>
	<td class="c2"><b>เงิน พชพ/บาท</td>

</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
include('../config/config.php');
// สูตร ค่อยทำแยกตามกรรมการ อ้างอิงตม sestion
$workno=$_SESSION['workno'];

	$sql="SELECT * FROM eventfund where workerid=$workno and $day=".date('d')." order by createdate";
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
	<td class="c2"><font color="<?=$code;?>"><?=$fullname;?></font></td>
	<td class="c1"><font color="<?=$code;?>"><?=$dbarr["codename"];?></font></td>
	<td class="c2"><font color="<?=$code;?>"><?=$result["createdate"];?></font></td>
	<td class="c1"><font color="<?=$code;?>"><?=$result["recivefunds"];?></font></td>
	<td class="c2"><font color="<?=$code;?>"><?=$result["reciveinsurance"];?></font></td>

</tr>
<?php
	}
	
	$sql2="SELECT sum(recivefunds) as 'sfun', sum(reciveinsurance) as 'sins' FROM eventfund where workerid=$workno and $day=".date('d')." order by createdate";
	$query2=mysqli_query($link,$sql2);
	$sum=mysqli_fetch_array($query2);	  

	?>
	
<tr>
	<td class="c6"><b></td>
	<td class="c6"><b></td>
	<td class="c6"><b></td>
	<td class="c4"><b>สรุปยอดเงิน</td>
	<td id="totel1" ><b><?=number_format($sum['sfun'],2,'.',',');?></font></td>
	<td id="totel1"><b><?=number_format($sum['sins'],2,'.',',');?></td>
</tr>	
<?php
if (($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i")){$workroleid="admin";}else{$workroleid="funds";}
echo "</table><div id='container'><div id='tab'><a href=../".$workroleid."/>$back</a></div></div>";}
?>