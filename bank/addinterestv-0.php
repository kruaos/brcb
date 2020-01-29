<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" />
<?php
session_start();
?>
<title>ระบบคิดดอกเบี้ย</title>
<?php

$bankid=$_GET['bankid'];

// ------------->>แก้ปัญหา cck เช็ค โดยการทำแบบ switch-------------------------------------
if((substr($bankid,0,2))=='01'){
	echo substr($bankid,0,2);
	header("location:addinterestv-1.php?bankid=$bankid");
}else if ((substr($bankid,0,2))=='02'){
	echo substr($bankid,0,2);
	header("location:addinterestv-2.php?bankid=$bankid");

}else if ((substr($bankid,0,2))=='03'){	
	echo substr($bankid,0,2);
	header("location:addinterestv-3.php?bankid=$bankid");

}else if ((substr($bankid,0,2))=='04'){	
	echo substr($bankid,0,2);
	header("location:addinterestv-4.php?bankid=$bankid");

}else{	$sw=0;	}
//*********************************** แถวนนี้น่าจะต้องเขียนใหม่
?>
