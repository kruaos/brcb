<meta charset="utf-8">
<link rel="stylesheet" href="config/css1.css" type="text/css" /> 
<?php // หน้าแรกสุด
session_start();
session_destroy();
?>
<title><?php include('config/config.php'); echo $programname;?> </title>
<?php if (!isset($_POST['send'])){	?>	

<div id="container">
	<div id="bglogin">
	<table width=100% height=100%><tr><td align="right" valign='middle'>
	<form name="form1" method="post">
		ผู้ใช้ : <input type="text" name="username"><br>
		รหัสผ่าน : <input type="password" name="password"><br>
		<input type="submit" name="send" value=" " id="btlogin">
	</td></tr></table>
		</div>
	<div id="tab">
	<?php echo $foottext; ?> 
	</div>
</div>
<?php }
else{
	$username=$_POST['username'];
	$password=$_POST['password'];	
include('config/config.php');
	$sql = "select * from worker where user = '$username';";
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
	if (($username==$dbarr["user"])&&($password==$dbarr["password"])&&($dbarr["workstatusid"]==1)){
		if (($dbarr["workroleid"]=="a")or($dbarr["workroleid"]=="i")){
		session_start();
		$_SESSION['workno']=$dbarr["workno"];
		$_SESSION['workroleid']=$dbarr["workroleid"];	
		header( "location: /brcb/admin/" );

		}else if ($dbarr['workroleid']=="f"){
		session_start();
		$_SESSION['workno']=$dbarr["workno"];
		$_SESSION['workroleid']=$dbarr["workroleid"];
		header( "location: /brcb/funds/" );
		}else if ($dbarr['workroleid']=="l"){
		session_start();
		$_SESSION['workno']=$dbarr["workno"];
		$_SESSION['workroleid']=$dbarr["workroleid"];
		header( "location: /brcb/loan/" );
		}else if ($dbarr['workroleid']=="b"){
		session_start();
		$_SESSION['workno']=$dbarr["workno"];
		$_SESSION['workroleid']=$dbarr["workroleid"];
		header( "location: /brcb/bank/" );
		}else if ($dbarr['workroleid']=="o"){
		session_start();
		$_SESSION['workno']=$dbarr["workno"];
		$_SESSION['workroleid']=$dbarr["workroleid"];
		header( "location: /brcb/office/" );
		}else{
			echo "ไม่อนุญาตให้เข้าใช้ทุกระบบ  ";
		}
	}else if ($username==null or($username<>$dbarr["user"])){
		echo 
		"<center><span class='h1'>ลงชื่อผู้ใช้ไม่ถูกต้อง</span><br><a href='/brcb/'>".$logini."</a>";
	}else if ($password<>$dbarr["password"]){
		echo 
		"<center><span class='h1'>รหัสผ่านไม่ถูกต้อง กรอกใหม่</span><br><a href='/brcb/'>".$logini."</a>";
	}else if ($dbarr["workstatusid"]<>1){
		echo 
		"<center><span class='h1'>สิทธการใช้งานถูกระงับ</span><br><a href='/brcb/'>".$logini."</a>";
	}else{
		echo "ข้อมูลไม่ถูกต้อง";
	}
}
?>