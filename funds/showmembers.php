<meta charset="utf-8">
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php 
session_start();
include('/library.php'); include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="o")or($_SESSION['workroleid']=="f")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
		

?>
<?php include('/library.php'); include('../config/config.php'); ?>
<title><?php echo$title;?></title>
<body>
<div id='container'>
<div id='tab'><form>
	<div id='menu'>ค้นหาด้วยรายชื่อ </div>
	<div id='content'><input type='taxtbox' name='find'></div>
</div>
<div id='tab'>
<button id='btfind'>
</div> </form>
</div>

<table class="header" width="	1000" align="center" >
<th colspan="10"><?php echo$title;?> : ตารางสมาชิก</th>
<tr>	
<?php if ($_SESSION['workroleid']=='i'or $_SESSION['workroleid']=='a'){
	echo "<td class='c3'><b>แก้ไข</td>";	
}?>

	<td class="c1"><b>รหัส</td>
	<td class="c2"><b>ชื่อ สกุล</td>
	<td class="c1"><b>ประเภทสมาชิก</td>
	<td class="c2"><b>ที่อยู่</td>
	<td class="c1"><b>วันเกิด</td>
	<td class="c2"><b>วันที่ปรับปรุง</td>
	<td class="c1"><b>ยอดเงินบาท</td>

</tr>
<?php 
include('../config/config.php');
if($_GET['find']==null){
	$find="  ";
}else if(is_numeric($_GET['find'])){
	$find='and fundno='.$_GET['find'];
}else if(!is_numeric($_GET['find'])){
	$find="and mname like '".$_GET['find']."%'";
}

	$sql="SELECT * FROM memberfund where fundstatusid=1 and fundno<>0 $find order by fundno";
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		
	include('../config/config.php');
	$sql1="SELECT a.*, b.*,c.* FROM memberfund a, fundtype_result b, fundstatus_result c 
	where  a.fundtypeid=b.fundtypeid and a.fundstatusid=c.fundstatusid and a.fundno=".$result["fundno"] ;
	$query1=mysqli_query($link,$sql1);
	$dbarr=mysqli_fetch_array($query1);
	
	$sql2="SELECT sum(recivefunds) as 'sfund' FROM eventfund where fundno = " . $result["fundno"];
	$query2 = mysqli_query($link,$sql2);
	$sfund=mysqli_fetch_array($query2);	

		?> 
<tr>
	</td>	
<?php if ($_SESSION['workroleid']=='i'or $_SESSION['workroleid']=='a'){
	$editfund=$dbarr['fundno'];
	echo "	<td class='c3'><a href='editmember.php? fundno=$editfund'>แก้ไข</a></td>";	
}?>	
	
	<td class="c1"><a href="reportfone.php? fundno=<?=$result["fundno"]?>"><?php echo sprintf("%04d", $result["fundno"]);?></a></td>
	<td class="c2"><?=$result["pname"];?><?=$result["mname"];?> <?=$result["lname"];?></td>
	<td class="c1">	<?php 
	echo $dbarr["fundtypename"];
	?>
	</td>
	<td class="c2"><?=$result["address"];?></td>
	<td class="c1"><?=$result["birthday"];?></td>
	<td class="c2"><?=$result["lastupdate"];?></td>
	<td class="c1"><div id="totel1"><?php 
	echo number_format($sfund["sfund"],0,'.',',');
	?></div></tr>
<?php
		}
if (($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i")){$workroleid="admin";
 $addicon="<a href='addmember.php'>$add</a></div></div>";}else{ 
	if ($_SESSION['workroleid']=="f"){$workroleid="funds";}else if($_SESSION['workroleid']=="o"){$workroleid="office";}
	}
echo "</table><div id='container'><div id='tab'><a href=../".$workroleid."/>$back</a>"."  ";
echo $addicon; 
}?>

