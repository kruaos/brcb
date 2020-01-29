<meta charset=utf8>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../config/css/bootstrap.min.css">
  <script src="../config/js/jquery.min.js"></script>
  <script src="../config/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="../config/css1.css" type="text/css" />
<?php
session_start();
// include('library.php');
include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
//1. เริ่มต้นส่วนคัดรอง สิทธิ์
if (!(($_SESSION['workroleid']=="b")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='../brcb/index.php'>$login</a> ";
	}else{
		if($_GET['bankid']==null){
?>
<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" />
<title>ฝากเงินธนาคารชุมชน</title>
<div id="container">
<div id="header">ระบบฝากเงินธนาคาร</div>
<form name='ฝากเงินธนาคารชุมชน' >
<div id="tab">
	<div id="menu">เลขบัญชี</div>
	<div id="content"><input type="text" name="bankid" ></div>
</div>
<div id="tab">
	<div id="menu">ชื่อบัญชี </div>
	<div id="content">[ชื่อบัญชี]</div>
</div>
<div id="tab">
	<div id="menu">จำนวนเงินคงเหลือ </div>
	<div id="content">[บาท]</div>
</div>
<div id="tab">
	<div id="menu">ยอดฝาก</div>
	<div id="content">
		<table>
			<tr><td bgcolor="a5d6a7">ฝาก</td><td bgcolor="red">ถอน</td></tr>
			<tr><td bgcolor="a5d6a7"><input type="text" name="de" readonly> </td><td bgcolor="red"><input type="text" name="wi" readonly></td></tr>
		</table>
	</div>
</div>
<div id="tab">
	<div id="menu">วัน / เวลา ทำรายการ</div>
	<div id="content"><?php echo date('Y-m-d H:m:s')?></div>
</div>
<div id="tab">
		<button type='submit' ><img src="../image/check-icon.png" width="100"> 
		<button type='submit' formaction='../bank/addmember.php'><img src="../image/bookbank.png" width="100"></button>
		<button type='submit' formaction='../bank/'><img src="../image/home-icon.png" width="100"></button>
</form>

<?php
		}
// 1.1 ส่วนแสดงผล หลักจากกรอกเลขบัญชี 
else if($_GET['de']==null and $_GET['wi']==null){
	include('../config/config.php');
	if(strlen($_GET['bankid'])==6){
		$dep1=substr($_GET['bankid'],0,2);
		$dep2=substr($_GET['bankid'],2,2);
		$dep3=substr($_GET['bankid'],4,4);
			$sql="select * from memberbank  where bankid='".$dep1."%%".$dep3."'";
		}else{
		$dep1=$_GET['bankid'];
			$sql="select * from memberbank  where bankid='$dep1'";
		}
	$query= mysqli_query($link,$sql);
	$result=mysqli_fetch_array($query);
	if(($result['bankid']==null)or($_GET['bankid']==0)){
		//   echo $sql;   ตรวจสอบ SQl
		echo "<center>รหัสไม่ถูกต้อง กรุณากรอกรหัสใหม่ <br> <a href='../bank/deposit.php'>$back</a>";
	}else{
?>
<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" />
<title>ฝากเงินธนาคารชุมชน</title>
<div id="container">
<div id="header">ระบบฝากเงินธนาคาร</div>
<form name='ฝากเงินธนาคารชุมชน' method="GET">
<div id="tab">
	<div id="menu">เลขบัญชี</div>
	<div id="content"><input type="text" name="bankid" value="<?=$result['bankid']?>" readonly>
	<?php 	$bankid=$_GET['bankid'];
	echo "<a href='../bank/editmember.php?bankid=$bankid'>แก้ไข</a>";
	?>

	</div>
</div>
<div id="tab">
	<div id="menu">ชื่อบัญชี</div>
	<div id="content">
<?php
include('../config/config.php');
	$sql="select * from memberbank  where bankid like '".$result['bankid']."'";
	$query= mysqli_query($link,$sql);
	$resultn=mysqli_fetch_array($query);
	echo $resultn['bankname'];

?></div>
</div>
<div id="tab">
	<div id="menu">จำนวนเงินคงเหลือ </div>
	<div id="content"><?php
	$sql="select sum(income) as 'sincom' from eventbank where bankid like '".$result['bankid']."'";
	$query= mysqli_query($link,$sql);
	$resultn=mysqli_fetch_array($query);
	echo 		number_format($resultn['sincom'],2,'.',',');	?> บาท</div>
</div>
<div id="tab">
	<div id="menu">ยอดฝาก</div>
	<div id="content">
		<table>
			<tr>
			<td bgcolor="a5d6a7">ฝาก</td><td bgcolor="red">ถอน</td>
			<?php 
			$sql3="select * from bookbankbalance2 where bankid=$bankid";
			$query3= mysqli_query($link,$sql3) or die ("Error Query [$sql3]");
			$result3=mysqli_fetch_array($query3);
			if ($result3['bookbalance']==null){
				echo "<td  bgcolor='blue'>เงินคงเหลือ</td>";
			}else{
				echo " ";}
			?>
			</tr>
			<tr>
			<td bgcolor="a5d6a7"><input type="text" name="de"> </td><td bgcolor="red"><input type="text" name="wi"></td>
			<?php 
			$sql3="select * from bookbankbalance2 where bankid=$bankid";
			$query3= mysqli_query($link,$sql3) or die ("Error Query [$sql3]");
			$result3=mysqli_fetch_array($query3);
			if ($result3['bookbalance']==null){
				echo "<td bgcolor='blue'><input type='text' name='bl'> </td>";
			}else{
				echo " ";}
			?>
			</tr>
		</table>
	</div>
</div>
<div id="tab">
	<div id="menu">วัน / เวลา ทำรายการ</div>
	<div id="content"><?php echo date('Y-m-d H:m:s')?></div>
</div>
<div id="tab">

<button type='submit'><img src="../image/check-icon.png" width="100">
</form>
<form>	
<button type='submit' formaction='../bank/deposit.php?' method="post"><img src="../image/backarr.png" width="100" >
<button type='submit' formaction='../bank/'><img src="../image/home-icon.png" width="100">
</form>
</div>
<div id="tab" >
<table width='1000'>
<tr>
	
	<td class="c4" width="15%"><b>วันที่ทำรายการ</td>
	<td class="c4" width="18%"><b>รายการฝาก</td>
	<td class="c4" width="18%"><b>รายการถอน</td>
	<td class="c4" width="18%"><b>คงเหลือ</td>
	<td class="c4" ><b>สถานะ</td>
	<td class="c4" width="15%"><b>เจ้าหน้าที่</td>
</tr>
<?php
include('../config/config.php');
	$bankid=$result['bankid'];
//	$sql="select * from eventbank where bankid ='".$result['bankid']."' order by createdate";
	$sql="SELECT a.*, b.* FROM eventbank a , worker b where a.workno = b.workno and bankid=".$bankid." order by a.createdate";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);
		$code=$result['code'];
?>
<tr>

<td align='center'>
	<?php 

/*
<?php echo $result['deptime'];?>
echo $result['deptime'];
*/
		$mname=array("ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ตุ.ค.","พ.ย.","ธ.ค.");
		echo substr($result['deptime'],0,2)." ".$mname[number_format(substr($result['deptime'],3,2))-1]." ".substr($result['deptime'],6,2);
		?>
	</td>
	<td align='right'><?php if ($code=='de' or $code=='bl'or$code=='in' ){echo number_format($result['income'],2,'.',',');}else{echo "-";} ?></td>
	<td align='right'><?php if ($code=='wi'){echo number_format($result['income'],2,'.',',');}else{echo "-";} ?></td>
	<td align='right'><?php 
	$balance= $balance+$result['income'];
	echo  number_format($balance,2,'.',',');
	?></td>
	<td class="c2"><?php if($result['code']=="de"){ echo "ฝาก";}else 
		{if($result['code']=="bl"){
			echo "ยอดยกมา";
		}else if($result['code']=="in"){
			echo"ดอกเบี้ย";
		}else{
			echo"ถอน";
			}
		}
		?>	
		</td>
		<td align='center'><?=$result["username"];?>
		</td>	
</tr>
<?php
		}
	}
		?>
</table>
	</div>
</div>
<?php

//1.2 ส่วนเพิ่มการ ฝาก ถอน ยอดยกมา 
}else{
	include('../config/config.php');// เพื่อเพิ่ม รหัสสมาชิก
	$sql="SELECT * FROM eventbank";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query); // ได้จำนวนแถว 
$num=$numrows+1;
$workno=$_SESSION['workno'];
$createdate=date("Y-m-d H:i:s");
$deptime=date("d")."/".date("m")."/".(date("y")+43);
$time=1;
$bankid=$_GET['bankid'];	
// เริ่มต้นการคัดกรอง และเพิ่ม ฟังชั่น การ บันทึกข้อมูล แบบใหม่ 

include('../config/config.php');
mysqli_set_charset($link,'utf8');

	$sqlbl="SELECT * from bookbankbalance2 where bankid=$bankid";
	$querybl= mysqli_query($link,$sqlbl) or die ("Error Query [$sqlbl]");
	$resultbl=mysqli_fetch_array($querybl);


	 if($_GET['de']<>null && $_GET['bl']==null && $_GET['wi']==null){
		 // 1>> เคยฝากมาแล้ว 
		 /* เมื่อค่าฝาก มี  แต่ ไม่มี ค่า ยอดยอกมา ให้ทำดังนี้ 
		 	1. update ยอดใน bookbankbalance2 
			2. insert ยอดใน eventbook 
		*/
		$income=$_GET['de'];	
		$code="de";
		$sql1 = "Insert into eventbank values
				('$num','$bankid','$workno','$income','$code','$createdate','$deptime','$time')";
		$bookbalance=$resultbl['bookbalance']+$income;
		$sql2 ="update bookbankbalance2 set lastupdate='$createdate', bookbalance='$bookbalance' where bankid=$bankid";
		$result1 = mysqli_query($link, $sql1); $result2 = mysqli_query($link, $sql2);
		mysqli_close($link);
		if($result1 and $result2){
 		header("location:deposit.php?bankid=$bankid");
		}else{
			echo "F1";
		}

	 }else if ($_GET['de']<>null && $_GET['bl']<>null && $_GET['wi']==null){
		 // 2>> ไม่เคยฝากเลย
		 /* เมื่อมีค่า  1 ฝาก และมีค่า 2 ยอดยอกมา ให้ทำดังนี้ 
		 	1. insert ยอดใน bookbankbalance2 
			2. insert ยอดใน eventbook 
			3. insert ฝากใน eventbook 			
		 */
	$sqlbb="SELECT * from bookbankbalance2 ";
	$querybb= mysqli_query($link,$sqlbb) or die ("Error Query [$sqlbb]");
	//$id=(mysqli_num_rows($querybb))+1;		 
		$bl=$_GET['bl'];
		$sql3 ="insert into bookbankbalance2 values('$bankid','$bl','$createdate')";
		$result3 = mysqli_query($link, $sql3);

		$income=$_GET['de'];
		$inbl=$bl-$income;
		$code="bl";
		$sql4 = "Insert into eventbank values
				('$num','$bankid','$workno','$inbl','$code','$createdate','$deptime','$time')";
		$result4 = mysqli_query($link, $sql4);				
		$num=$num+1;
		$code="de";		
		$sql5 = "Insert into eventbank values
				('$num','$bankid','$workno','$income','$code','$createdate','$deptime','$time')";
		$result5 = mysqli_query($link, $sql5);
		mysqli_close($link);
		if($result3 and $result4 and $result5){
 		header("location:deposit.php?bankid=$bankid");
		}else{
			echo $sql3."<br>".$sql4."<br>".$sql5."<br>";
			echo "F2";
		}
	 }else if ($_GET['de']==null && $_GET['bl']<>null && $_GET['wi']<>null){
		/* 3.ไม่เคยถอนมาก่อน */
		 /* เมื่อมีค่า  1 ฝาก และมีค่า 2 ยอดยอกมา ให้ทำดังนี้ 
		 	1. insert ยอดใน bookbankbalance2 
			2. insert ยอดใน eventbook 
			3. insert ถอนใน eventbook 			
		 */
	$sqlbb="SELECT * from bookbankbalance2 ";
	$querybb= mysqli_query($link,$sqlbb) or die ("Error Query [$sqlbb]");
	//$id=(mysqli_num_rows($querybb))+1;		 
		$bl=$_GET['bl']+$_GET['wi'];
		$sql6 ="insert into bookbankbalance2 values('$bankid','$bl','$createdate')";
		$result6 = mysqli_query($link, $sql6);

		$income=$_GET['wi'];
		$code="bl";
		$sql7 = "Insert into eventbank values
				('$num','$bankid','$workno','$bl','$code','$createdate','$deptime','$time')";
		$result7 = mysqli_query($link, $sql7);				
		$num=$num+1;
		$code="wi";		
		$sql8 = "Insert into eventbank values
				('$num','$bankid','$workno','-$income','$code','$createdate','$deptime','$time')";
		$result8 = mysqli_query($link, $sql8);
		mysqli_close($link);
		if($result6 and $result7 and $result8){
 		header("location:deposit.php?bankid=$bankid");
		}else{
			echo $sql6."<br>".$sql7."<br>".$sql8."<br>";
			echo "F3";
		}

	 }else if ($_GET['wi']<>null && $_GET['de']==null){
		 // 4>> มีค่าถอน 
		 /*เมื่อค่าฝาก มี  แต่ มี ค่า ยอดยอกมา ให้ทำดังนี้ 
		 	1. insert ค่าถอน -xxx บาท 
			2. update ค่าวันที่ และยอดเงิน 
		 */
		$income=-$_GET['wi'];	
		$code="wi";
		$sql9 = "Insert into eventbank values
				('$num','$bankid','$workno','$income','$code','$createdate','$deptime','$time')";
		$bookbalance=$result6['bookbalance']+$income;
		$sql7 ="update bookbankbalance2 set lastupdate='$createdate', bookbalance='$bookbalance' where bankid=$bankid";
		$result9 = mysqli_query($link, $sql9); 
		$result7 = mysqli_query($link, $sql7);
		mysqli_close($link);
		if($result9 and $result7){
 		header("location:deposit.php?bankid=$bankid");
		}else{
			echo $sql9."<br>".$sql7."<br>";
			echo "F4";
		}

	 }else{
		 // แสดงค่าเนื่องจาก ไม่ถูกเงือนไขใด ๆ กันกรณี ที่มีค่า ฝากและถอน มาพร้อมกัน 
		 /*
		 */		 
		 echo "ผิดพลาด";

	 	}
	}
}
	
?>