<?php 
session_start();
session_id();

$_SESSION['LoanEmplopeeUser']=$_POST['LoanEmplopeeUser'];
// $_SESSION['income_array']=$income_dep_array;

include('../config/config.php');
$sql = "SELECT * from employee where Username like '" .$_POST['LoanEmplopeeUser'] . "' ";
// print_r($sql);
$query = mysqli_query($link, $sql);
while ($rs1 = mysqli_fetch_array($query)) {
    $FullNameEmp = $rs1['Firstname'] . " " . $rs1['Lastname'];
}
$_SESSION['fullnameemp'] = $FullNameEmp;

header( "location: loan-pay-tool.php" );
