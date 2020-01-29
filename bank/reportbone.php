<?php 
include('config/chkbank.php');
include('config/setstatus.php');
include('../config/config.php');
?>

<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title><?=$title;?> : ตารางสรุป</title>
<div 
id="container">
<div id='tab'>
<?php $bankid=$_GET['bankid'];
	$sql = "select * from memberbank where bankid = '$bankid';";
		$result = mysqli_query($link, $sql);
		$dbarr = mysqli_fetch_array($result);
		$fullname=$dbarr["pname"].$dbarr["mname"]."  ".$dbarr["lname"] ;
?>


<table  class="header" width="1000" align="center" ><tr>
<th colspan="10" > ข้อมูลการฝากเงินของ <?=$fullname; ?> </th></tr>
<tr><th  colspan="10">รหัสสมาชิก <?php echo $bankid;?></th></tr>
<tr>
	<td class="c1" ><b>วันที่ทำรายการ</td>
	<td class="c2"><b>ฝาก</td>
	<td class="c1"><b>ถอน</td>
	<td class="c2"><b>คงเหลือ</td>
	<td class="c1"><b>เจ้าหน้าที่ฝาก</td>
	<td class="c2"><b>สถานะ</td>
</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
	$sql="SELECT a.*, b.* FROM eventbank a , worker b where a.workno = b.workno and bankid=".$bankid." order by a.createdate";
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);
	$balance=0;
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);
		$income=$result['code'];
			$sql1="SELECT a.*,b.* FROM eventbank a , evcode b where a.code = b.codeid and num = " .$result['num'];
			$query1 = mysqli_query($link,$sql1);
			$dbarr=mysqli_fetch_array($query1);		
			if ($dbarr['code']=='wi'){
					$code="red";}else{$code="black";
				}
?> 
<tr>
	<td class="c1" width="15%"><font aling=right color="<?=$code;?>">

		<?php 

		echo substr($result['deptime'],0,2)." ".$mname[number_format(substr($result['deptime'],3,2))-1]." ".substr($result['deptime'],6,2);
		?>
		
		</font>
	</td>
	<td align='right' bgcolor='#ffffff' width="18%"><font color="<?=$code;?>"><?php if($income=='de'or $income=='in'or $income=='bl'){echo number_format($result['income'],2,'.',',');}else{echo "-";} ?></font></td>
	<td align='right' bgcolor='#ffffff' width="18%"><font color="#ff0000"><?php if($income=='wi'){echo number_format($result['income'],2,'.',',');}else{echo "-";} ?></font></td>
	<?php if ($income=='w'){$income=-$result['income'];}else{$income=$result['income'];}  ?> 
	<td align='right'  width="18%"><font color="
	<?=$code;?>">
	<?php $balance=$balance+$income; 
	echo number_format($balance,2,'.',',');   ?></font></td>
	<td class="c1" width="20%"><font color="<?=$code;?>"><?=$result["username"];?></font></td>
	<td class="c2" width="11%"><font color="<?=$code;?>"><?=$dbarr["codename"];?></font></td>
</tr>
</div>
<?php
echo"</font>";
			}
$sql7 ="update bookbankbalance2 set  bookbalance='$balance' where bankid=$bankid";
$result7 = mysqli_query($link, $sql7);
mysqli_close($link);		
if (($SessWorkID=="a")or($SessWorkID=="i"))	{$workroleid="admin";}
else{$workroleid="bank";}
?>
</table><div id='container'><div id='tab'>
<a href="../<?=$workroleid;?>/addstatment.php?bankid=<?=$bankid;?>"><?=$addacc;?></a>
<a href="../<?=$workroleid;?>/viwemember.php"><?=$back;?></a>
<a href="../bank/addinterestv-0.php?bankid=<?=$bankid;?>"><img src='../image/addint.png'></a>
</div></div>";
