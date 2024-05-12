<?php
include('../config/config.php');
function show_day($showday)
{
    $m_name = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    echo  number_format(substr($showday, 8, 2)) . "  " . $m_name[number_format(substr($showday, 5, 2))] . " " . (substr($showday, 0, 4) + 543);
}
$fullname = array();
$sqlname = "SELECT * from member order by IDMember ";
$qFullname = mysqli_query($link, $sqlname);
while ($rsfn = mysqli_fetch_array($qFullname)) {
    $fullname[$rsfn['IDMember']] = $rsfn['Title'] . $rsfn['Firstname'] .' '. $rsfn['Lastname'];

}
?>
<div class="card-body">

    <h6 class="m-0 font-weight-bold text-primary">ข้อมูลสมาชิกเงินกู้ </h6>
    <!-- <table class="table table-sm " width="100%" cellspacing="0"  id='EdataTable'> -->
    <table class="table table-sm " width="100%" cellspacing="0"  >
        <thead>
            <tr>
                <th>รหัส</th>
                <th>ชื่อ - สกุล </th>
                <th>วันที่เป็นสมาชิก</th>
                <th>วงเงิน</th>
                <th>รูปแบบ</th>
                <th>ประวัติการกู้</th>
                <th>ประวัติการค้ำ</th>
            </tr>
        </thead>
        <tbody>
            <!-- loop  -->
            <?php
            $sql = "SELECT * from Loanbook where LoanStatus='N' order by CreateDate desc limit 20 ";
            $query = mysqli_query($link, $sql);
            // while ($rs1 = mysqli_fetch_array($query)) {
            // // echo "<pre>";
            // // print_r($rs1);
            // // echo "</pre>";
            // }
            // [RefNo] => 0001
            // [Username] => Admin
            // [Insurer1] => 256
            // [Insurer2] => 332
            // [InterestRate] => 12.00
            // [Instalment] => 30
            // [Amount] => 30000.00
            // [LoanStatus] => C
            // [CreateDate] => 2008-12-14
            // [LastUpdate] => 2011-05-08
            // [IDMember] => 493
            // [IDReason] => 6
            // [DateDoc] => 2008-12-14
            // [PayStatus] => 3
            // [LimitDate] => 2011-06-14
            // [Guaranty] => 
            // echo $sql;exit;
            $num = 0;
            while ($rs1 = mysqli_fetch_array($query)) {

            ?>
                <tr>
                    <td><?php echo sprintf('%04d', $rs1['IDMember']); ?></td>
                    <td>
                        <?php
                       echo $fullname[$rs1['IDMember']];
                        ?>
                    </td>
                    <td><?php echo  show_day($rs1['CreateDate']); ?></td>
                    <td style="text-align:right;"><?php echo  number_format($rs1['Amount']); ?> บาท</td>
                   <td></td>
                    <td>
                        <?php
                        $sqlloan = "select * from Loanbook where IDMember=" . $rs1['IDMember'];
                        $queryloan = mysqli_query($link, $sqlloan);
                        if ($queryloan->num_rows <> 0) {
                        ?>
                            <a href="loan-cus-show.php?memid=<?php echo $rs1['IDMember']; ?>" class="btn btn-danger btn-sm">ประวัติการกู้ <?php echo $queryloan->num_rows; ?> ครั้ง</a>
                        <?php } else { ?>
                            ไม่มีประวัติการกู้
                        <?php } ?>
                    </td>
                    <td>
                        <?php
                        $sqlin1 = "select * from Loanbook where Insurer1=" . $rs1['IDMember'] . " or Insurer2=" . $rs1['IDMember'];
                        $queryin1 = mysqli_query($link, $sqlin1);
                        if ($queryin1->num_rows <> 0) {
                        ?>
                            <a href="loan-in-show.php?memid=<?php echo $rs1['IDMember']; ?>" class="btn btn-success btn-sm">ตรวจผู้ค้ำ <?php echo $queryin1->num_rows; ?> ราย </a>
                        <?php } else { ?>
                            ไม่มีประวัติการค้ำประกัน
                        <?php } ?>
                    </td>
                </tr>

            <?php
            }
            mysqli_close($link);
            ?>
        </tbody>
    </table>
</div>