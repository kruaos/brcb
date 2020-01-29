<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php 
session_start();
include('library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="b")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='../brcb/index.php'>$login</a> ";	
		}else{
		if($_GET['bankid']==null){
?>
<title>ระบบคิดดอกเบี้ย</title>
<div id="container">
<div id="header">ระบบคิดดอกเบี้ย</div>
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

}else if(!isset($_POST['addinter'])){
$dep1=substr($_GET['bankid'],0,2);
$dep2=substr($_GET['bankid'],2,4);	
	
include('../config/config.php');
	$sql="select * from memberbank  where bankid like '".$dep1."%%".$dep2."'";
	$query= mysqli_query($link,$sql);		
	$result=mysqli_fetch_array($query);
	if(($_GET['bankid']==0)){
		echo "รหัสไม่ถูกต้อง กรุณากรอกรหัสใหม่ <br> <a href='../bank/addinterest.php'>$back</a>";
	}else{
?>
<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 


<title>ฝากเงินธนาคารชุมชน</title>
<div id="container">
<div id="header">ระบบฝากเงินธนาคาร</div>
<form name='ฝากเงินธนาคารชุมชน' method="POST">
<div id="tab">
	<div id="menu">เลขบัญชี</div>
	<div id="content"><input type="text" name="bankid" value="<?=$_GET['bankid']?>" readonly></div>
</div>
<div id="tab">
	<div id="menu">วัน / เวลา ทำรายการ</div>
	<div id="content"><?php echo date('Y-m-d h:m:s')?></div>
</div>
<div id="tab">
<button type='submit' id='btsave'name='addinter'>
<?php if($_SESSION['workroleid']==i or $_SESSION['workroleid']==a){$back="admin";}else{$back="bank";}						?>
<button type='submit' formaction='../<?=$back?>/' id='btback'>

</div>
<div id="tab" >

<table width='1000'>
<tr>
	<td class="c4"><b>เลขบัญชี</td>
	<td class="c4"><b>วันที่ทำรายการ</td>
	<td class="c4"><b>รายการฝาก</td>
	<td class="c4"><b>วันที่ถอน</td>
	<td class="c4"><b>คงเหลือ</td>
	<td class="c4"><b> สถานะ</td>
</tr>
<?php $c=1;// ตัวนี้เอาไว้นับ จำนวนลำดับช่อง 
include('../config/config.php');
	$sql="select * from eventbank where bankid ='".$_GET['bankid']." ' and code='de' and (time='1' or time='0')";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		$code=$result['code'];
?>
<tr>
	<td class="c2"><?php echo $result['bankid'];?></td>
	<td class="c2"><?php echo $result['deptime'];?></td>
	<td class="c1"><?php echo $result['income'];?></td>
<?php  
if ($result['time']==0){
	$sqlend="select * from eventbank where bankid ='".$result['bankid']." ' and code='wi' and time='".$result['deptime']."'";	
	$qend= mysqli_query($link,$sqlend);
	$rend=mysqli_fetch_array($qend);	
	$endtime=$rend['deptime'];
}else{	$endtime="-";}
?>	
	<td class="c2"><?php echo $endtime ; ?></td>	
	<?php if ($code=='wi'){$income=-$result['income'];}else{$income=$result['income'];}  ?> 
	<td class="c1"><?php echo $balance=$balance+$income;?></td>
	<td class="c2"><?php if ($result['time']=='1'){$etime='คิดดอกเบี้ย';}else{if($result['time']=='0'){$etime='ถอนแล้ว';}else{$etime=$result['time'];}} ; echo $etime; ?> </td>
</tr>
<?php 
$inter=$result['income'];	
$d=date("d");	$yn=date("y")+43;	$mn=date("m"); 	// set ค่าวันเริ่มต้น 
$m=substr($result['deptime'],3,2);		$y=substr($result['deptime'],-2,2);  // ตัดค่าเดือน เพื่อคำนวน 
$cck=((($yn-$y)*12)-$m)+$mn;			// ตรวจสอบว่า ต้องเริ่มจุดไหน 

// ------------->>แก้ปัญหา cck เช็ค โดยการทำแบบ switch 
if(((substr($_GET['bankid'],0,2))=='01')and ($cck>=1)){			$iin=0.0125;$sw=1;
}else if (((substr($_GET['bankid'],0,2))=='02')and ($cck>=3)){	$iin=0.035;$sw=2;
}else if (((substr($_GET['bankid'],0,2))=='03')and ($cck>=6)){	$iin=0.0375;$sw=3;
}else if (((substr($_GET['bankid'],0,2))=='04')and ($cck>=12)){	$iin=0.04;$sw=4;
}else{	echo "ข้อมูลผิดพลาด";$sw=0;	}
// -------------->>
if ($sw==1){  //ตรวจสอบว่า ต้องเข้าไปทำรายการในเมนูใด  01 - สะสมทรัพย์ *******ยคิดวิธีจัดการ  ***********
	
	
	
	
}else if ($sw==2){	// ตรวจสอบว่า ต้องเข้าไปทำรายการในเมนูใด  02 - ประจำ 3 เดือน   
	$em=substr($endtime,3,2);		$ey=substr($endtime,-2,2);
	if ($result['time']==1){	$s=((($yn-$y)*4)+floor(($mn-$m)/3));	// ดูว่า ยอดนั้นหมดอายุหรือยัง 	
		} else {				$s=(($ey-$y)*4)+floor(($em-$m)/3);	}
	include 'setinter.php';					$x=1;$a=1;$n=1;
	do {
	if ($a<=4){///<<<<<===== ต้องจัดการส่วนนี้ด้วย หากไม่ใช้ switcase ตัวใหม่ ก็ต้องปรับสูตร 
		$sinter = number_format((($inter*3*$iin)/12),3)	;
		$createdate=((($y+$mty[$a])+2500)-543)."-".sprintf("%02d",$mt3[$a])."-".date("d");
		$time=$result['deptime']."-".sprintf("%03d",$n);
		$deptime=date("d")."/".sprintf("%02d",$mt3[$a])."/".$y=($y+$mty[$a]);
	echo "<input type='hidden' value='".$c."'>" ; 
	echo "<input type='hidden' name='income".$c."' value='".$sinter."'>" ;
	echo "<input type='hidden' name='createdate".$c."' value='".$createdate."'>" ;		
	echo "<input type='hidden' name='time".$c."' value='".$time."'>" ;		
	echo "<input type='hidden' name='deptime".$c."' value='".$deptime."'>" ;		
	echo "<tr><td>".$c."</td>
		<td>".date("d")."/".sprintf("%02d",$mt3[$a])."/".($y+$mty[$a])."</td>
					<td>".$sinter."</td>
					<td></td>
					<td>".number_format($inter=$inter+(($inter*3*$iin)/12),3)."</td>
					<td>".$result['deptime']."-".sprintf("%03d",$n)."</td>
			</tr>";	
		$a++;$n++;$c++;
		}else{// กรณีนี้ มีไว้เพื่อทำอย่างไร .....................................			
		$a=1;
		$sinter = number_format((($inter*3*$iin)/12),3)	;
		$createdate=((($y+$mty[$a])+2500)-543)."-".sprintf("%02d",$mt3[$a])."-".date("d");
		$time=$result['deptime']."-".sprintf("%03d",$n);
		$deptime=date("d")."/".sprintf("%02d",$mt3[$a])."/".$y=($y+$mty[$a]);
	echo "<input type='hidden' value='".$c."'>" ; 
	echo "<input type='hidden' name='income".$c."' value='".$sinter."'>" ;
	echo "<input type='hidden' name='createdate".$c."' value='".$createdate."'>" ;		
	echo "<input type='hidden' name='time".$c."' value='".$time."'>" ;	
	echo "<input type='hidden' name='deptime".$c."' value='".$deptime."'>" ;		
	echo "<tr><td>".$c."</td>
					<td>".date("d")."/".sprintf("%02d",$mt3[$a])."/".($y+$mty[$a])."</td>
					<td>".$sinter."</td>
					<td></td>
					<td>".number_format($inter=$inter+(($inter*3*$iin)/12),3)."</td>
					<td>".$result['deptime']."-".sprintf("%03d",$n)."</td>
			</tr>";
		$a++;$n++;$c++;
		}
		$x++;
	} while ($x<=$s);
}else if ($sw==3){  	
// ตรวจสอบว่า ต้องเข้าไปทำรายการในเมนูใด  03 - ประจำ 6 เดือน   *******ยังไม่ได้แก้ไข ***********
	$em=substr($endtime,3,2);		$ey=substr($endtime,-2,2);
	if ($result['time']==1){	$s=((($yn-$y)*2)+floor(($mn-$m)/6));		
		} else {				$s=(($ey-$y)*2)+floor(($em-$m)/6);	}
	include 'setinter.php';					
	$x=1;$a=2;$n=1;
do {
	if ($a<=4){///<<<<<===== ต้องจัดการส่วนนี้ด้วย หากไม่ใช้ switcase ตัวใหม่ ก็ต้องปรับสูตร 
		$sinter = number_format((($inter*3*$iin)/12),3)	;
		$createdate=((($y+$mty[$a])+2500)-543)."-".sprintf("%02d",$mt3[$a])."-".date("d");
		$time=$result['deptime']."-".sprintf("%03d",$n);
		$deptime=date("d")."/".sprintf("%02d",$mt3[$a])."/".$y=($y+$mty[$a]);
	echo "<input type='hidden' value='".$c."'>" ; 
	echo "<input type='hidden' name='income".$c."' value='".$sinter."'>" ;
	echo "<input type='hidden' name='createdate".$c."' value='".$createdate."'>" ;		
	echo "<input type='hidden' name='time".$c."' value='".$time."'>" ;		
	echo "<input type='hidden' name='deptime".$c."' value='".$deptime."'>" ;		
	echo "<tr><td>".$c."</td>
		<td>".date("d")."/".sprintf("%02d",$mt3[$a])."/".$y."</td>
					<td>".$sinter."</td>
					<td></td>
					<td>".number_format($inter=$inter+(($inter*3*$iin)/12),3)."</td>
					<td>".$result['deptime']."-".sprintf("%03d",$n)."</td>
			</tr>";	
		$a=$a+2;$n++;$c++;
		}else{// กรณีนี้ มีไว้เพื่อทำอย่างไร .....................................			
		$a=2;
		$sinter = number_format((($inter*3*$iin)/12),3)	;
		$createdate=((($y=($y+$mty[$a]))+2500)-543)."-".sprintf("%02d",$mt3[$a])."-".date("d");
		$time=$result['deptime']."-".sprintf("%03d",$n);
		$deptime=date("d")."/".sprintf("%02d",$mt3[$a])."/".$y;
	echo "<input type='hidden' value='".$c."'>" ; 
	echo "<input type='hidden' name='income".$c."' value='".$sinter."'>" ;
	echo "<input type='hidden' name='createdate".$c."' value='".$createdate."'>" ;		
	echo "<input type='hidden' name='time".$c."' value='".$time."'>" ;	
	echo "<input type='hidden' name='deptime".$c."' value='".$deptime."'>" ;		
	echo "<tr><td>".$c."</td>
					<td>".date("d")."/".sprintf("%02d",$mt3[$a])."/".$y."</td>
					<td>".$sinter."</td>
					<td></td>
					<td>".number_format($inter=$inter+(($inter*3*$iin)/12),3)."</td>
					<td>".$result['deptime']."-".sprintf("%03d",$n)."</td>
			</tr>";
		$a=$a+2;$n++;$c++;$ya++;
		}
		$x++;
	} while ($x<=$s);	
	
}else if ($sw==4){ 
/*
	ตรวจสอบว่า ต้องเข้าไปทำรายการในเมนูใด  04 - ประจำ 12 เดือน 
	
	
*/
	$em=substr($endtime,3,2);		$ey=substr($endtime,-2,2);
	if ($result['time']==1){	$s=((($yn-$y)*1)+floor(($mn-$m)/12));		
		} else {				$s=(($ey-$y)*1)+floor(($em-$m)/12);	}
	include 'setinter.php';					$x=1;$a=4;$n=1;
	do {
	if ($a<=4){///<<<<<===== ต้องจัดการส่วนนี้ด้วย หากไม่ใช้ switcase ตัวใหม่ ก็ต้องปรับสูตร 
		$sinter = number_format((($inter*3*$iin)/12),3)	;
		$createdate=((($y=($y+1))+2500)-543)."-".sprintf("%02d",$mt3[$a])."-".date("d");
		$time=$result['deptime']."-".sprintf("%03d",$n);
		$deptime=date("d")."/".sprintf("%02d",$mt3[$a])."/".$y;
	echo "<input type='hidden' value='".$c."'>" ; 
	echo "<input type='hidden' name='income".$c."' value='".$sinter."'>" ;
	echo "<input type='hidden' name='createdate".$c."' value='".$createdate."'>" ;		
	echo "<input type='hidden' name='time".$c."' value='".$time."'>" ;		
	echo "<input type='hidden' name='deptime".$c."' value='".$deptime."'>" ;		
	echo "<tr><td>".$c."</td>
		<td>".date("d")."/".sprintf("%02d",$mt3[$a])."/".$y."</td>
					<td>".$sinter."</td>
					<td></td>
					<td>".number_format($inter=$inter+(($inter*3*$iin)/12),3)."</td>
					<td>".$result['deptime']."-".sprintf("%03d",$n)."</td>
			</tr>";	
		$a++;$n++;$c++;
		}else{// กรณีนี้ มีไว้เพื่อทำอย่างไร .....................................			
		$a=1;
		$sinter = number_format((($inter*3*$iin)/12),3)	;
		$createdate=((($y+1)+2500)-543)."-".sprintf("%02d",$mt3[$a])."-".date("d");
		$time=$result['deptime']."-".sprintf("%03d",$n);
		$deptime=date("d")."/".sprintf("%02d",$mt3[$a])."/".$y=($y+$mty[$a]);
	echo "<input type='hidden' value='".$c."'>" ; 
	echo "<input type='hidden' name='income".$c."' value='".$sinter."'>" ;
	echo "<input type='hidden' name='createdate".$c."' value='".$createdate."'>" ;		
	echo "<input type='hidden' name='time".$c."' value='".$time."'>" ;	
	echo "<input type='hidden' name='deptime".$c."' value='".$deptime."'>" ;		
	echo "<tr><td>".$c."</td>
					<td>".date("d")."/".sprintf("%02d",$mt3[$a])."/".($y+$mty[$a])."</td>
					<td>".$sinter."</td>
					<td></td>
					<td>".number_format($inter=$inter+(($inter*3*$iin)/12),3)."</td>
					<td>".$result['deptime']."-".sprintf("%03d",$n)."</td>
			</tr>";
		$a++;$n++;$c++;
		}
		$x++;
		} while ($x<=$s);	
	}
	}
}	
echo "<input type='hidden' name='count' value='".$c."'>"	
		?>

</form>		
</table>
</div>
</div>
<?php
//*********************************** แถวนนี้น่าจะต้องเขียนใหม่ 

}else{
$code="in";	
$bankid=$_POST['bankid'];
for($x=1;$x<$_POST['count'];$x++){
$income=$_POST['income'.$x];
$createdate=$_POST['createdate'.$x];
$time=$_POST['time'.$x];
$deptime=$_POST['deptime'.$x];
	include('../config/config.php');// เพื่อเพิ่ม รหัสสมาชิก
	$sql="SELECT * FROM eventbank";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
	mysqli_close($link);	
$num=$numrows+1;	
$workno=$_SESSION['workno'];
include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link, $sql);
	$sql = "Insert into eventbank values(
		'$num',
		'$bankid','$workno',
		'$income','$code',
		'$createdate',
		'$deptime',
		'$time'
		)";
	$result = mysqli_query($link, $sql);
}
	if($x=$_POST['count'])	{
		echo "<center><span class='h1'>รวมรับเงินทั้งสิ้น ".number_format(($payment+$income),2,'.',',')." บาท  <br>บันทึกข้อมูลสำเร็จ<br>";
		mysqli_close($link);
	}	else	{
		echo "<center><span class='h1'>ไม่สามารถบันทึกข้อมูลใหม่ลงในฐานข้อมูลได้<br>";
	}
	echo "<a href=../bank/addinterest.php>$back</a><br>";
		  }
		}
		
//*********************************** แถวนนี้น่าจะต้องเขียนใหม่ 		
		?>