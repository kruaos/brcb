<?php
session_start();
$SessWorkID=$_SESSION['workroleid'];
$SessWorkNo=$_SESSION['workno']
if($SessWorkID<>'b'){
    header( "location: ../index.php" );
}
?>