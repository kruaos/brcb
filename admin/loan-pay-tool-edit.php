<?php
ob_start();

session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');
$employee_use = $_SESSION['LoanEmplopeeUser'];
$IDLoanPay = $_GET['IDLoanPay'];
$IDMember = $_GET['IDMember'];
$RefNo = $_GET['RefNo'];

function show_day($showday)
{
	$m_name = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
	echo  number_format(substr($showday, 8, 2)) . "  " . $m_name[number_format(substr($showday, 5, 2))] . " " . (substr($showday, 0, 4) + 543);
}


?>

<script language="JavaScript">
	function fncSum() {
		// var num = '';     
		var sum = 0;
		for (var i = 0; i < document.frmprice['price[]'].length; i++) {
			num = document.frmprice['price[]'][i].value;
			if (num != "") {
				sum += parseFloat(num);
			}
		}
		document.frmprice.amount_loan.value = sum;
	}
</script>


<div class="container-fluid">
	<div class="row">
		<div class="p-3 mb-2 col bg-warning">
			<h1 class="display-5">ชำระเงินกู้</h1> รหัสเจ้าหน้าที่ : <?php echo $employee_use; ?>
		</div>
	</div>
	<div class="row">
		<!-- ส่วนแสดงรายละเอียดผู้กู้ -->
		<div class="col-4 d-print-none">
			<form name="frmprice" method="POST" action="loan-pay-tool-update.php">
				<?php
				$sql = "select * from member where IDMember='$IDMember'";
				$query = mysqli_query($link, $sql);
				while ($rs1 = mysqli_fetch_array($query)) {
					$FullName = $rs1['Title'] . $rs1['Firstname'] . " " . $rs1['Lastname'];
				}
				$LoanPaymentSql = "SELECT * from loanpayment where IDLoanPay='$IDLoanPay'";
				$LoanPaymentQueary = mysqli_query($link, $LoanPaymentSql);
				// print_r($LoanPaymentSql);
				while ($LPQ = mysqli_fetch_array($LoanPaymentQueary)) {
					$Interest = $LPQ['Interest'];
					$Payment = $LPQ['Payment'];
					$PayTotal = $LPQ['PayTotal'];
					$IDLoanPay = $LPQ['IDLoanPay'];
					$CreateDate = $LPQ['CreateDate'];
				}
				?>
				<div class="form-group">
					<label>วันที่จ่าย</label>
					<input style="font-size:30px;" type="date" class="form-control " name="CreateDate" value="<?php echo $CreateDate ; ?>">
				</div>
				<div class="form-group">

					<span style="font-size:24px;"><b> ชื่อ-สกุล : </b> <?php echo $FullName;  ?></span> <br>
					<span style="font-size:24px;color:red"><b>รหัสสมาชิก :</b> <?php echo $IDMember;  ?> </span> <br>

					<label>เงินต้น</label>
					<input type="text" style="font-size:30px; text-align:right" class="form-control" value="<?php echo number_format($PayTotal, 0); ?>" id="price[]" name="Payment_loan" onkeyup="fncSum();">
					<label>ดอกเบี้ย</label>
					<input type="text" style="font-size:30px; text-align:right" class="form-control" value="<?php echo number_format($Interest, 0); ?>" id="price[]" name="instal_loan" onkeyup="fncSum();">
					<label>รวมจ่าย</label>
					<input type="text" style="font-size:30px;  text-align:right" class="form-control" value="<?php echo number_format($Payment, 0); ?>" name="amount_loan" autofocus>
					<br>
					<input type="hidden" value="<?php echo $RefNo; ?>" name="RefNo">
					<input type="hidden" value="<?php echo $employee_use; ?>" name="Username">
					<input type="hidden" value="<?php echo $IDLoanPay; ?>" name="IDLoanPay">
					<input type="hidden" value="<?php echo $IDMember; ?>" name="IDMember">

					<input type='submit' class="btn btn-warning col" value="ปรับปรุง">
				</div>
			</form>
			
			<a href='loan-pay-tool-show.php' class="btn btn-danger col">ย้อนกลับ</a>

		</div>
		<!-- ส่วนแสดงรายการ ที่ชำระ -->
		<?php
		include('../config/config.php');
		$date_now = date('Y-m-d');
		// $date_now='2019-05-05';
		$sql_show_loanpayment = "SELECT * from loanpayment where RefNo='$RefNo' order by createdate DESC ";
		$q_show_loanpayment = mysqli_query($link, $sql_show_loanpayment);
		// print_r($sql_show_loanpayment);
		?>
		<div class="col">
			<table class="table table-bordered" id='EdataTable'>
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">วัน เดือน ปี </th>
						<th scope="col">เลขบัญชี</th>
						<th scope="col">เงินต้น</th>
						<th scope="col">ดอกเบี้ย</th>
						<th scope="col">รวมจ่าย</th>
						<th scope="col">user</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$num = 1;
					while ($rs_show_lpm = mysqli_fetch_array($q_show_loanpayment)) {
					?>
						<tr>
							<th scope="row"><?php echo $num;
											$num = $num + 1 ?></th>
							<td><?php echo show_day($rs_show_lpm['CreateDate']); ?></td>
							<td><?php echo $rs_show_lpm['RefNo']; ?></td>
							<td><?php echo number_format($rs_show_lpm['PayTotal']); ?></td>
							<td><?php echo number_format($rs_show_lpm['Interest']); ?></td>
							<td><?php echo number_format($rs_show_lpm['Payment']); ?></td>
							<td><?php echo $rs_show_lpm['Username']; ?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?PHP
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>