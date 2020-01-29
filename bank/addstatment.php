<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
    <script src="../config/jquery-2.1.3.min.js"></script>
	
	<link href="../config/bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet" />
    <link href="../config/bootstrap-3.3.7-dist/css/bootstrap-theme.css" rel="stylesheet" />
    <script src="../config/bootstrap-3.3.7-dist/js/bootstrap.js"></script>

    <link href="../config/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
    <script src="../config/dist/js/bootstrap-datepicker-custom.js"></script>
    <script src="../config/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>

    <script>
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true              //Set เป็นปี พ.ศ.
            }).datepicker("setDate", "0");  //กำหนดเป็นวันปัจุบัน
        });
    </script>




<?php 
session_start();
include('library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="b")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='../brcb/index.php'>$login</a> ";	
		}else{
		if($_GET['bankid']==null){
?>
<title>ฝากเงินธนาคารชุมชน</title>
<div id="container">
<div id="header">แบบกรอกข้อมูลบัญชี พิเศษ </div>
<form name='ฝากเงินธนาคารชุมชน'>
<div id="tab">
	<div id="menu">เลขบัญชี</div>
	<div id="content"><input type="text" name="bankid"></div>
</div>
<div id="tab">
<button type="submit"id="btfind"><button formaction='../bank/' id="btback"></form>
</div>
</div>
<?php 

}else if($_GET['amount']==null){
/*	
$dep1=substr($_GET['bankid'],0,2);
$dep2=substr($_GET['bankid'],-4,4);	
*/

include('../config/config.php');
	$sql="select * from memberbank  where bankid like '".$_GET['bankid']."'";
//	$sql="select * from memberbank  where bankid like '".$dep1."%%".$dep2."'";
	$query= mysqli_query($link,$sql);		
	$result=mysqli_fetch_array($query);
	if($_GET['bankid']==0){
		echo "รหัสไม่ถูกต้อง กรุณากรอกรหัสใหม่ <br><a href='../bank/deposit.php'>$back</a>";
	}else{
?>
<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 


<title>ฝากเงินธนาคารชุมชน</title>
<div id="container">

<div id="header">แบบกรอกข้อมูลบัญชี พิเศษ </div>

<form name='ฝากเงินธนาคารชุมชน'>
<div id="tab">
	<div id="menu">เลขบัญชี</div>
	<div id="content"><input type="text" name="bankid" value="<?=$result['bankid'];?>" readonly>
	<?php echo $result['pname'].$result['mname'].'  '.$result['lname'] ;  ?>
	<a href="editmember.php?bankid=<?php echo $result['bankid'];?>">|แก้ไข|</a>
	</div>
</div>
<div id="tab">
	<div id="menu">วัน / เวลา ทำรายการ</div>
	<div id="content">	<div id="content"> <input name="deptime" id="inputdatepicker" class="datepicker" data-date-format="mm/dd/yyyy">
</div>
</div>
<div id="tab">
	<div id="menu">รายการ  </div>
	<div id="content">
	<input id="rc1"  type="radio" name="code" value="de" checked> <label for="rc1" onclick>ฝาก  </label>
	<input id="rc2" type="radio" name="code" value="wi"> <label for="rc2" onclick> ถอน  </label>
	<input id="rc3"type="radio" name="code" value="in"> <label for="rc3" onclick> ดอกเบี้ย  </label>
	<input id="rc4" type="radio" name="code" value="bl"> <label for="rc4" onclick> ยอดยกมา  </label>
	</div>
</div>
<div id="tab">
	<div id="menu">จำนวนเงินที่ทำรายการ</div>
	<div id="content"><input type="text" name="amount"></div>
</div>

<div id="tab">
<button type='submit' id='button'>
<?php if($_SESSION['workroleid']==i or $_SESSION['workroleid']==a){$back="admin";}else{$back="bank";}						?>
</form>
<button type='submit' formaction='../<?=$back?>/reportbone.php?bankid='$bankid id='btback'>

</div>
<div id="tab" >

<table width='1000'>
<tr>
<!--	<td class="c4"><b>เลขบัญชี</td>
	<td class="c4"><b>งวดที่**</td>
-->	
	<td class="c4"><b>วันที่ทำรายการ</td>
	<td class="c4"><b>รายการฝาก</td>
	<td class="c4"><b>รายการถอน</td>
	<td class="c4"><b>คงเหลือ</td>
	<td class="c4"><b>สถานะ</td>
	<td class="c4"><b>ปรับปรุง </td>
</tr>
<?php 
include('../config/config.php');
	$sql="select * from eventbank where bankid ='".$result['bankid']."' ORDER BY `createdate` asc";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		$code=$result['code'];
?>
<tr>
<!--	<td class="c1"><?=$result['bankid'];?></td>	
	<td class="c1"><?=$result['num'];?></td>
-->	<td class="c2"><?php echo substr($result['deptime'],0,6).(substr($result['deptime'],-2,2)+2500);?></td>
	<td align="right"><?php if ($code=='de'or $code=='in' or $code=='bl' ){echo number_format($result['income'],2,'.',',');}else{echo "-";} ?></td>
	<td align="right"><?php if ($code=='wi'){echo number_format($result['income'],2,'.',',');}else{echo "-";} ?></td>
	<?php if ($code=='wi'){$income=$result['income'];}else{$income=$result['income'];}  ?> 
	<?php $balance= $balance+$income;?>
	<td align="right"><?php echo number_format($balance,2,'.',',');?></td>
<!--
บรรทัดที่ว่าด้วยการแสดงสถานะข้อความ ควรตั้งให้เฉพาะแบบฝากประจำ เพื่อให้ไม่สับสน หรือ ปรับตามที่ควรจะเป็น 
-->	
	<td class="c2">
	<?php 
			if ($code=='de'){
				echo "ฝาก";
			}else if($code=='wi'){
				echo "ถอน";
			}else if($code=='in'){
				echo "ดอกเบี้ย";
			}else if($code=='bl'){
				echo "ยอดยกมา";
			}else{
				echo "error";
			}
	?>
	</td>

<td><center>
		<a href="editstatment.php?bankid=<?php echo $result['bankid'];?>&num=<?php  echo $result['num'];?>">[แก้ไข]</a>
		- 
		<a href="delstatment.php?bankid=<?php echo $result['bankid'];?>&num=<?php  echo $result['num'];?>">[ลบ]</a></td>
</tr>
<?php 
		}
	}	
		?>
</table>
</div>
</div>
<?php
}else{
$numwi=$_GET['numwi'];
$deptime=$_GET['deptime'];	
$code=$_GET['code'];	
$bankid=$_GET['bankid'];
if ($code=='wi') {
	$income=-$_GET['amount'];
}else{
	$income=$_GET['amount'];
}
if (empty($deptime)){
	$deptime=date("d")."/".date("m")."/".($yn=date("y")+43);
}else{
	$deptime=substr($_GET['deptime'],0,2)."/".substr($_GET['deptime'],3,2)."/".substr($_GET['deptime'],8,2);
}
$time=$_GET['time'];
if (($code=='de') and (empty($time))){
	$time="1";
}else if($code=='wi') {
	$time=$numwi;
}
include('../config/config.php');// เพื่อเพิ่ม รหัสสมาชิก
	$sql="SELECT * FROM eventbank";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
	mysqli_close($link);	
$num=$numrows+1;	
$workno=$_SESSION['workno'];
$createdate=(((substr($deptime,-2,2))+2500)-543)."-".substr($deptime,3,2)."-".substr($deptime,0,2)." 00:00:00";	

include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link, $sql);
if($code=='wi') {
	$sql2="UPDATE eventbank SET time = '0' WHERE num =$numwi";
	$result2 = mysqli_query($link, $sql2);
}
	$sql = "Insert into eventbank values(
		'$num',
		'$bankid','$workno',
		'$income','$code',
		'$createdate',
		'$deptime',
		'$time'
		)";
	$result = mysqli_query($link, $sql);
include('../config/config.php');// เพื่อเพิ่ม รหัสสมาชิก
// ส่วน ปรับปรุง ข้อมูลที่บันทึกไว้ 
	if($result)	{
		echo "<center><span class='h1'>รวมรับเงินทั้งสิ้น ".number_format(($income),2,'.',',')." บาท  <br>บันทึกข้อมูลสำเร็จ<br>";
		mysqli_close($link);
	}	else	{
		echo $num." ".$bankid." ".$workno." ".$income." ".$code." ".$createdate
		." ".$deptime." ".$time;
		echo "<center><span class='h1'>ไม่สามารถบันทึกข้อมูลใหม่ลงในฐานข้อมูลได้<br>";
	}
	echo "<a href=../bank/addstatment.php?bankid=".$bankid.">$back</a><br>";
		  }
	}
?>