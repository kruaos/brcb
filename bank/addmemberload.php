<meta charset="utf-8">
<link rel="stylesheet" href="../config/css1.css" type="text/css" />
<?php
session_start();
include('library.php'); include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="o")or($_SESSION['workroleid']=="b")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='../brcb/index.php'>$login</a> ";
		}else{
?>
<?php include('/library.php'); include('../config/config.php'); ?>
<title><?php echo$title;?></title>
<body>
<div id='container'>
<div id='tab'>
<button type='submit' id='btfind'></form>
</div>
</div>

<table class="header" width="	1000" align="center" >
<th colspan="10"><?php echo$title;?> : ตารางสมาชิก</th>
<tr>
<?php if ($_SESSION['workroleid']=='i'or $_SESSION['workroleid']=='a'){
	echo "<td class='c3'><b>แก้ไข</td>";
}?>

	<td class="c1"><b>เลขบัญชี</td>
	<td class="c2"><b>ชื่อ สกุล</td>
	<td class="c1"><b>ประเภทบัญชี</td>
	<td class="c2"><b>ที่อยู่</td>
	<td class="c1"><b>เบอร์โทรศัพท์</td>
	<td class="c2"><b>ยอดเงินบาท</td>
	<td class="c1"><b>ฝากครั้งล่าสุด</td>

</tr>
<?php
include('../config/config.php');
if($_GET['find']==null){
	$find="  ";
}else if(is_numeric($_GET['find'])){
	$find='and bankno='.$_GET['find'];
}else if(!is_numeric($_GET['find'])){
	$find="and mname like '".$_GET['find']."%'";
}
// บรรทัดนี้ ใช้สำหรับการแสดงสมาชิก ขณะนี้ต้องการเลือก เฉพาะ ปี 58
	$sql="SELECT * FROM memberbank where bankstatus='op'  and bankno<>0 $find order by lastupdate desc";
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);

	include('../config/config.php');
	$sql1="SELECT banktypename	FROM banktype_result where banktypeid=".$result['banktype'] ;
	$query1=mysqli_query($link,$sql1);
	$dbarr=mysqli_fetch_array($query1);

	$sql2="SELECT sum(income) as 'sbank' FROM evnetbank where bankno = " .$result["bankno"];
	$query2 = mysqli_query($link,$sql2);
	//$sbank=mysqli_fetch_array($query2);

		?>
<tr>
	</td>
<?php if ($_SESSION['workroleid']=='i'or $_SESSION['workroleid']=='a'){
	$editbank=$result['bankno'];
	echo "	<td class='c3'><a href='editmember.php? bankid=$editbank'>แก้ไข</a></td>";	}?>
	<td class="c1"><a href="reportbone.php? bankid=<?=$result["bankid"]?>">
<?php  $bankid=$result["bankid"];
echo $bankidshow=substr($bankid,0,2)."-".substr($bankid,2,2)."-".substr($bankid,4,4);
?>
</a>
</td>
	<td class="c2"><?=$result["pname"];?><?=$result["mname"];?> <?=$result["lname"];?></td>
	<td class="c1"><?php echo $dbarr["banktypename"];?></td>
	<td class="c2"><?=$result["address"];?></td>
	<td class="c1"><?=$result["telephone"];?></td>
	<td class="c2"><?php
	$sql3="SELECT sum(income) as 'sbank' FROM eventbank where bankid = " . $result["bankid"];
	$query3 = mysqli_query($link,$sql3);
	$sbank=mysqli_fetch_array($query3);
		echo number_format($sbank["sbank"],0,'.',',');?></td>
	<td class="c1"><?=$result["lastupdate"];?></div></tr>
<?php
		}
if (($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i")){$workroleid="admin";
 $addicon="<a href='addmember.php'>$add</a> </div></div> ";}else{
	if ($_SESSION['workroleid']=="b"){$workroleid="bank";}else if($_SESSION['workroleid']=="o"){$workroleid="office";}
	}
echo "</table><div id='container'><div id='tab'><a href=../".$workroleid."/>$back</a>"."  ";
echo $addicon;
}?>
