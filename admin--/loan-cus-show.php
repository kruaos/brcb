<?php
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');
$memberID = $_GET['memid'];

?>
<div class="container-fluid">
  <?php
  function show_day($showday)
  {
    $m_name = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    echo  number_format(substr($showday, 8, 2)) . "  " . $m_name[number_format(substr($showday, 5, 2))] . " " . (substr($showday, 0, 4) + 543);
  }

  $sql2 = "SELECT * from member where IDMember= $memberID";
  $query2 = mysqli_query($link, $sql2);
  while ($rs = mysqli_fetch_array($query2)) {
    $fullname = $rs['Title'] . $rs['Firstname'] . " " . $rs['Lastname'];
  }

  ?>


  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">ประวัติการกู้เงิน</h6>
    <h3 class="m-0 font-weight-bold text-primary"><?php echo $fullname ; ?></h3>
  </div>
  <div class="card-body">
    <table class="table table-bordered  table-sm" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>ที่</th>
          <th>บัญชีเลขที่ </th>
          <th>วันที่ </th>
          <th>วงเงิน</th>
          <th>หลักทรัพย์</th>
          <th>สถานะบัญชี</th>
          <th>การจัดการ </th>
        </tr>
      </thead>
      <tbody>
        <!-- loop  -->
        <?php



        $sql = "SELECT * from Loanbook , loanbooksheet where Loanbook.IDMember=$memberID and Loanbook.RefNo = loanbooksheet.RefNo";
        $query = mysqli_query($link, $sql);
        $num = 0;

        while ($rs1 = mysqli_fetch_array($query)) {
        ?>
          <tr>
            <td><?php echo  $num = $num + 1; ?></td>

            <td style="text-align: center; ">
                <?php echo  $rs1['lbsID']; ?>
            </td>
            <td><label><?php echo  show_day($rs1['CreateDate']); ?></label></td>
            <td style="text-align:right;"><?php echo  number_format($rs1['Amount']); ?></td>
            <td style="text-align: center;"><?php
                if ($rs1['Guaranty'] == null) {
                  $sqlint1 = 'SELECT * from member where IDMember=' . $rs1['Insurer1'];
                  $qint1 = mysqli_query($link, $sqlint1);
                  while ($rsin1 = mysqli_fetch_array($qint1)) {
                    $fullname1 = $rsin1['Title'] . $rsin1['Firstname'] . " " . $rsin1['Lastname'];
                  }
                  echo "ผู้ค้ำประกันคนที่ 1 " . $fullname1;
                  $sqlint2 = 'SELECT * from member where IDMember=' . $rs1['Insurer2'];
                  $qint2 = mysqli_query($link, $sqlint2);
                  while ($rsin2 = mysqli_fetch_array($qint2)) {
                    $fullname2 = $rsin2['Title'] . $rsin2['Firstname'] . " " . $rsin2['Lastname'];
                  }
                  echo "<br>ผู้ค้ำประกันคนที่ 2 " . $fullname2;
                } else {
                  echo  $rs1['Guaranty'];
                }
                ?></td>
            <td>
              <?php
              if ($rs1['LoanStatus'] == "C") {
                echo "<span class='text-danger' >ปิดบัญชี </span>";
              } else if ($rs1['LoanStatus'] == "N")
                echo "<span class='text-primary' >ค้างชำระ </span>";
              ?>
            </td>
              <td>
              <a href="loan-pay-show1.php?RefNo=<?php echo $rs1['RefNo']; ?>&memid=<?php echo $_GET['memid']; ?>" class="btn btn-primary">
              เปิดดูข้อมูล
              </a>
              </td>
          </tr>

        <?php
        }
        mysqli_close($link);
        ?>
      </tbody>
    </table>
    <a href="loan-show.php" class="btn btn-danger">ย้อนกลับ</a>

  </div>
</div>

<?PHP
include('../tmp_dsh2/footer.php');
?>