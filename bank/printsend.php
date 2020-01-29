<?php
session_start();
include('library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="b")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='../brcb/index.php'>$login</a> ";
		}else{
$workno=$_SESSION['workno'];
$sql="select a.pname,a.mname,a.lname,c.rolename
from memberfund a, worker b, workrole_result c
where b.workroleid=c.workroleid and a.fundno=b.fundno and b.workno=".$_SESSION['workno'];
$query=mysqli_query($link,$sql);
$dbarr=mysqli_fetch_array($query);
?>

<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" />
<title><?=$title;?> : ตารางสรุป</title>
<div id="container">
<div id="container">
<div id='titlebar'>
<b>ข้อมูลการส่งเงินฝาก ของ </b> <?php echo $dbarr['pname'].$dbarr['mname']."  ".$dbarr['lname'];?><br>
<b>ตำแหน่ง </b><?=$dbarr['rolename'];?>
</div>
<div id='tab1'>
<table  width="1000" align="center" border=0>
<tr>
	<td>ฝาก สะสม</td>
	<td>ถอน สะสม</td>
	<td>ฝาก 3 เดือน</td>
	<td>ถอน 3 เดือน</td>
	<td>ฝาก 6 เดือน</td>
	<td>ถอน 6 เดือน</td>
	<td>ฝาก 12 เดือน</td>
	<td>ถอน 12 เดือน</td>
</tr>
<tr>

<?php
$yearnow=date('Y');
$daynow=date('d');
for($c=1;$c<=4;$c++){
include('../config/config.php');
	echo "<td valign=top><table border=1 width=100%>";
	$sql1="select income from eventbank where code='de' and substr(bankid,1,2)=$c and workno=$workno and $yearf=$yearnow  and $day=$daynow  order by createdate";
	$query1=mysqli_query($link,$sql1);
	$numrows1=mysqli_num_rows($query1);
		for($i=1;$i<=$numrows1;$i++){
		$result1=mysqli_fetch_array($query1);
		$icome1=$result1['income'];
	echo "	<tr><td align=right>".number_format($icome1,2,'.',',')."</td></tr>		";}
	$sql1="select sum(income) as 'sum' from eventbank where code='de' and substr(bankid,1,2)=$c and workno=$workno and $yearf=$yearnow  and $day=$daynow  order by createdate";
	$query1=mysqli_query($link,$sql1);
	$result1=mysqli_fetch_array($query1);
	$sumin1=$result1['sum'];
	echo "<tr>	<td align=right><b>".number_format($sumin1,2,'.',',')."</b></td>	</tr></table></td>";
		echo "<td valign=top><table border=1 width=100%>";
	$sql1="select income from eventbank where code='wi' and substr(bankid,1,2)=$c and workno=$workno and $yearf=$yearnow  and $day=$daynow order by createdate";
	$query1=mysqli_query($link,$sql1);
	$numrows1=mysqli_num_rows($query1);
		for($i=1;$i<=$numrows1;$i++){
		$result1=mysqli_fetch_array($query1);
		$icome1=$result1['income'];
	echo "	<tr><td align=right>".number_format($icome1,2,'.',',')."</td></tr>		";}
	$sql1="select sum(income) as 'sum' from eventbank where code='wi' and substr(bankid,1,2)=$c and workno=$workno and $yearf=$yearnow  and $day=$daynow   order by createdate";
	$query1=mysqli_query($link,$sql1);
	$result1=mysqli_fetch_array($query1);
	$sumin1=$result1['sum'];
	echo "<tr>	<td align=right><b>".number_format($sumin1,2,'.',',')."</b></td>	</tr></table></td>";
}
?>

</tr>
</table>
<?php /*
</div>
<table  class="header" width="1000" align="center" >
<th colspan="10" > <?=$worktitle." วันที่ ".date("Y-m-d");?> : ตารางสรุป</th>
<tr>
	<td class="c1"><b>เลขบัญชี</td>
	<td class="c2"><b>ชื่อสมาชิก</td>
	<td class="c1"><b>ยอดเงินฝาก</td>
	<td class="c2"><b>ยอดเงินถอน</td>
	<td class="c1"><b>วันที่/ เวลา ที่ทำรายการ</td>
	<td class="c2"><b>ประเภท</td>

</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
include('../config/config.php');
// สูตร ค่อยทำแยกตามกรรมการ อ้างอิงตม sestion
$workno=$_SESSION['workno'];

	$sql="SELECT * FROM eventbank where workno=$workno and $yearf=$yearnow  and $day=$daynow  order by createdate";
	$query=mysqli_query($link,$sql);
	$numrows=mysqli_num_rows($query);

		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);

	$sql1="SELECT a.*,b.*,c.* FROM eventbank a , evcode b , memberbank c
	where a.code = b.codeid and a.bankid=c.bankid and num = " .$result['num'];
	$query1 = mysqli_query($link,$sql1);
	$dbarr=mysqli_fetch_array($query1);
	$fullname=$dbarr['pname'].$dbarr['mname']."  ".$dbarr['lname'];
	if ($result['code']=='wi'){	$code="red";}else{$code="black";}
?>
<tr >
	<td class="c1"><font color="<?=$code;?>"><?php  $bankid=$result["bankid"];
echo $bankidshow=substr($bankid,0,2)."-".substr($bankid,2,2)."-".substr($bankid,4,4);
?></font></td>
	<td class="c2"><font color="<?=$code;?>"><?=$fullname;?></font></td>
	<td class="c1"><font color="<?=$code;?>"><?=$result["income"];?></font></td>
	<td class="c2"><font color="<?=$code;?>"><?=$result["income"];?></font></td>
	<td class="c1"><font color="<?=$code;?>"><?=$result["createdate"];?></font></td>
	<td class="c2"><font color="<?=$code;?>"><?=$dbarr["codename"];?></font></td>

</tr>
<?php
	}

	$sql2="SELECT sum(income) as 'sincomde' FROM eventbank where code='de' and workno=$workno and $yearf=$yearnow and $day=$daynow  order by createdate";
	$query2=mysqli_query($link,$sql2);
	$sumd=mysqli_fetch_array($query2);
	$sql3="SELECT sum(income) as 'sincomwi' FROM eventbank where code='wi' and workno=$workno and $yearf=$yearnow  and $day=$daynow   order by createdate";
	$query3=mysqli_query($link,$sql3);
	$sumw=mysqli_fetch_array($query3);
	?>

<tr>
	<td class="c6"><b></td>
	<td class="c4"><b>สรุปยอดเงิน</td>
	<td id="totel1" ><b><b><?=number_format($sumd['sincomde'],2,'.',',');?></td>
	<td id="totel1" ><b><b><?=number_format($sumw['sincomwi'],2,'.',',');?></td>
	<td class="c6"></td>
	<td class="c6"></td>
</tr>
*/?>
<?php
if (($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i")){$workroleid="admin";}else{$workroleid="bank";}
echo "</table><div id='container'><div id='tab'><a href=../".$workroleid."/>$back</a>";}
?>
<a href=''>ปริ้นสรุปส่งเงิน</a>
</div></div>

