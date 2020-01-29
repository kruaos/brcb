<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php 
session_start();
include('/library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="o")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
?>
<title><?=$title;?></title>
<?php 
			if ($_GET['fundno']==null){
?>
<div id="container">
<div id='tab'>ระบบค้นหายอดผู้กู้
</div>
<div id="tab"><form >
	<div id='menu'>กรอกข้อมูลสมาชิกที่ต้องการค้นหา</div>	
	<div id='content'><input "textbox" name='fundno'> <span id='red'>* กรอกรหัสเท่านั้น </span></div>
</div>
<div id="tab">
	<button type='submit' formaction='../office/ckkglt.php' id='btfind'></form>
</div>
<div id='tabb'>
<table  class="header" width="1000" align="center" >
<th colspan="10" > <?php echo $title;?> </th>
<tr>
	<td class="c1"><b>รหัสสมาชิก</td>
	<td class="c2"><b>ชื่อสกุล</td>
	<td class="c1"><b>จำนวนการค้ำ/ราย</td>
	<td class="c2"><b>ข้อมูลการค้ำ</td>
	<td class="c1"><b>จำนวนสัญญากู้</td>
	<td class="c2"><b>ข้อมูลการกู้</td>
</tr>
<?php 

	$sql="select a.fundno,a.pname,a.mname,a.lname,b.typeloan, b.guatantee1 ,b.guatantee2 
	from memberfund a, memberloan b where b.typeloan='1'and (a.fundno=b.guatantee1 or a.fundno=b.guatantee2) group by a.fundno ";
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$dbarr=mysqli_fetch_array($query);	
		if ($_GET['glt']==null){
		$fundno=$dbarr['fundno'];
		}else{
		$fundno=$_GET['glt'];
		}
		$fullname=$dbarr['pname'].$dbarr['mname']." ".$dbarr['lname'];
		$sql2="select count(guatantee1 or guatantee2) as 'sumglt' 
		from memberloan where statusloan='op' and (guatantee1=".$fundno." or guatantee2=".$fundno.")";
		$qurey2=mysqli_query($link,$sql2);
		$dbarr2=mysqli_fetch_array($qurey2);	
?>
<tr>
	<td class="c1"><?=sprintf('%04d',$dbarr['fundno'])?></td>
	<td class="c2"><?=$fullname;?></td>
	<td class="c1"><?=$dbarr2['sumglt']?></td>
	<td class="c2"><a href="../office/ckkglt.php? fundno=<?=$dbarr['fundno'];?>">รายละเอียด</a></td>
	<td class="c1"><?php 
	$suml="SELECT count(loanno) as 'suml'  from memberloan where fundno=".$dbarr['fundno']." and statusloan='op'";
	$qsuml=mysqli_query($link,$suml);
	$rsuml=mysqli_fetch_array($qsuml);	
		echo $rsuml['suml'];
	?></td>
	<td class="c2"><a href="../loan/addmemberloanload.php? fundno=<?=$dbarr['fundno'];?>">รายละเอียด</a></td>
</tr>
<?php 
		}
?>
</table>
</div>
<div id="tab">
<a href='../office/report.php'><?=$back?></a>
</div>
</div>
<?php
		}else{// ข้อผู้ค้ำรายบุคคล 
$fundno=$_GET['fundno'];	
if (!is_numeric($fundno)){
	echo "<span class='h1'><center> ป้อนรหัสเท่านั้น <br><a href='ckkglt.php'>$back</a>";
	
	
}else{

$sqlname="select a.pname,a.mname,a.lname from memberfund a where  fundno=".$fundno;
	$tname=mysqli_query($link,$sqlname);
	$result=mysqli_fetch_array($tname);
	$gltname=$result['pname'].$result['mname']." ".$result['lname'];	
?>
<div id='container'>
<div id='tab'>
<table  class="header" width="1000" align="center" >
<th colspan="10" > ข้อมูลการเป็นผู้ค้ำประกันเงินกู้ของ <?php echo $gltname;?> </th>
<tr>
	<td class="c1"><b>รหัสเงินกู้</td>
	<td class="c2"><b>ชื่อสกุล ผู้กู้</td>
	<td class="c1"><b>คนค้ำคนที่ 1</td>
	<td class="c2"><b>คนค้ำคนที่ 2</td>
	<td class="c1"><b>วงเงินค้ำประกัน</td>
</tr>
<?php 
	$sql="select b.guatantee1 ,b.guatantee2 ,b.loanno,b.principle
	from memberfund a, memberloan b where b.statusloan='op' and b.typeloan='1'and (a.fundno=b.guatantee1 or a.fundno=b.guatantee2) and a.fundno=".$fundno;
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$dbarr=mysqli_fetch_array($query);	
		$loanno=$dbarr['loanno'];
		$sqll="select a.pname,a.mname,a.lname from memberfund a, memberloan b where a.fundno=b.fundno and loanno='$loanno' ";	
		$queryl=mysqli_query($link,$sqll);
		$dbarrl=mysqli_fetch_array($queryl);
		$fullnamel=$dbarrl['pname'].$dbarrl['mname']." ".$dbarrl['lname'];?>
<tr>
	<td class="c1"><a href='../loan/reportlone.php? loanno=<?=$dbarr['loanno'];?>'><?=$dbarr['loanno'];?></a></td>
	<td class="c2"><?=$fullnamel;?></td>
	<td class="c1"><?php 
	$sqlg1="select a.pname,a.mname,a.lname from memberfund a where fundno=".$dbarr['guatantee1'];
	$qname=mysqli_query($link,$sqlg1);
	$gltname1=mysqli_fetch_array($qname);
	$gfullname1=$gltname1['pname'].$gltname1['mname']." ".$gltname1['lname'];
	echo $gfullname1;?></td>
	<td class="c2"><?php 
	$sqlg2="select a.pname,a.mname,a.lname from memberfund a where fundno=".$dbarr['guatantee2'];
	$qname=mysqli_query($link,$sqlg2);
	$gltname2=mysqli_fetch_array($qname);
	$gfullname2=$gltname2['pname'].$gltname2['mname']." ".$gltname2['lname'];
	echo $gfullname2;?></td >
	<td id="totel1"><?= number_format($dbarr['principle'],0,'.',',');?></td>
</tr>
<?php 
}
?>
</div></table>
<div id="tabb">
<a href='../office/ckkglt.php'><?=$back?></a>


</div>
</div>	

<?php 	
}
		}
		}	?>
	