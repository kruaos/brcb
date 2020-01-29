<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php 
session_start();
include('/library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="l")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
?>


<title><?=$title;?></title>
<div id="container">
<form name="โหลดถอน" method="post" action="loanpayment.php">
	<div id="header"><?=$title;?> : ชำระสินเชื่อ</div>
	<div id="tab">
		<div id="menu">รหัสสมาชิก</div>
		<div id="content"><input type="text" name="loanno" />
		  <input type="submit" name="send" value="ค้นหา" /></div>
</form>	</div>
</div>

<br>

<table class="header" width="1000" align="center" >
<th  colspan="10"  > <?=$worktitle;?> </th>
<tr>
	<td class="c1">รหัสเงินกู้</td>
	<td class="c1">ชำระเงินต้น</td>
	<td class="c1">ชำระดอกเบี้ย</td>
	<td class="c1">ยอดชำระรวม</td>
	<td class="c1">งวดที่</td>
	<td class="c1">วันที่ทำรายการ</td>
	<td class="c1">สถานะ</td>

</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
include('../config/config.php');
// สูตร ค่อยทำแยกตามกรรมการ อ้างอิงตม sestion
$workno=$_SESSION['workno'];
	$sql="SELECT * FROM eventloan where workerid=$workno and substr(createdate,6,2)=".date("m");
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		$amount =$result["payment"]+$result["reciveinterest"];
		if ($result['code']=='ac'){
			$color="class='c5'";
		}else{
			$color="class='c2'";
		}
		
	?> 
<tr>
	<td <?=$color;?>><?=$result["loanno"];?></td>
	<td <?=$color;?>><?=$result["payment"];?></td>
	<td <?=$color;?>><?=$result["reciveinterest"];?></td>
	<td <?=$color;?>><?php echo $amount;?></td>
	<td <?=$color;?>><?=$result["loantime"];?></td>
	<td <?=$color;?>><?=$result["createdate"];?></td>
	<td <?=$color;?>><?php 
	$code=$result['code'];
	include('../config/config.php');
		$sql1="SELECT * FROM evcode where codeid='$code'";
			$query1=mysqli_query($link,$sql1);
			$dbarr=mysqli_fetch_array($query1);
		echo $dbarr['codename'];
	?></td>

</tr>


<?php
}
if (($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i")){$workroleid="admin";}else{$workroleid="loan";}
echo "</table><div id='container'><div id='tab'><a href=../".$workroleid."/>$back</a></div></div>";}

		
?>  
