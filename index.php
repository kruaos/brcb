<?php 
ob_start();
session_start();
session_destroy();

include('config/config.php');
?>
<meta charset="utf-8">
<link rel="stylesheet" href="config/css1.css" type="text/css" />
<link href="config/css/bootstrap.min.css" rel="stylesheet">
<title><?php  echo $programname;?> </title>
<?php if (!isset($_POST['send'])){	?>

	<div class="row">
	  <div class="bglogin"><center>
			<img src="image/title-program1.png" align="middle" class="img-responsive">
		</div>
	</div>
	<div class="row">
			<div class="col-xs-2 col-sm-2 col-md-4"></div>
		  <div class="col-xs-8 col-sm-8 col-md-4">
				<form name="form1" method="post">
					<div class="form-group">
						<label for="exampleInputName1">รหัสผู้ใช้</label>
						<input type="text" class="form-control" id="exampleInputName1" placeholder="รหัสผู้ใช้" name="username">
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">รหัสผ่าน</label>
						<input type="password" class="form-control" id="exampleInputPassword1" placeholder="รหัสผ่าน" name="password">
					</div>
					<button type="submit"  name="send"  class="btn btn-default">ลงชื่อเข้าใช้</button>
				</form>
			</div>
			<div class="col-xs-2 col-sm-2 col-md-4"></div>
	</div>
	<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12"><center><?php echo $foottext; ?></div>

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
