<?php 
ob_start();
session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('../config/config.php');

$employee_use=$_SESSION['employee_USER'];
$Amount= $_POST['Amount1'];
$Balance= $_POST['Balance'];
$IDRegFund = $_POST['IDRegFund'];
$LastAmount= $_POST['LastAmount'];
$IDDeposit= $_POST['IDDeposit'];
$LastUpdate=date('Y-m-d');

$Difference=$Amount-$LastAmount;

// echo $Balance;
// echo "<br>";
// echo "ส่วนต่าง".$Difference;
// echo "<br>";
$NewBalance=$Balance+$Difference;
$SQLUpdateDeposit = "UPDATE `deposit` SET `LastUpdate`='$LastUpdate' ,`Amount`= '$Amount' WHERE IDDeposit=$IDDeposit";
$SQLUpdateRegfund = "UPDATE `regfund` SET `LastUpdate`='$LastUpdate' ,`Balance`= '$NewBalance' WHERE IDRegFund=$IDRegFund";

// echo $SQLUpdateDeposit;
// echo "<br>";
// echo $SQLUpdateDataRegfund;

// exit();

$ResultUpdateDeposit = mysqli_query($link, $SQLUpdateDeposit);
$ResultUpdataRegfund = mysqli_query($link, $SQLUpdateRegfund);


header("location: dep-pay-tool.php");
exit(0);




?>
