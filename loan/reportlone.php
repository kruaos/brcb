<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php 
session_start();
include('/library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="l")or($_SESSION['workroleid']=="o")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
$loanno=$_GET['loanno'];
include('../config/config.php');
	$sql="SELECT a.*,b.pname,b.mname,b.lname FROM memberloan a, memberfund b where a.fundno=b.fundno and loanno = '".$loanno."' ";
	$query=mysqli_query($link,$sql);
	$dbarr=mysqli_fetch_array($query);	
	$fullname=$dbarr["pname"].$dbarr["mname"]."  ".$dbarr["lname"]
?>

<meta charset=utf8>
<title>ระบบสินเชื่อ(คืนเงินกู้)</title>
<div id="container">
<div id="header"><b>รายละเอียดผู้กู้ ของ <?=$fullname?></b></div>
<div id="tab">
<div id="tab">
	<div id="menu">สัญญาเลขที่</div>
	<div id="content"><input type="text" name="loanno"  value="<?php echo $dbarr['loanno'];?>" readonly /></div>
</div>
<div id="tab">
	<div id="menu">ข้อมูลสมาชิก</div>
	<div id="content"><?php echo$fullname ;?></div>
</div>
<div id="tab">
	<div id="menu">รหัสสมาชิก</div>
	<div id="content"><input type="text" value="<?php echo sprintf('%04d',$dbarr['fundno']);?>" name="fundno" readonly /></div>
</div>
<div id="tab">
	<div id="menu">จำนวนเงินกู้</div>
	<div id="content"><input type="text" value="<?php echo $dbarr['principle'];?>" name="principle" readonly />บาท</div>
</div>
<div id="tab">
	<div id="menu">จำนวนงวดชำระ</div>
	<div id="content"><input type="text" value="<?php echo$dbarr['timeloan'];?>" name="timeloan" readonly />งวด</div>
</div>
<div id="tab">
	<div id="menu">ดอกเบี้ย</div>
	<div id="content">
<?php
	if ($dbarr['fundno']<>$fundno){
	echo "<input name='interestloan' type='radio' value='1' checked > ปกติ<br />";	
	}else{
	echo "<input name='interestloan' type='radio' value='0.5' checked > คณะกรรมการ<br />";		
	}
?>	
</div>
<div id="tab">
<!-- ประเภทหลักทรัพย์ เขียน แบบ PHP !-->
<?php  
$typeloan=$dbarr['typeloan'];
$guatantee1=$dbarr['guatantee1'];
$guatantee2=$dbarr['guatantee2'];
if (($typeloan)==1){
	echo "	
	<div id='tab'>
		<div id='menu'> ประเภทหลักทรัพย์</div>
		<div id='content'><input name='typeloan' type='radio' value='1' checked > ประเภทคนค้ำประกัน</div>
	</div>
	<div id='tab'>		
		<div id='menu'>เลขสมาชิก คนค้ำคนที่ 1</div>";
	if($guatantee1==null){	
		echo"
		<div id='content'> <input type='text' name='guatantee1' /></div>";
	}else{
		include('../config/config.php');
		$sql1 = "select * from memberfund where fundno =".$guatantee1;
			$result1 = mysqli_query($link, $sql1);
			$dbarr1 = mysqli_fetch_array($result1);			
			echo"
		<div id='content'> <input type='text' name='guatantee1' value='".sprintf('%04d',$guatantee1)."'/>
			".$dbarr1['pname'].$dbarr1['mname']."  ".$dbarr1['lname']."
		</div></div>";
	}
	echo "	
	<div id='tab'>	
		<div id='menu'>เลขสมาชิก คนค้ำคนที่ 2</div> ";
	if($guatantee2==null){	
		echo"
		<div id='content'> <input type='text' name='guatantee2' /></div>";
	}else{
		include('../config/config.php');
		$sql1 = "select * from memberfund where fundno =".$guatantee2;
			$result1 = mysqli_query($link, $sql1);
			$dbarr1 = mysqli_fetch_array($result1);			
			echo"
	<div id='content'> <input type='text' name='guatantee2' value='".sprintf('%04d',$guatantee2)."'/>
			".$dbarr1['pname'].$dbarr1['mname']."  ".$dbarr1['lname']."
	</div>
	</div>";
	}
}else if(($typeloan)==2){
	echo "
	<div id='tab'>
		<div id='menu'>ประเภทหลักทรัพย์</div>
		<div id='content'><input name='typeloan' type='radio' value='2' checked >ประเภทหลักทรัพย์ค้ำประกัน</div>
	</div>
	<div id='tab'>		
		<div id='menu'>รายละเอียด </div>
		<div id='content'><textarea name='collateral'/></textarea><br></div>
	</div>";
	
}else if(($typeloan)==3){
	echo"
	<div id='tab'>
		<div id='menu'>ประเภทหลักทรัพย์</div>
		<div id='content'><input name='typeloan' type='radio' value='3' checked > ประเภทสมุดธนาคารค้ำประกัน</div>
	</div>
	<div id='tab'>		
		<div id='menu'> เลขบัญชี </div>	
		<div id='content'><input type='text' name='bookbank' /></div>
	</div>";
}else{
	echo "ผิดพลาด <a href='http://localhost/brcb/loan/addmemberloanload.php'>ย้อนกลับ</a>";
};?>
</div>
<div id="tab">
	<div id="menu">ทำรายการวันที่ / เวลา </div>
	<div id="content">        
	<input type="text" value="<?php echo date("Y-m-d H:i:s")?>">   
	</div>
</div>
</div>
<div id="tabb">
<table class="header" width="1000" align="center" >
<th  colspan="10"  > ตารางถอนเงินออมทรัพย์สัจจะ </th>
<tr>
	<td class="c1">รหัสเงินกู้</td>
	<td class="c2">ชำระเงินต้น</td>
	<td class="c1">ชำระดอกเบี้ย</td>
	<td class="c2">ยอดชำระรวม</td>
	<td class="c1">งวดที่</td>
	<td class="c2">วันที่ทำรายการ</td>
	<td class="c1">สถานะ</td>
</tr>
<?php 
	$sql="SELECT * FROM eventloan where loanno = '".$_GET['loanno']."' order by createdate" ;
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		
		$amount=$result["payment"]+$result["reciveinterest"];
		
?> 
<tr>
	<td class="c1"><?=$result["loanno"];?></td>
	<td class="c2"><?=$result["payment"];?></td>
	<td class="c1"><?=$result["reciveinterest"];?></td>
	<td class="c2"><?php echo $amount;?></td>
	<td class="c1"><?=$result["loantime"];?></td>
	<td class="c2"><?=$result["createdate"];?></td>
	<td class="c1"><?php 
	$code=$result['code'];
	include('../config/config.php');
		$sql1="SELECT * FROM evcode where codeid='$code'";
			$query1=mysqli_query($link,$sql1);
			$dbarr=mysqli_fetch_array($query1);
		echo $dbarr['codename'];
	?></td>

</tr>
	<?php $sumamount=$amount;
	}
?>
<tr>
	<td class="c1"></td>
	<td class="c2"></td>
	<td class="c1"></td>
	<td class="c2"><?php echo $amount;?></td>
	<td class="c1"></td>
	<td class="c2"></td>
	<td class="c1"></td>

</tr>
</table>
</div>
<div id="tabb">
<?php if ($_SESSION['workroleid']<>"l"){$go="javascript:history.back();";}else{$go="../loan/addmemberloanload.php";}
echo "<a href='".$go."'>$back</a>";
?>
</div>
</div>
</div>
<?php 
		}
	?>