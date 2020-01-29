<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" /> 
<title>ระบบสินเชื่อ(คืนเงินกู้)</title>
<div id="container">
<form name="โหลดถอน" method="post" action="loanpayment.php">
	<div id="header">ระบบสินเชื่อ(คืนเงินกู้)</div>
	<div id="tab">
		<div id="menu">รหัสสมาชิก</div>
		<div id="content"><input type="text" name="loanno" />
		  <input type="submit" name="send" value="ค้นหา" /></div>
</form>	</div>
</div>

<br>

<table class="header" width="1000" align="center" >
<th  colspan="10"  > ตารางถอนเงินออมทรัพย์สัจจะ </th>
<tr>
	<td class="c1">รหัสเงินกู้</td>
	<td class="c2">ชำระเงินต้น</td>
	<td class="c1">ชำระดอกเบี้ย</td>
	<td class="c2">ยอดชำระรวม</td>
	<td class="c1">งวดที่</td>
	<td class="c2">วันที่ทำรายการ</td>


</tr>
<?php //เริ่มการวบรอบดึงข้อมูล
include('../config/config.php');
// สูตร ค่อยทำแยกตามกรรมการ อ้างอิงตม sestion

	$sql="SELECT * FROM eventloan";
	$query=mysqli_query($link,$sql);
/* การเขียนค่าคำสั่ง ครั้ง ยังไม่สามรรถจัดการได้  */
	$time=0;

	
	//ใช้ numrows ในการนับแถว
	$numrows=mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);	  
		$amount =$result["payment"]+$result["reciveinterest"];
?> 
<tr>
	<td class="c1"><?=$result["loanno"];?></td>
	<td class="c2"><?=$result["payment"];?></td>
	<td class="c1"><?=$result["reciveinterest"];?></td>
	<td class="c2"><?php echo $amount;?></td>
	<td class="c1"><?php echo $time;?></td>
	<td class="c2"><?=$result["createdate"];?></td>

</tr>


<?php
}
?>  
</table>
<a href="../loan/">กลับหน้าเว็บหลัก</a>