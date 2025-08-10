<?php
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

// ฟังก์ชันแสดงวันที่แบบไทย
function show_day($showday)
{
  $m_name = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
  return number_format(substr($showday, 8, 2)) . " " . $m_name[number_format(substr($showday, 5, 2))] . " " . (substr($showday, 0, 4) + 543);
}

// Pagination
$perpage = 20;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$start = ($page - 1) * $perpage;

// Search
$search = isset($_GET['Fristname']) ? trim($_GET['Fristname']) : '';
$where = '';
if ($search != '') {
  $where = "WHERE (Firstname LIKE '%$search%' OR Lastname LIKE '%$search%' OR IDMember LIKE '$search%')";
}

// นับจำนวนทั้งหมด
$sql_count = "SELECT COUNT(*) FROM member $where";
$res_count = mysqli_query($link, $sql_count);
$total_record = mysqli_fetch_row($res_count);
$total_record = $total_record[0];
$total_page = ceil($total_record / $perpage);

// ดึงข้อมูลสมาชิก
$sql = "SELECT * FROM member $where ORDER BY IDMember LIMIT $start, $perpage";
$query = mysqli_query($link, $sql);
?>
<div class="container-fluid">
  <div class="card mt-4 shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">ข้อมูลสมาชิกสัจจะ</h5>
    </div>
    <div class="card-body">
      <!-- Search Form -->
      <form class="form-inline mb-3" action="index.php" method="GET">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="ค้นหาชื่อสมาชิก" name="Fristname" value="<?php echo htmlspecialchars($search); ?>">
          <div class="input-group-append">
            <button type="submit" class="btn btn-outline-primary">ค้นหา</button>
          </div>
        </div>
        <!-- Pagination -->


        <nav class="ml-3">
          <ul class="pagination mb-0">
            <?php
            $range = 2;
            $prev_page = $page - 1;
            $next_page = $page + 1;
            $search_param = $search ? '&Fristname=' . urlencode($search) : '';

            // Previous button
            echo '<li class="page-item' . ($page <= 1 ? ' disabled' : '') . '">';
            echo '<a class="page-link" href="index.php?page=' . ($prev_page) . $search_param . '">ย้อนกลับ</a>';
            echo '</li>';

            // Page numbers
            for ($i = max(1, $page - $range); $i <= min($total_page, $page + $range); $i++) {
              $active = ($i == $page) ? 'active' : '';
              echo '<li class="page-item ' . $active . '"><a class="page-link" href="index.php?page=' . $i . $search_param . '">' . $i . '</a></li>';
            }

            // Next button
            echo '<li class="page-item' . ($page >= $total_page ? ' disabled' : '') . '">';
            echo '<a class="page-link" href="index.php?page=' . ($next_page) . $search_param . '">ต่อไป</a>';
            echo '</li>';
            ?>
          </ul>
        </nav>


      </form>

      <!-- Table -->
      <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm">
          <thead class="thead-light">
            <tr>
              <th>รหัส</th>
              <th>ชื่อ - สกุล</th>
              <th>วันที่เป็นสมาชิก</th>
              <th>สถานะ</th>
              <th>regfund</th>
              <th>depositless</th>
              <th>loanbook</th>
              <th>loanpaymentless</th>
              <th>regbalance</th>
              <th>lastupdate</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($rs1 = mysqli_fetch_array($query)) {
              $IDMember = $rs1['IDMember'];
              // regfund
              $sql = "SELECT COUNT(*) FROM regfund WHERE IDMember=$IDMember";
              $q1 = mysqli_query($link, $sql);
              $regfund_count = mysqli_fetch_row($q1);
              $regfund_count = $regfund_count[0];
              // depositless
              $sql = "SELECT COUNT(*) FROM depositless WHERE IDMember=$IDMember";
              $q2 = mysqli_query($link, $sql);
              $depositless_count = mysqli_fetch_row($q2);
              $depositless_count = $depositless_count[0];
              // loanbook
              $sql = "SELECT COUNT(*) FROM loanbook WHERE IDMember=$IDMember";
              $q3 = mysqli_query($link, $sql);
              $loanbook_count = mysqli_fetch_row($q3);
              $loanbook_count = $loanbook_count[0];
              // loanpaymentless
              $sql = "SELECT COUNT(*) FROM loanpaymentless WHERE IDMember=$IDMember";
              $q4 = mysqli_query($link, $sql);
              $loanpaymentless_count = mysqli_fetch_row($q4);
              $loanpaymentless_count = $loanpaymentless_count[0];
              // regbalance
              $regbal = "SELECT Balance, LastUpdate FROM regfund WHERE IDfund=1 AND IDMember=$IDMember ORDER BY LastUpdate DESC LIMIT 1";
              $qreg = mysqli_query($link, $regbal);
              $regbalance = $lastupdate = '';
              if ($rs = mysqli_fetch_array($qreg)) {
                $regbalance = number_format($rs['Balance'], 2);
                $lastupdate = $rs['LastUpdate'];
              }
            ?>
              <tr>
                <td><?php echo sprintf('%04d', $IDMember); ?></td>
                <td>
                  <a href="dep-show-detail.php?IDMember=<?php echo $IDMember; ?>" class="font-weight-bold">
                    <?php echo $rs1['Title'] . $rs1['Firstname'] . " " . $rs1['Lastname']; ?>
                  </a>
                </td>
                <td><?php echo show_day($rs1['CreateDate']); ?></td>
                <td><span class="badge badge-info"><?php echo $rs1['MemberStatus']; ?></span></td>
                <td>
                  <?php if ($regfund_count): ?>
                    <a href="dep-regfund.php?IDMember=<?php echo $IDMember; ?>" class="btn btn-success btn-sm" title="ดูรายการ regfund"><?php echo $regfund_count; ?> รายการ</a>
                  <?php else: ?>
                    <span class="text-muted">ไม่พบข้อมูล</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($depositless_count): ?>
                    <a href="dep-depositless.php?IDMember=<?php echo $IDMember; ?>" class="btn btn-success btn-sm" title="ดูรายการ depositless"><?php echo $depositless_count; ?> รายการ</a>
                  <?php else: ?>
                    <span class="text-muted">ไม่พบข้อมูล</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($loanbook_count): ?>
                    <a href="dep-loanbook.php?IDMember=<?php echo $IDMember; ?>" class="btn btn-danger btn-sm" title="ดูรายการ loanbook"><?php echo $loanbook_count; ?> รายการ</a>
                  <?php else: ?>
                    <span class="text-muted">ไม่พบข้อมูล</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($loanpaymentless_count): ?>
                    <a href="dep-loanless.php?IDMember=<?php echo $IDMember; ?>" class="btn btn-danger btn-sm" title="ดูรายการ loanpaymentless"><?php echo $loanpaymentless_count; ?> รายการ</a>
                  <?php else: ?>
                    <span class="text-muted">ไม่พบข้อมูล</span>
                  <?php endif; ?>
                </td>
                <td><?php echo $regbalance ? $regbalance : '<span class="text-muted">-</span>'; ?></td>
                <td><?php echo $lastupdate ? show_day($lastupdate) : '<span class="text-muted">-</span>'; ?></td>
              </tr>
            <?php }
            mysqli_close($link); ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
<?php include('../tmp_dsh2/footer.php'); ?>