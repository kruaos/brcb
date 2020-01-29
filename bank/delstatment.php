<?php 
$bankid="-".$_GET['bankid'];
$num=$_GET['num'];
include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$sql = "update eventbank set
        bankid=$bankid
		where num =".$num;
	$result = mysqli_query($link, $sql);
	if ($result)
	{
		echo "<center><span class='h1'>บันทึกข้อมูลเรียบร้อย<br></span>";
		mysqli_close($link);
	}
	else
	{
		echo "<center><span class='h1'>ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br></span><br>".$sql."<br>";
	}
	echo "<a href=../bank/addstatment.php?bankid=".$_GET['bankid'].">$back</a><br>";
?>