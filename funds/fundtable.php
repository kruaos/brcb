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