<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php //หน้าสมัครสมาชิกเงินกู้ หน้าแรก 
session_start();
include('/library.php'); include('../config/config.php'); 
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="l")or($_SESSION['workroleid']=="o")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br><a href='http://localhost/brcb/index.php'>".$login."</a> ";	
	}else{
if (!isset($_GET['fundno'])){
	if(($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i")){
?>
<meta charset=utf8>
<title><?=$title;?> : สมัครสมาชิก</title>
<div id="container">

<form name="เปิดบัญชี" method="get" action='addmemberloan.php?'>
	<div id="header"><?=$title;?> : เพิ่มข้อมูลสมาชิก</div>
	<div id="tab">
		<div id="menu">รหัสสมาชิก</div>
		<div id="content"><input type="text" name="fundno" /></div>
	</div>
	<div id="tab">
		<div id="menu">วงเงินกู้</div>
		<div id="content"><input type="text" name="principle" />บาท</div>
	</div>
	<div id="tab">
		<div id="menu">จำนวนเดือนชำระ</div>
		<div id="content"><input type="text" name="timeloan">งวด</div>
	</div>
	<div id="tab">
		<div id="menu">ประเภทหลักทรัพย์</div>
		<div id="content">
			<input name="typeloan" type="radio" value="1" checked >คนค้ำประกัน
			<input name="typeloan" type="radio" value="2"  >หลักทรัพย์
			<input name="typeloan" type="radio" value="3"  >บัญชีเงินฝาก
		</div>
	</div>
	<div id='tab'>
	<button type="submit" id='button'/>
<?php if ($_SESSION['workroleid']=='l'){$workrole="loan";}else{$workrole="admin";}	?>
	<button type="submit" formaction="../<?=$workrole?>/" id="btback">	
	</div></form>
</div>
<?php
}else{
// ค่าว่าง สำหรับ การกรอกข้อมูลหากไม่ใช่กรรมการ
}
?>
<div id="container">
<div id='tab'><form>
	<div id='menu'>ค้นหาด้วยรายชื่อ </div>
	<div id='content'><input type='taxtbox' name='find'></div>
</div>
<div id='tab'>
<button id='btfind'>
<button id='btaccs2' name='status' value='ac' ></form>
</div> 

<table class="header" width="1000" align="center" >
<th colspan="10" > <?=$title;?> : ข้อมูลสมาชิกเงินกู้  คงค้าง </th>
<tr >
	<td class="c1">รหัสเงินกู้</td>
	<td class="c1">ชื่อ - สกุล</td>
	<td class="c1">จำนวนเงินกู้</td>
	<td class="c1">จำนวนเดือน</td>
	<td class="c1">ประเภทหลักทรัพย์</td>
	<td class="c1">วันที่สมัคร</td>
	
</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
if (!$_GET[fundno]==null){
	$sort="and a.fundno=".$_GET[fundno];
}
include('../config/config.php');
// สูตร ค่อยทำแยกตามกรรมการ อ้างอิงตม sestion
if($_GET['find']==null){
	$find="  ";
}else if(is_numeric($_GET['find'])){
	$find="and a.loanno like '".$_GET['find']."%'";
}else if(!is_numeric($_GET['find'])){
	$find="and b.mname like '".$_GET['find']."%'";
}
if($_GET['status']==ac){
	$status='ac';
}else{
	$status='op';

}
	$sql="SELECT a.*,b.* FROM  memberloan a, memberfund b where a.fundno=b.fundno and statusloan='$status' $sort $find order by a.createdate  ";
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
			$sql1="select loantypename from loantype_result where loantypeid=".$result['typeloan'];
			$query1=mysqli_query($link,$sql1);
			$loantype=mysqli_fetch_array($query1);	
		$fullname=$result['pname'].$result['mname']."  ".$result['lname'];
		if($result['typeloan']==1){
			$color='class=c4';	
		}else if($result['typeloan']==2){
			$color='class=c5';	
		}else{
			$color='class=c6';	
		}
		
		?> 
<tr>
	<td <?=$color;?>><a href="../loan/reportlone.php? loanno=<?=$result['loanno'];?>"><?=$result['loanno'];?></td>
	<td <?=$color;?>><?=$fullname;?></td>
	<td <?=$color;?>><?=number_format($result['principle'],'0','.',',');?></td>
	<td <?=$color;?>><?=$result['timeloan'];?></td>
	<td <?=$color;?>><?=$loantype['loantypename'] ;?></td>
	<td <?=$color;?>><?=$result['createdate'];?></td>

</tr>
<?php
	}	

if (!$_GET[fundno]==null){
	echo "</table><div id='tab'><a href='javascript:history.back();'>$back</a></div>";
}else if ($_SESSION['workroleid']=="l"){
	echo "</table><div id='tab'><a href='../loan/'>$back</a></div>";
}else if($_SESSION['workroleid']=="o"){
	echo "</table><div id='tab'><a href='../office/'>$back</a></div>";
}	
	}	
	}
	
?>