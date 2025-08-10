<?php
// Include necessary files
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

// รับค่า username และ date จาก GET parameter
$Username = isset($_GET['username']) ? $_GET['username'] : '';
$ReportDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// ฟังก์ชันแสดงวันที่แบบไทย
function show_day($showday) {
  $m_name = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
  return number_format(substr($showday, 8, 2)) . " " . $m_name[number_format(substr($showday, 5, 2))] . " " . (substr($showday, 0, 4) + 543);
}

?>
<div class="container-fluid">
<?php
// สร้าง SQL Query โดยใช้ username และวันที่ที่รับมา
$sql = "SELECT lp.*, m.IDMember, m.Firstname, m.Lastname 
    FROM loanpayment AS lp
    INNER JOIN loanbook AS lb ON lp.RefNo = lb.RefNo
    INNER JOIN member AS m ON m.IDMember = lb.IDMember
    WHERE lp.Username = '$Username' AND lp.LastUpdate = '$ReportDate'
    ORDER BY lp.Username DESC";

$queryloan = mysqli_query($link, $sql);

// แสดงหัวข้อรายงาน
echo "ประจำวันที่ " . show_day($ReportDate);
echo " จำนวน " . mysqli_num_rows($queryloan) . " ราย";
$sum1 = 0; $sum2 = 0; $sum3 = 0;
?>
<h6 class="m-0 font-weight-bold text-primary">รายละเอียดจาก loanpayment</h6>
<div class="row">
  <table class="table table-sm" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>IDLoanPay</th>
        <th>IDMember</th>
        <th>ชื่อสมาชิก</th>
        <th>RefNo</th>
        <th>CreateDate</th>
        <th>PayTotal</th>
        <th>Interest</th>
        <th>Payment</th>
        <th>Username</th>
      </tr>
    </thead>
    <tbody>
    <?php
    while ($rs1 = mysqli_fetch_array($queryloan)) {
      $IDLoanPay = $rs1['IDLoanPay'];
      $IDMember = $rs1['IDMember'];
      $FullName = $rs1['Firstname'] . " " . $rs1['Lastname'];
      $RefNo = $rs1['RefNo'];
      $CreateDate = $rs1['CreateDate'];
      $PayTotal = $rs1['PayTotal'];
      $Interest = $rs1['Interest'];
      $Payment = $rs1['Payment'];
      $Username = $rs1['Username'];

      $sum1 += $PayTotal;
      $sum2 += $Interest;
      $sum3 += $Payment;
    ?>
      <tr>
        <td><?php echo $IDLoanPay; ?></td>
        <td><?php echo $IDMember; ?></td>
        <td><?php echo $FullName; ?></td>
        <td><?php echo $RefNo; ?></td>
        <td><?php echo show_day($CreateDate); ?></td>
        <td style="text-align:right;"><?php echo number_format($PayTotal); ?></td>
        <td style="text-align:right;"><?php echo number_format($Interest); ?></td>
        <td style="text-align:right;"><?php echo number_format($Payment); ?></td>
        <td style="text-align:center;"><?php echo $Username; ?></td>
      </tr>
    <?php
    }
    ?>
      <tr class="table-active">
        <td></td>
        <td></td>
        <td><b>ยอดรวม</b></td>
        <td></td>
        <td></td>
        <td style="text-align:right;"><?php echo number_format($sum1); ?></td>
        <td style="text-align:right;"><?php echo number_format($sum2); ?></td>
        <td style="text-align:right;"><?php echo number_format($sum3); ?></td>
        <td></td>
      </tr>
    </tbody>
  </table>
</div>
</div>
<?php
mysqli_close($link);
include('../tmp_dsh2/footer.php');
?>
