<?php 
ob_start();
session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('../config/config.php');

$employee_use=$_SESSION['employee_USER'];
$IDMember= $_POST['IDMember'];

$SRFArray=array();
// Check IDMember is 1) type member  dep 2) type member  dep+ins 3) type member  dep + ins + lat  

$ShowMember="select m.Title, m.Firstname, m.Lastname, m.MemberStatus 
from Member as m where  m.IDMember=$IDMember";
$SMQuery= mysqli_query($link, $ShowMember);
while ($SM= mysqli_fetch_array($SMQuery)){
    $FullNameMember=$SM['Title'].$SM['Firstname']." ".$SM['Lastname'];
}
$n=1;
$ShowRegfund="select * from regfund where  IDMember=$IDMember order by IDFund ASC";
$SRfQuery= mysqli_query($link, $ShowRegfund);
while ($SRf= mysqli_fetch_array($SRfQuery)){
    $SRFArray[$n]['IDRegFund']= $SRf['IDRegFund'];
    $SRFArray[$n]['IDFund']= $SRf['IDFund'];
    $SRFArray[$n]['LastUpdate']= $SRf['LastUpdate'];
    $SRFArray[$n]['Closedate']= $SRf['Closedate'];
    $SRFArray[$n]['Balance']= $SRf['Balance'];
    $n++;
}
echo count($SRFArray);
echo"<pre>";
print_r($SRFArray);
echo"</pre>";

$IDDeposit1="";
$IDRegFund1=$SRFArray[1]['IDRegFund'];
$Username1=$employee_use;
$CreateDate1 = date('Y-m-d');
$LastUpdate1 = date('Y-m-d'); 
$Amount1=$_POST['Amount1'];
$Receive1="I";
$DepositStatus1="P";


$SRfQuery2= mysqli_query($link, $ShowRegfund);
while ($SRf2= mysqli_fetch_array($SRfQuery2)){
     $IDRegFund5= $SRf2['IDRegFund'];
    $IDRegFund2=$IDRegFund5;
}
;
$IDDeposit2="";
// $IDRegFund2=$SRFArray[2]['IDRegFund'];
$Username2=$employee_use;
$CreateDate2= date('Y-m-d');
$LastUpdate2= date('Y-m-d'); 
$Amount2=$_POST['Amount2'];
$Receive2="I";
$DepositStatus2="P";

// insert value deposit 
$SQLInsertDataDeopsit="INSERT INTO `deposit`(`IDDeposit`, `IDRegFund`, `Username`, `CreateDate`, `LastUpdate`, `Amount`, `Receive`, `DepositStatus`) 
VALUES 
('$IDDeposit1','$IDRegFund1','$Username1','$CreateDate1','$LastUpdate1','$Amount1','$Receive1','$DepositStatus1'),
('$IDDeposit2','$IDRegFund2','$Username2','$CreateDate2','$LastUpdate2','$Amount2','$Receive2','$DepositStatus2')";
echo $SQLInsertDataDeopsit;
echo "<br>";

// insert value regfund  
$IDRegFund1=$SRFArray[1]['IDRegFund'];
$LastUpdate1=date('Y-m-d');
$Balance1=$SRFArray[1]['Balance'] + $Amount1;
$IDRegFund2=$SRFArray[2]['IDRegFund'];
$LastUpdate2=date('Y-m-d');
$Balance2=$SRFArray[2]['Balance'] + $Amount2;

$SQLUpdateDataRegfund1 = "UPDATE `regfund` SET `LastUpdate`='$LastUpdate1' ,`Balance`= '$Balance1' WHERE IDRegFund=$IDRegFund1";
$SQLUpdateDataRegfund2 = "UPDATE `regfund` SET `LastUpdate`='$LastUpdate2' ,`Balance`= '$Balance2' WHERE IDRegFund=$IDRegFund2";
echo $SQLUpdateDataRegfund1;
echo "<br>";
echo $SQLUpdateDataRegfund2;

$ResultInsertDataDeposit = mysqli_query($link, $SQLInsertDataDeopsit);
$ResultUpdataRegfund1 = mysqli_query($link, $SQLUpdateDataRegfund1);
$ResultUpdataRegfund2 = mysqli_query($link, $SQLUpdateDataRegfund2);

header("location: dep-pay-tool.php");

?>
