<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php 
session_start();
include('library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='../index.php'>$login</a> ";	
		}else{
?>

<meta charset="utf-8">
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title><?php include('../config/config.php'); echo $title;?> </title>
<div id="container">
<div id="tab"><br><?php echo$title;?> </div>
	<div id="menu">ฝ่าย IT<br><?php 

$sql="select a.*,b.pname,b.mname, b.lname,c.* from worker a , memberfund b ,workrole_result c
where a.fundno=b.fundno and a.workroleid=c.workroleid and workno=".$_SESSION['workno'];
$result = mysqli_query($link, $sql);
$dbarr = mysqli_fetch_array($result);
echo $dbarr['pname'].$dbarr['mname']."  ".$dbarr['lname']."<br>";
echo $dbarr['rolename']."<br>";
echo $host;
?></div><?php 
if ($_SESSION['workroleid']=='a'){
?>	
	<div id="content">
		ระบบออมทรัพย์สัจจะ <br>
		<a href="../funds/showmembers.php"><?php echo $add;?></a> 
		<a href="../funds/depositload.php"><?php echo $dep;?></a> 
		<a href="../funds/withdrawalsload.php"><?php echo $wit;?></a> 
		<a href="../funds/accountcloseload.php"><?php echo $ac;?> </a>
		<a href="../funds/reportf.php"><?php echo $report;?></a> <br>
		ระบบสินเชื่อ ชำระเงินกู้</a> <br>
		<a href="../loan/addmemberloanload.php"><?php echo$member;?></a>
		<a href="../loan/loanpaymentload.php"><?php echo$pay;?></a>
		<a href="../loan/reportl.php"><?php echo $report;?></a> <br>
		ระบบธนาคารชุมชน <br>
		<a href='../bank/addmemberload.php'><?=$opb;?></a>
		<a href='../bank/deposit.php'><?=$depb;?></a>
		<a href='../bank/withdrawalsload.php'><?=$witb;?></a>
		<a href='../bank/accountcloseload.php'><?=$acb;?></a>
		<a href='../funds/reportf.php'><?=$report;?></a><br>
		ระบบคณะกรรมการ</a><br>
		<a href="../admin/addworkerload.php" title="เฉพาะเจ้าหน้าที่ IT "><?php echo $addw;?></a>
		<a href="../office/report.php"><?php echo $tol;?></a>
		<a href="../admin/about.php"><?php echo $about;?></a>
		<a href="../admin/setup.php"><?php echo $set;?></a>
		<a href="/brcb/index.php"><?php echo $exit;?> </a>
	</div>
<?php }else if($_SESSION['workroleid']=='i'){?>
		<div id="content">
		ระบบออมทรัพย์สัจจะ <br>
		<a href="../funds/showmembers.php"><?php echo $add;?></a> 
<br>	ระบบสินเชื่อ ชำระเงินกู้ <br>
		<a href="../loan/addmemberloanload.php"><?php echo$member;?></a><br>
		ระบบธนาคารชุมชน <br>
		<a href='../bank/addmemberload.php'><?=$opb;?></a><br>
		ระบบคณะกรรมการ<br>
		<a href="../admin/addworkerload.php" title="เฉพาะเจ้าหน้าที่ IT "><?php echo $addw;?></a>
		<a href="../office/report.php"><?php echo $tol;?></a>
		<a href="../admin/about.php"><?php echo $about;?></a>
		<a href="/brcb/index.php"><?php echo $exit;?> </a>
	</div>
<?php }
	?>
<div id="tab">
<?php include('../config/config.php'); echo $foottext; 
		}?> 
</div>
		</div>
		
