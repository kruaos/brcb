<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> <?php 
session_start();
include('library.php'); include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="i")or($_SESSION['workroleid']=="a"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
 ?>

<title><?php echo $title;?></title>
<?php 
if (!isset($_POST['send2'])){		

include('../config/config.php');
	$sql="SELECT a.*,b.* FROM worker a, memberfund b where a.fundno=b.fundno and workno=".$_GET['workno'];
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
?>
<form name="ฝากเงิน" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div id="container">
<div id="header"><?php echo $title;?> : แก้ไขข้อมูลเจ้าหน้าที่</div>
<div id="tab">
	<div id="menu">รหัสเจ้าหน้าที่</div>
	<div id="content"><input type="text" name="workno" value="<?php echo sprintf('%04d',$dbarr["workno"]);?>" readonly /></div>
</div>
<div id="tab">
	<div id="menu">รหัสสมาชิก</div>
	<div id="content"><input type="text" name="fundno" value="<?php echo sprintf('%04d',$dbarr["fundno"]);?>" readonly /></div>
</div>
<div id="tab">
	<div id="menu">ชื่อ – สกุล</div>
	<div id="content"><?php echo $dbarr["pname"].$dbarr["mname"]."  ".$dbarr["lname"] ;?></div>
</div>
<div id="tab">
	<div id="menu">สิทธิการเข้าถึง</div>
	<div id="content"> 
	<input name='workerrole' type='radio' value="f" <?php if($dbarr['workroleid']=="f"){echo"checked";}?>> ฝ่ายออมทรัพย์สัจจะ
    <input name="workerrole" type="radio" value="l" <?php if($dbarr['workroleid']=='l'){echo"checked";}?>> ฝ่ายสินเชื่อ เงินกู้
    <input name="workerrole" type="radio" value="b" <?php if($dbarr['workroleid']=='b'){echo"checked";}?>> ฝ่ายธนาคารชุมชน <br>
	<input name="workerrole" type="radio" value="o" <?php if($dbarr['workroleid']=='o'){echo"checked";}?>> ฝ่ายอำนวยการ 
    <input name="workerrole" type="radio" value="i" <?php if($dbarr['workroleid']=='i'){echo"checked";}?>> ฝ่ายสารสนเทศ</div>
</div>
<div id="tab">
	<div id="menu">ชื่อผู้ใช้  : username</div>
	<div id="content"><input type="text" name="username" value="<?php echo $dbarr["user"];?>"/></div>
</div>
<div id="tab">
	<div id="menu">รหัสผ่าน : password</div>
	<div id="content"><input type="password" name="password1" value="<?php echo $dbarr["password"];?>" /></div>
</div>
<div id="tab">
	<div id="menu">รหัสผ่าน (ซ้ำ) : password</div>
	<div id="content"><input type="password" name="password2" value="<?php echo $dbarr["password"];?>"/></div>
</div>
<div id="tab">
	<div id="menu">ทำรายการวันที่ / เวลา</div>
	<div id="content"><span id="red"><?php echo date("Y-m-d H:i:s")?></span>
	</div>
</div>
<div id="tab">
	<div id="menu">สถานะเจ้าหน้าที่</div>
	<div id="content">	
	<input name='workstatusid' type='radio' value="1" <?php if($dbarr['workstatusid']=="1"){echo"checked";}?>> ปฏิบัติงาน
    <input name="workstatusid" type="radio" value="2"> ลาออก 
    <input name="workstatusid" type="radio" value="5"> หมดวาระ <br>

	</div>
</div>
<div id="tab">
	<div id="bar1">	</form>
		<button type="submit" name="send2" id="button"/>    <button formaction="../admin/addworkerload.php" id="btback"/>

</div>
</div>
</div>

<?php 
//ส่วนการเพิ่มข้อมูล 
}else{ 
	if ($_POST['username']== null){
		echo "ไม่ได้กรอกรหัสผู้ใช้  <input name='btnButton' type='button' value='ย้อนกลับ' onClick='JavaScript:history.back();'>";
	}else if (($_POST['password1']<>$_POST['password2'])or(($_POST['password1']or$_POST['password2'])==null)) {
		echo "รหัสผ่านไม่ตรงกัน  <input name='btnButton' type='button' value='ย้อนกลับ' onClick='JavaScript:history.back();'>";
			}else{	
	$workno= $_POST['workno'];
	$workerrole= $_POST['workerrole'];
	$workeruser= $_POST['username'];
	$lastupdate=date("Y-m-d H:i:s");
	$status=$_POST['workstatusid'];
	$password= $_POST['password1'];
include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link, $sql);
	$sql = "update worker set
		user='$workeruser',password='$password',
		workroleid='$workerrole',
		workstatusid='$status',
		lastupdate='$lastupdate'
		where workno=$workno";
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
		
?>