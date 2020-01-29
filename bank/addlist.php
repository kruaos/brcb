<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" />
<?php
session_start();
include('library.php');include('../config/config.php');
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="b")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='../brcb/index.php'>$login</a> ";
		}else{
		if($_GET['code']==null){
?>
<title>เมนูบันทึกยอดเงินฝาก-ถอน</title>
<form name='เพิ่มข้อมูลธนาคาร'>
<table align='center'width='80%'>
    <tr>
        <td>รหัสบัญชี</td><td>ชื่อ-สกุล</td><td>ยอดคงเหลือ</td><td>ฝาก/ถอน</td>
    </tr>
        <td><input type="text" name="code"></td>
        <td><input type="text" name="namebank"></td>
        <td><input type="text" name="balance"></td>
        <td><input type="text" name="amount"></td>
    </tr>
    <tr>
    <td colspan='4'>
			<button type="submit">บันทึก</button>
			<button formaction='../bank/'name='ย้อนกลับ'>ยกเลิก</button>
	</form></td>
    </tr>
</table>
<?php
$nowdate=date("Y-m-d");
$sql="select * FROM `eventbankaddlist` where createdate ";
$query=mysqli_query($link,$sql);
$numrows=mysqli_num_rows($query);

?>
<table align="center" width="1000">
	<tr>
		<td class="c1"><b>ลำดับ</td>
		<td class="c1"><b>รหัสบัญชี</td>
		<td class="c1"><b>ชื่อสมาชิก</td>
		<td class="c1"><b>ยอดคงเหลือ</td>
		<td class="c1"><b>จำนวนฝาก/ถอน</td>
	</tr>
<?php
	for($i=1;$i<=$numrows;$i++){
	$result=mysqli_fetch_array($query);
?>
	<tr>
		<td class="c1"><?php echo $result["num"];?></td>
		<td class="c1"><?php echo $result["code"];?></td>
		<td class="c1"><font color="<?=$code;?>"><?php echo $result["namebank"];?></font></td>
		<td class="c1"><font color="<?=$code;?>"><?php echo $result["balance"];?></font></td>
		<td class="c1"><font color="<?=$code;?>"><?php echo $result["amount"];?></font></td>
	</tr>

<?php
	}
echo "</table>";
}else{
$code=$_GET['code'];
$balance=$_GET['balance'];
$namebank=$_GET['namebank'];
$amount=$_GET['amount'];
$createdate=date("Y-m-d H:i:s");


	include('../config/config.php');
		mysqli_set_charset($link,'utf8');
		$sql = "Insert into eventbankaddlist (code,namebank,balance,amount,createdate) values(
			'$code','$namebank','$balance','$amount','$createdate')";
		$result = mysqli_query($link, $sql);
		if($result)	{
			echo "<center><span class='h1'>บันทึกข้อมูลลงในฐานข้อมูลประสบความสำเร็จ<br></span>";
			mysqli_close($link);
		}	else	{
			echo $createdate."<center><span class='h1'>ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br></span>";
		}
echo "<META HTTP-EQUIV='Refresh' CONTENT='1;URL=addlist.php'>";
	}
}

		?>
