<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
?>
<!-- Bootstrap 4 & jQuery CDN -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

<div class="container my-4">
<?php 
function show_day($showday){
  $m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  return number_format(substr($showday, 8,2))." ".$m_name[number_format(substr($showday, 5,2))]." ".(substr($showday, 0,4)+543);
}
function type_bank($bankid){
  $type = array("","ฝากประจำ 3 เดือน","ฝากประจำ 6 เดือน","ฝากประจำ 12 เดือน","ออมทรัพย์");
  return  $type[substr($bankid,1,1)];
}
include('../config/config.php');

$sql = "select * from bankmember where bankid ='".$_GET['bankid']."'";
$qinfo = mysqli_query($link, $sql);
while($rsinfo = mysqli_fetch_array($qinfo)) {
  $fullname= $rsinfo['pname'].$rsinfo['fname']." ".$rsinfo['lname'];
  $bankname= $rsinfo['bankname'];
  $bankid=$rsinfo['bankid'];
  $type_bank=type_bank($rsinfo['bankid']);
}
?>

<div class="card shadow mb-4">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0">บัญชี: <?php echo $bankname; ?> (<?php echo $bankid; ?>)</h5>
    <small>เจ้าของบัญชี: <?php echo $fullname; ?> | ประเภท: <?php echo $type_bank; ?></small>
  </div>
  <div class="card-body">
    <!-- Search box -->
    <div class="row mb-3">
      <div class="col-md-6">
        <input type="text" id="searchInput" class="form-control" placeholder="ค้นหารายการ...">
      </div>
      <div class="col-md-6 text-right">
        <span id="currentBalance" class="badge badge-success p-2"></span>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered table-hover" id="statementTable">
        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>วันที่</th>
            <th>สถานะ</th>
            <th class="text-right">ฝาก</th>
            <th class="text-right">ถอน</th>
            <th class="text-right">คงเหลือ</th>
            <th>วันบันทึก</th>
            <th>เลขที่งาน</th>
          </tr>
        </thead>
        <tbody>
<?php 
if (isset($_GET['bankid'])){
  $sql = "select * from bankevent where bank_event_status='1' and code<>'del' and bankid =".$_GET['bankid']." order by createdate ";
}else{
  $sql = "select * from bankevent where bank_event_status='1' order by createdate ";
}
$query = mysqli_query($link, $sql);
$num=0; $amount=0; 
while($rs1 = mysqli_fetch_array($query)) {
  $num++;
  $isDeposit = $rs1['income'] > 0;
  $isWithdraw = $rs1['income'] < 0;
  $amount += $rs1['income'];
?>
          <tr>
            <td><?php echo $num; ?></td>
            <td><?php echo show_day(substr($rs1['createdate'],0,10)); ?></td>
            <td>
              <?php if($isDeposit) { ?>
                <span class="badge badge-success">ฝาก</span>
              <?php } elseif($isWithdraw) { ?>
                <span class="badge badge-danger">ถอน</span>
              <?php } else { echo $rs1['code']; } ?>
            </td>
            <td class="text-right"><?php echo $isDeposit ? number_format($rs1['income'],2) : ''; ?></td>
            <td class="text-right"><?php echo $isWithdraw ? number_format(abs($rs1['income']),2) : ''; ?></td>
            <td class="text-right"><?php echo number_format($amount,2); ?></td>
            <td><?php echo $rs1['createdate']; ?></td>
            <td><?php echo $rs1['workno']; ?></td>
          </tr>
<?php 
} 
?>
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      <a href="bank-show.php" class="btn btn-danger">ย้อนกลับ</a>
      <a href="bank-event-edit.php?bankid=<?php echo $_GET['bankid']; ?>" class="btn btn-success">แก้ไข</a>
      <a href="bank-inte-<?php echo substr($_GET['bankid'],0,2) ?>.php?bankid=<?php echo $_GET['bankid']; ?>" class="btn btn-warning">คิดดอกเบี้ย</a>
    </div>
  </div>
</div>

<script>
$(function(){
  // Search/filter table
  $("#searchInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#statementTable tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  // Show current balance
  var lastBalance = $("#statementTable tbody tr:last td:eq(5)").text();
  $("#currentBalance").text("ยอดคงเหลือปัจจุบัน: " + lastBalance);
});
</script>

<?php 
include('../tmp_dsh2/footer.php');
?>
