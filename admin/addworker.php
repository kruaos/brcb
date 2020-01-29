<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> <?php 
session_start();
include('library.php'); include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="i")or($_SESSION['workroleid']=="a"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
		
$fundno = $_POST['fundno'];
include('../config/config.php');
	$sql = "select * from worker where fundno = '$fundno';";
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
	$sql2 = "select fundstatusid from memberfund where fundno = '$fundno';";
		$result2 = mysqli_query($link, $sql2);
		$dbarr2 = mysqli_fetch_array($result2);	
	if 	((!(is_numeric($fundno)))or($fundno==null)){
			echo "<center><span class='h1'>พิมพ์รหัสสมาชิกไม่ถูกต้อง หรือเป็นค่าว่าง</span><br><a href='/brcb/admin/addworkerload.php'>".$back."</a>";
	}else if(($dbarr['fundno']==$fundno)and($dbarr['workstatusid']=='1')){
			echo "<center><span class='h1'>สมาชิกรายนี้เป็นเจ้าหน้าที่อยู่แล้ว</span><br><a href='/brcb/admin/addworkerload.php'>".$back."</a>";
	}else if($dbarr2['fundstatusid']<>1){
			echo "<center><span class='h1'>สมาชิกรายนี้ขาดสภาพสมาชิก</span><br><a href='/brcb/admin/addworkerload.php'>".$back."</a>";
	
	}else{
 include('/library.php'); ?>

<title><?php echo $title;?></title>
<?php 
if (!isset($_POST['send2'])){		
	$fundno = $_POST['fundno'];
include('../config/config.php');
	$sql="SELECT * FROM memberfund";
		$query= mysqli_query($link,$sql);
		$numrows= mysqli_num_rows($query);
		$result = mysqli_query($link, $sql);
	$sql = "select * from memberfund where fundno = '$fundno';";
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
?>
<form name="ฝากเงิน" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div id="container">
<div id="header"><?php echo $title;?></div>
<div id="tab"><?php $numrows;?>
	<div id="menu">รหัสสมาชิก</div>
	<div id="content"><input type="text" name="fundno" value="<?php echo $fundno;?>" /></div>
</div>
<div id="tab">
	<div id="menu">ชื่อ – สกุล</div>
	<div id="content"><?php echo $dbarr["pname"].$dbarr["mname"]."  ".$dbarr["lname"] ;?></div>
</div>
<div id="tab">
	<div id="menu">สิทธิการเข้าถึง</div>
	<div id="content"> 
	<input name="workerrole" type="radio" value="f" checked>        ฝ่ายออมทรัพย์สัจจะ
    <input name="workerrole" type="radio" value="l">        ฝ่ายสินเชื่อ เงินกู้     
	<input name="workerrole" type="radio" value="b">        ฝ่ายธนาคารชุมชน <br>
	<input name="workerrole" type="radio" value="o">             ฝ่ายอำนวยการ 
    <input name="workerrole" type="radio" value="i"> ฝ่ายสารสนเทศ</div>
</div>
<div id="tab">
	<div id="menu">ชื่อผู้ใช้  : username</div>
	<div id="content"><input type="text" name="username" /></div>
</div>
<div id="tab">
	<div id="menu">รหัสผ่าน : password</div>
	<div id="content"><input type="password" name="password1" /></div>
</div>
<div id="tab">
	<div id="menu">รหัสผ่าน (ซ้ำ) : password</div>
	<div id="content"><input type="password" name="password2" /></div>
</div>
<div id="tab">
	<div id="menu">ทำรายการวันที่ / เวลา</div>
	<div id="content"><div id="red"><?php echo date("Y-m-d H:i:s")?></div>
	</div>
</div>
<div id="tab">
	<div id="bar1"></form>
		<button type="submit" name="send2" id="button"/>    <button formaction="../admin/addworkerload.php" id="btback"/>
</div>
</div>
</div>

<?php 
//ส่วนการเพิ่มข้อมูล 
}else{ 
	if ($_POST['username']== null){
		echo "<center><span class='h1'>ไม่ได้กรอกรหัสผู้ใช้ใหม่<br><a href='../admin/addworkerload.php'>$back</a></span>";
	}else if (($_POST['password1']<>$_POST['password2'])or(($_POST['password1']or$_POST['password2'])==null)) {
		echo "รหัสผ่านไม่ตรงกัน  <input name='btnButton' type='button' value='ย้อนกลับ' onClick='JavaScript:history.back();'>";
			}else{	
	
	$fundno= $_POST['fundno'];
	$workerrole= $_POST['workerrole'];
	$workeruser= $_POST['username'];
	$createdate=date("Y-m-d H:i:s");
	$lastupdate=date("Y-m-d H:i:s");
	$status=1;
	$password= $_POST['password1'];
include('../config/config.php');
	$sql="SELECT * FROM worker";
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
	mysqli_close($link);	
	$workno=$numrows;

include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link, $sql);
	$sql = "Insert into worker values(
		'$workno',
		'$fundno','$workeruser','$password',
		'$workerrole','$status',
		'$createdate','$lastupdate'
		)";
	$result = mysqli_query($link, $sql);
	if($result)	{
		echo "<center><sapn class='h1'>การบันทึกข้อมูลลงในฐานข้อมูลประสบความสำเร็จ<br>";
		mysqli_close($link);
	}	else	{
		echo "<center><sapn class='h1'>ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br>";
	}
	echo "<a href=../admin/addworkerload.php>$back</a><br>";
	}
	}}
		}
?>