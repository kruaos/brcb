<?php
session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

$employee_use = $_SESSION['LoanEmplopeeUser'];
$fullnameemp = $_SESSION['fullnameemp'];

$date_now = date('Y-m-d');
// $date_now='2019-05-05';
$sql_show_loanpayment = "SELECT * from loanpayment where CreateDate='$date_now' 
	and Username='$employee_use' ORDER BY IDLoanPay ASC";
$q_show_loanpayment = mysqli_query($link, $sql_show_loanpayment);
// print_r($sql_show_loanpayment);

$sql_show_fullname = "SELECT IDMember, Title, Firstname, Lastname  from  member ";
$qshow_fullname = mysqli_query($link, $sql_show_fullname);
$fullnamemember=array();
while ($re_show_fullname = mysqli_fetch_array($qshow_fullname)) {
    $fullnamemember[$re_show_fullname['IDMember']] = $re_show_fullname['Title'].$re_show_fullname['Firstname']." ".$re_show_fullname['Lastname'];
}



?>
<div class="container-fluid">
    <div class="row">
        <div class="p-3 mb-2 col bg-warning">
            <h1 class="display-5">ชำระเงินกู้</h1>
            <!-- รหัสเจ้าหน้าที่ : <?php echo $employee_use; ?> -->
            <h4>
                <?php
                echo "ชื่อเจ้าหน้าที่ : " . $fullnameemp;
                echo " [" . $employee_use . "]";
                ?>
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-bordered table-sm" id='EdataTable'>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">เลขสมาชิก</th>
                        <!-- <th scope="col">เลขบัญชี</th> -->
                        <th scope="col">ชื่อสมาชิก</th>
                        <th scope="col">เงินต้น</th>
                        <th scope="col">ดอกเบี้ย</th>
                        <th scope="col">รวมจ่าย</th>
                        <th scope="col">user</th>
                        <th scope="col">edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $num = 1;
                    while ($rs_show_lpm = mysqli_fetch_array($q_show_loanpayment)) {
                        $RefNo = $rs_show_lpm['RefNo'];
                        $sql_find_memid = "SELECT * FROM loanbook WHERE RefNo=$RefNo  ";
                        $q_find_memid = mysqli_query($link, $sql_find_memid);
                        while ($rs_fn_memid = mysqli_fetch_array($q_find_memid)) {
                            $IDMember = $rs_fn_memid['IDMember'];
                        }

                    ?>
                        <tr>
                            <th scope="row"><?php echo $num;
                                            $num = $num + 1 ?></th>
                            <td><?php echo $IDMember; ?></td>
                            <td>
                                <?php echo $fullnamemember[$IDMember] ;?>
                            </td>
                            <!-- <td><?php echo $rs_show_lpm['RefNo']; ?></td> -->
                            <td><?php echo number_format($rs_show_lpm['PayTotal']); ?></td>
                            <td><?php echo number_format($rs_show_lpm['Interest']); ?></td>
                            <td><?php echo number_format($rs_show_lpm['Payment']); ?></td>
                            <td><?php echo $rs_show_lpm['Username']; ?></td>
                            <td style="">
                                <a href="loan-pay-tool-edit.php?IDLoanPay=<?php echo $rs_show_lpm['IDLoanPay']; ?>&IDMember=<?php echo $IDMember; ?>&RefNo=<?php echo $rs_show_lpm['RefNo']; ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                                <a href="loan-pay-tool-del.php?IDLoanPay=<?php echo $rs_show_lpm['IDLoanPay']; ?>&IDMember=<?php echo $IDMember; ?>&RefNo=<?php echo $rs_show_lpm['RefNo']; ?>" class="btn btn-danger btn-sm">ลบ</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <a class="btn btn-warning" href="loan-pay-tool.php">ย้อนกลับ</a>
        </div>
    </div>
</div>
<?PHP
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>