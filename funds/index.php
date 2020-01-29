<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<?php 
session_start();
include('/library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="f")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='http://localhost/brcb/index.php'>$login</a> ";	
		}else{
?>
<meta charset="utf-8">
<title><?php echo $programname;?> </title>
<div id="container">
<div id="titlebar1"><?php echo $title;?></div>
	<div id="menu">ฝ่ายออมทรัพย์<br>
		<?php // แสดงชื่อ เจ้าหน้าที่ 
$sql="select a.*,b.pname,b.mname, b.lname,c.* from worker a , memberfund b ,workrole_result c
where a.fundno=b.fundno and a.workroleid=c.workroleid and workno=".$_SESSION['workno'];
$result = mysqli_query($link, $sql);
$dbarr = mysqli_fetch_array($result);
echo $dbarr['pname'].$dbarr['mname']."  ".$dbarr['lname']."<br>";
echo $dbarr['rolename'];
?></div>
	<div id="content">
		<a href="showmembers.php"><?php echo $memf;?></a> 
		<a href="depositload.php"><?php echo $dep;?></a> 
		<a href="withdrawalsload.php"><?php echo $wit;?></a> 
		<a href="accountcloseload.php"><?php echo$ac;?></a> 
		<a href="reportf.php"><?php echo $report;?></a> 
		<a href="/brcb/index.php"><?php echo $exit;?> </a>
	</div>
<div id="tab">
	<?php echo $foottext; ?> 
</div>
</div>
<?php 
	}
?>
