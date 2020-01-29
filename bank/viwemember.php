<?php 
include('config/setstatus.php');
include('../config/config.php');
?>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../config/css/bootstrap.min.css">
  <script src="../config/js/jquery.min.js"></script>
  <script src="../config/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../config/css1.css" type="text/css" />
<?php

?>

<title><?php echo$title;?></title>
<body>
<!-- เปิดตาราง	--><h2><center>
<?php echo$title;?> : ตารางสมาชิก</h1>
<table class="header" width="1000" align="center">

<th colspan="10"> <form action=reportbone.php? method="get"><label>ค้นหาจากเลขบัญชี </label>
	<input type="text" name="bankid">
	<button type="submit" >ค้นหา</button>
	<a href="../bank/">[ย้อนกลับ]</a> 	
</form></th>
<tr>
	<td class="c1"><b>เลขบัญชี</td>
	<td class="c2"><b>ชื่อ สกุล</td>
	<td class="c2"><b>ยอดเงินบาท</td>
	<td class="c1"><b>ฝากครั้งล่าสุด</td>
</tr>
<?php
include('../config/config.php');
	$sql="SELECT memberbank.*, bookbankbalance2.* FROM memberbank, bookbankbalance2 where memberbank.bankid=bookbankbalance2.bankid and bankstatus='op' order by bookbankbalance2.lastupdate desc ";
	$query=mysqli_query($link,$sql) or die ("Error Query [".$sql."]");
		$Num_Rows = mysqli_num_rows($query);
		$Per_Page = 20;   // Per Page
		error_reporting( error_reporting() & ~E_NOTICE );
		$Page = $_GET["Page"];
		if(!$_GET["Page"])
				{
					$Page=1;
				}

				$Prev_Page = $Page-1;
				$Next_Page = $Page+1;

				$Page_Start = (($Per_Page*$Page)-$Per_Page);
				if($Num_Rows<=$Per_Page)
				{
					$Num_Pages =1;
				}
				else if(($Num_Rows % $Per_Page)==0)
				{
					$Num_Pages =($Num_Rows/$Per_Page) ;
				}
				else
				{
					$Num_Pages =($Num_Rows/$Per_Page)+1;
					$Num_Pages = (int)$Num_Pages;
				}

		$sql .=" LIMIT $Page_Start , $Per_Page";
		$query  = mysqli_query($link,$sql) or die ("Error Query [".$sql."]") ;

while($result = mysqli_fetch_array($query))
{
?>
<tr>
	<td class="c1"><a href="reportbone.php? bankid=<?=$result["bankid"]?>">
<?php  $bankid=$result["bankid"];
echo $bankidshow=substr($bankid,0,2)."-".substr($bankid,2,2)."-".substr($bankid,4,4);
?>
</a>
</td>
	<td class="c2"><?php echo$result["bankname"]; ?></td>
	<td class="c2"><?php 
			$bankid=$result["bankid"];
			$sql2="SELECT * FROM bookbankbalance2 where bankid=$bankid";
			$query2=mysqli_query($link,$sql2) or die ("Error Query [".$sql2."]");
			$result2 = mysqli_fetch_array($query2);
			echo number_format($result2["bookbalance"],2,'.',',');?>
	</td>
	<td class="c1"><?php echo $result2["lastupdate"];?></div></tr>
<?php

	}



?>

</table>

<p>  รวมทั้งสิ้น <?php echo $Num_Rows;?> รายการ  : <?php echo $Num_Pages;?> หน้าที่ :
  <?php
if($Prev_Page)
{
	echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page'><< Back</a> ";
}

for($i=1; $i<=$Num_Pages; $i++){
	if($i != $Page)
	{
		echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i'>$i</a> ]";
	}
	else
	{
		echo "<b> $i </b>";
	}
}
if($Page!=$Num_Pages)
{
	echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page'>Next>></a> ";
}
mysqli_close($link);
?>
</p>
