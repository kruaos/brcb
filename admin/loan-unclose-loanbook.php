<?php 
ob_start();
include('../config/config.php');
date_default_timezone_set("Asia/Bangkok");
mysqli_set_charset($link,'utf8');

$RefNo=$_GET['RefNo'];
$memid=$_GET['memid'];
$LoanStatus="N";
$LastUpdate=date('Y-m-d');

$sql= "UPDATE loanbook  set LoanStatus='N' where RefNo='$RefNo';";

// print_r($sql);
// exit();
$result = mysqli_query($link, $sql);
	if ($result)
	{
		// echo $sql;
		header( "location: loan-cus-show.php?memid=$memid" );
		mysqli_close($link);
		exit(0);
	}else{
		echo "i'am not";
		mysqli_close($link);
		exit(0);
	}
?>