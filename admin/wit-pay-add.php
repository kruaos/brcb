<?php
ob_start();
session_start();
session_id();
include('../tmp_dsh2/header.php');
include('../config/config.php');
include('navbar.php');

$employee_use = $_SESSION['employee_USER'];
$IDMember = $_POST['IDMember'];

$SRFArray = array();
// Check IDMember is 1) type member  dep 2) type member  dep+ins 3) type member  dep + ins + lat  
// echo "กำลังบันทึกข้อมูล....";
// exit();

// $ShowMember = "select m.Title, m.Firstname, m.Lastname, m.MemberStatus from Member as m where  m.IDMember=$IDMember";
// $SMQuery = mysqli_query($link, $ShowMember);
// while ($SM = mysqli_fetch_array($SMQuery)) {
//     $FullNameMember = $SM['Title'] . $SM['Firstname'] . " " . $SM['Lastname'];
// }
$n = 1;
$ShowRegfund = "SELECT * from regfund where  IDMember=$IDMember order by IDFund ASC";
$SRfQuery = mysqli_query($link, $ShowRegfund);
while ($SRf = mysqli_fetch_array($SRfQuery)) {
    $SRFArray[$n]['IDRegFund'] = $SRf['IDRegFund'];
    $SRFArray[$n]['IDFund'] = $SRf['IDFund'];
    $SRFArray[$n]['LastUpdate'] = $SRf['LastUpdate'];
    $SRFArray[$n]['Closedate'] = $SRf['Closedate'];
    $SRFArray[$n]['Balance'] = $SRf['Balance'];
    $n++;
}
// echo count($SRFArray);
// echo"<pre>";
// print_r($SRFArray);
// echo"</pre>";

$IDDeposit1 = "";
$IDRegFund1 = $SRFArray[1]['IDRegFund'];
$Username1 = $_POST['witname'];
$CreateDate1 = date('Y-m-d');
$LastUpdate1 = date('Y-m-d');
$Amount1 = -($_POST['Amount1']);
$Receive1 = "I";
$DepositStatus1 = "P";


// $SRfQuery2 = mysqli_query($link, $ShowRegfund);
// while ($SRf2 = mysqli_fetch_array($SRfQuery2)) {
//     $IDRegFund5 = $SRf2['IDRegFund'];
//     $IDRegFund2 = $IDRegFund5;
// };
// $IDDeposit2 = "";
// // $IDRegFund2=$SRFArray[2]['IDRegFund'];
// $Username2 = $employee_use;
// $CreateDate2 = date('Y-m-d');
// $LastUpdate2 = date('Y-m-d');
// $Amount2 = $_POST['Amount2'];
// $Receive2 = "I";
// $DepositStatus2 = "P";

// insert value deposit 
$SQLInsertDataDeopsit = "INSERT INTO `deposit`(`IDDeposit`, `IDRegFund`, `Username`, `CreateDate`, `LastUpdate`, `Amount`, `Receive`, `DepositStatus`) 
VALUES 
('$IDDeposit1','$IDRegFund1','$Username1','$CreateDate1','$LastUpdate1','$Amount1','$Receive1','$DepositStatus1')";
// echo $SQLInsertDataDeopsit;
// echo "<br>";



// insert value regfund  
$IDRegFund1 = $SRFArray[1]['IDRegFund'];
$LastUpdate1 = date('Y-m-d');
$Balance1 = $SRFArray[1]['Balance'] + $Amount1;
// $IDRegFund2 = $SRFArray[2]['IDRegFund'];
// $LastUpdate2 = date('Y-m-d');
// $Balance2 = $SRFArray[2]['Balance'] + $Amount2;

$SQLUpdateDataRegfund1 = "UPDATE `regfund` SET `LastUpdate`='$LastUpdate1' ,`Balance`= '$Balance1' WHERE IDRegFund=$IDRegFund1";
// $SQLUpdateDataRegfund2 = "UPDATE `regfund` SET `LastUpdate`='$LastUpdate2' ,`Balance`= '$Balance2' WHERE IDRegFund=$IDRegFund2";
// echo $SQLUpdateDataRegfund1;
// echo "<br>";
// echo $SQLUpdateDataRegfund2;
$SQLUpdateMember = "UPDATE `member` SET `IDmember`='$LastUpdate1' ,`Balance`= '$Balance1' WHERE IDRegFund=$IDRegFund1";

$ResultInsertDataDeposit = mysqli_query($link, $SQLInsertDataDeopsit);
$ResultUpdataRegfund1 = mysqli_query($link, $SQLUpdateDataRegfund1);
// $ResultUpdataRegfund2 = mysqli_query($link, $SQLUpdateDataRegfund2);

// ต้องค้นหา IDDeposit ก่อน 
// $SQLSelectDeposit1 = "SELECT IDDeposit From deposit where Createdate='$CreateDate1' and IDRegFund='$IDRegFund1'";
// $SQLSelectDeposit2 = "SELECT IDDeposit From deposit where Createdate='$CreateDate2' and IDRegFund='$IDRegFund2'";
// $QueryShowTable1 = mysqli_query($link, $SQLSelectDeposit1);
// while ($QST1 = mysqli_fetch_array($QueryShowTable1)) {
//     $IDDeposit1 = $QST1['IDDeposit'];
// }
// $QueryShowTable2 = mysqli_query($link, $SQLSelectDeposit2);
// while ($QST2 = mysqli_fetch_array($QueryShowTable2)) {
//     $IDDeposit2 = $QST2['IDDeposit'];
// }

// insert value Deposit_n

// $Username = $employee_use;
// $CreateDate = $CreateDate1;
// $LastUpdate = $LastUpdate1;
// $Amount_FixDep = $Amount1;
// $Amount_Insura = $Amount2;
// $Receive = $Receive1;
// $DepositStatus = $DepositStatus1;
// $IDDeposit_FixDep = $IDDeposit1;
// $IDDeposit_Insura = $IDDeposit2;
// $IDRegFund_FixDep = $IDRegFund1;
// $IDRegFund_Insura = $IDRegFund2;
// $DepositPage = $_POST['DepPage'];
// $SQLInsertDataDeposit_n = "INSERT INTO `deposit_n`(`IDDeposit`, `IDMember`, `Username`, `CreateDate`, `LastUpdate`, `Amount_FixDep`, `Amount_Insura`, `Receive`, `DepositStatus`, `IDDeposit_FixDep`, `IDDeposit_Insura`, `IDRegFund_FixDep`, `IDRegFund_Insura`, `DepositPage`) 
// VALUES
// ('','$IDMember','$Username','$CreateDate','$LastUpdate','$Amount_FixDep','$Amount_Insura','$Receive','$DepositStatus',
// '$IDDeposit_FixDep','$IDDeposit_Insura','$IDRegFund_FixDep','$IDRegFund_Insura','$DepositPage')";
// $ResultInsertDataDeposit_n = mysqli_query($link, $SQLInsertDataDeposit_n);

// echo $SQLInsertDataDeopsit;
// echo $SQLUpdateDataRegfund1;
// exit();
header("location: wit-pay-tool.php");