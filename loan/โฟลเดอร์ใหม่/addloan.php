<?php // หน้าที่สอง จากการเพิ่มสมาชิกเงินกู้ 
session_start();
include('/library.php'); include('../config/config.php'); 
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="l")or($_SESSION['workroleid']=="a"))){
			echo "ท่านไม่มีสิทธิ์เข้าถึง <br><a href='http://localhost/brcb/index.php'>".$login."</a> ";	
		}else{
?>
<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title><?php echo$title.": สมัครสมาชิก";?></title>
<?php 
$typeloan=$_COOKIE['typeloan'];
$fundno=$_COOKIE['fundno'];
$loanno=$_COOKIE['loanno'];
$workno=$_SESSION['workno'];
$createdate=date("Y-m-d H:i:s");
$statusloan="op";
$principle=$_COOKIE['principle'];
$timeloan=$_COOKIE['timeloan'];
$interestloan=$_COOKIE['interestloan'];
$lastupdate=date("Y-m-d H:i:s");
if($typeloan==1){
	$guatantee1=$_COOKIE['guatantee1'];	$guatantee2=$_COOKIE['guatantee2'];	$bookbank=0;	$collateral='0';
}else if($typeloan==2){
	$guatantee1='0';$guatantee2='0';$bookbank='0';$collateral=$_COOKIE['collateral'];
}else{
	$guatantee1='0';$guatantee2='0';$bookbank=$_COOKIE['bookbank'];$collateral='0';
}
include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link, $sql);
	$sql = "Insert into memberloan values(
		'$loanno','$fundno','$workrid',
		'$createdate',
		'$typeloan','$principle','$interestloan','$timeloan',
		'$statusloan',
		'$lastupdate',
		'$guatantee1','$guatantee2',
		'$collateral',
		'$bookbank'
		)";				$result = mysqli_query($link, $sql);
if($result)	{
		echo "การเพิ่มข้อมูลลงในฐานข้อมูลประสบความสำเร็จ<br>";
		mysqli_close($link);
	}	else	{
echo 		$fundno;

	echo "ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br>";
	}
	echo "<a href=../loan/addmemberloanload.php>กลับหน้าเว็บการเพิ่มข้อมูล</a><br>";
	echo "<a href=../loan/>กลับเมนูย่อย </a><br>";
		

	}	
?>