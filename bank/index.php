<?php
include('config/chkbank.php'); 
include('config/setstatus.php'); 
include('../config/config.php');  
?>
<link rel="stylesheet" href="../config/css1.css" type="text/css" />

<meta charset="utf-8">
<title><?php echo $title;?> </title>
<div id="container">

<div id="titlebar2"><br><?php echo$title;?> </div>
	<div id="menu">ฝ่าย ธนาคารชุมชน<br><?php

$sql="select a.*,b.pname,b.mname, b.lname,c.* from worker a , memberfund b ,workrole_result c
where a.fundno=b.fundno and a.workroleid=c.workroleid and workno=$SessWorkNo";
$result = mysqli_query($link, $sql);
$dbarr = mysqli_fetch_array($result);
echo $dbarr['pname'].$dbarr['mname']."  ".$dbarr['lname']."<br>";
echo $dbarr['rolename'];
?></div><?php
if ($_SESSION['workroleid']=='b'){
?>
	<div id="content">ระบบธนาคารชุมชน <br>
		<a href='../bank/viwemember.php'><?=$person;?></a>
		<a href='../bank/deposit.php'><?=$depb;?></a>
		<a href='../bank/accountcloseload.php'><?=$acb;?></a>
		<a href='../bank/reportb.php'><?=$report;?></a>
		<a href='../bank/addinterest.php'><img src="../image/addint.png"></a>
		<a href="/brcb/index.php"><?php echo $exit;?> </a>
<!-- 		
		<a href='../bank/addlist.php'>addlist</a>
		a href='../bank/suminterest.php'><img src="../image/suminter.png"></a -->
	</div>
<?php }
	?>
<div id="tab">

</div>
		</div>
