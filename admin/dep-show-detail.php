<?php
// Header & Navigation
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
?>
<style>
  .card-body {
    background: #f8f9fa;
    border-radius: 8px;
    margin-top: 20px;
  }

  .table-sm th,
  .table-sm td {
    font-size: 14px;
  }

  .table thead th {
    background: #007bff;
    color: #fff;
  }

  .btn-danger {
    margin-top: 10px;
  }

  h6 {
    margin-bottom: 20px;
  }

  .container-fluid {
    max-width: 1100px;
    margin: auto;
  }
</style>
<div class="container-fluid">
  <?php
  function show_day($showday)
  {
    $m_name = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    echo number_format(substr($showday, 8, 2)) . " " . $m_name[number_format(substr($showday, 5, 2))] . " " . (substr($showday, 0, 4) + 543);
  }

  include('../config/config.php');

  // Get member info
  $sql = "SELECT * FROM member WHERE IDMember=" . intval($_GET['IDMember']);
  $query = mysqli_query($link, $sql);
  $fullname = '';
  if ($rs1 = mysqli_fetch_array($query)) {
    $fullname = $rs1['Title'] . $rs1['Firstname'] . " " . $rs1['Lastname'];
  }
  ?>
  <div class="card-body">
    <h6 class="m-0 font-weight-bold text-primary"><?php echo htmlspecialchars($fullname); ?> -> ข้อมูลสมาชิกสัจจะ จาก regfund</h6>
    <table class="table table-sm table-bordered" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>รหัส</th>
          <th>IDRegFund</th>
          <th>IDFund</th>
          <th>Balance</th>
          <th>SumAmount</th>
          <th>จำนวน</th>
          <th>คงเหลือ</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql1 = "SELECT * FROM regfund WHERE IDMember=" . intval($_GET['IDMember']) . " ORDER BY IDFund";
        $query = mysqli_query($link, $sql1);
        $num = 0;
        $IDRegFund = array();
        while ($rs1 = mysqli_fetch_array($query)) {
          $IDRegFund[$num] = $rs1['IDRegFund'];
          $sql2 = "SELECT SUM(Amount) AS sumdep, COUNT(Amount) AS countdep FROM deposit WHERE IDRegFund=" . intval($rs1['IDRegFund']);
          $query2 = mysqli_query($link, $sql2);
          $rs2 = mysqli_fetch_array($query2);
        ?>
          <tr>
            <td><?php echo ++$num; ?></td>
            <td><?php echo $rs1['IDRegFund']; ?></td>
            <td><?php echo $rs1['IDFund']; ?></td>
            <td><?php echo number_format($rs1['Balance']); ?></td>
            <td><?php echo number_format($rs2['sumdep']) . " บาท"; ?></td>
            <td><?php echo $rs2['countdep'] . " ครั้ง"; ?></td>
            <td><?php echo number_format($rs1['Balance'] + $rs2['sumdep']) . " บาท"; ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
    <a href=" dep-show.php" class="btn btn-danger">ย้อนกลับ</a>

    <h6 class="m-0 font-weight-bold text-primary">รายละเอียดสมาชิกสัจจะ จาก deposit</h6>
    <div class="row">
      <table class="table table-sm table-bordered" cellspacing="0">
        <thead>
          <tr>
            <th>ที่</th>
            <th>วัน เดือน ปี</th>
            <th>เงินสัจจะ</th>
            <th>เพื่อนช่วยเพื่อน</th>
            <th>สัจจะ (เกิน)</th>
            <th>พชพ (เกิน)</th>
            <th>DepositStatus</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Get regfund accounts
          $show_sql = "SELECT * FROM regfund WHERE IDMember=" . intval($_GET['IDMember']) . " ORDER BY IDFund";
          $show_query = mysqli_query($link, $show_sql);
          $IDRegFund_array = array();
          while ($rsq = mysqli_fetch_array($show_query)) {
            $IDRegFund_array[] = $rsq['IDRegFund'];
          }

          // Group by CreateDate
          $sql_acc_group = "SELECT IDDeposit, CreateDate FROM deposit WHERE IDRegFund IN (" . implode(',', $IDRegFund_array) . ") GROUP BY CreateDate ORDER BY IDDeposit";
          $show_sq_acc_group = mysqli_query($link, $sql_acc_group);
          $sq_acc_group_array = array();
          while ($sq_acc_group = mysqli_fetch_array($show_sq_acc_group)) {
            $sq_acc_group_array[] = array($sq_acc_group['IDDeposit'], $sq_acc_group['CreateDate']);
          }

          // All deposits
          $sql_acc_notgroup = "SELECT IDDeposit, CreateDate, IDRegFund, Amount FROM deposit WHERE IDRegFund IN (" . implode(',', $IDRegFund_array) . ") ORDER BY IDDeposit";
          $show_sq_acc_notgroup = mysqli_query($link, $sql_acc_notgroup);
          $sq_acc_notgroup_array = array();
          while ($sq_acc_notgroup = mysqli_fetch_array($show_sq_acc_notgroup)) {
            $sq_acc_notgroup_array[] = array($sq_acc_notgroup['IDDeposit'], $sq_acc_notgroup['CreateDate'], $sq_acc_notgroup['IDRegFund'], $sq_acc_notgroup['Amount']);
          }

          // Display deposit details
          $show_num = 1;
          $m_name = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
          foreach ($sq_acc_group_array as $group) {
            $CreateDate = $group[1];
            $show_day = number_format(substr($CreateDate, 8, 2)) . " " . $m_name[number_format(substr($CreateDate, 5, 2))] . " " . (substr($CreateDate, 0, 4) + 543);
            echo "<tr>";
            echo "<td>" . $show_num . "</td>";
            echo "<td>" . $show_day . "</td>";
            // Find deposits for this date
            foreach ($sq_acc_notgroup_array as $deposit) {
              if ($deposit[1] == $CreateDate) {
                echo "<td>" . number_format($deposit[3]) . "</td>";
                $show_num++;
              }
            }
            echo "<td></td><td></td><td></td><td></td>"; // Empty columns for future UX/UI expansion
            echo "</tr>";
          }
          mysqli_close($link);
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php
  include('../tmp_dsh2/footer.php');
  ?>