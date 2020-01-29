<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php 
session_start();
include('/library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="o")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
?>
<meta charset="utf-8">
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title><?php include('../config/config.php'); echo $title;?> </title>
<div id="container">
<div id="titlebar2"><br><?php echo$title;?> </div>
	<div id="menu">ฝ่าย IT<br><?php 

$sql="select a.*,b.pname,b.mname, b.lname,c.* from worker a , memberfund b ,workrole_result c
where a.fundno=b.fundno and a.workroleid=c.workroleid and workno=".$_SESSION['workno'];
$result = mysqli_query($link, $sql);
$dbarr = mysqli_fetch_array($result);
echo $dbarr['pname'].$dbarr['mname']."  ".$dbarr['lname']."<br>";
echo $dbarr['rolename'];
?>

	
	</div>
	<div id="content">

		ระบบบริหารสำนักงาน</a><br>
		<a href="../Admin/addworkerload.php"><?php echo $memw;?></a>
		<a href="../funds/showmembers.php"><?php echo $memf;?></a>
		<a href="../loan/addmemberloanload.php"><?php echo $meml;?></a>		
		<a href="../office/report.php? report=day"><?php echo $tol;?></a>
		<a href="../Admin/about.php"><?php echo $about;?></a>
		<a href="/brcb/index.php"><?php echo $exit;?> </a>
	</div>
<div id="tab">
<?php include('../config/config.php'); echo $foottext; 
		}?> 
</div>
		</div>
		
