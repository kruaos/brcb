<?php
session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

// $employee_use = $_SESSION['employee_USER'];
// $fullnameemp = $_SESSION['fullnameemp'];

$sql_show_fullname = "SELECT IDMember, Title, Firstname, Lastname  from  member ";
$qshow_fullname = mysqli_query($link, $sql_show_fullname);
$fullnamemember = array();
while ($re_show_fullname = mysqli_fetch_array($qshow_fullname)) {
    $fullnamemember[$re_show_fullname['IDMember']] = $re_show_fullname['Title'] . $re_show_fullname['Firstname'] . " " . $re_show_fullname['Lastname'];
}


?>

<div class="container-fluid ">
    <div class="row">
        <div class="p-3 mb-2 col bg-danger">
            <h1 class="display-6">ระบบถอนเงินสัจจะ </h1>
            <h4 style="color: white;">
                <?php
                // echo "ชื่อเจ้าหน้าที่ : " . $fullnameemp;
                // echo " [" . $employee_use . "]";
                ?>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-12 col-md-4 col-lg-4 ">
            <!-- <form method="POST" action="dep-pay-tool-chk.php" > -->
            <form method="POST" action="wit-pay-insert.php">
                <div class="form-group">
                    <label>รหัสสมาชิก</label>
                    <input type="number" class="form-control " placeholder="รหัสสมาชิก" name="IDMember_Dep" onfocus="this.value = this.value;" required autofocus>
                    <!-- <input type="text" class="form-control " placeholder="รหัสสมาชิก" name="IDMember_Dep" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" onfocus="this.value = this.value;" required autofocus> -->
                    <!-- <input type="hidden" class="form-control "  value='a' name="switch_menu1"> -->
                    <!-- <input type="submit" class="form-control btn-warning"  name="switch_menu1"> -->
                </div>
            </form>
            <form method="POST" action="wit-pay-tool.php">

            </form>
        </div>
        <div class="col col-sm-12 col-md-8 col-lg-8 ">
            <h3>แสดงรายการล่าสุด </h3>

            <!-- <table class="table table-bordered"  id='EdataTable' > -->
            <!-- <table class="table table-bordered table-sm"  id='EdataTable' > -->
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th scope="col">ที่</th>
                        <th scope="col">รหัสสมาชิก</th>
                        <th scope="col">ชื่อบัญชี</th>
                        <th scope="col">ผู้ถอนเงิน</th>
                        <th scope="col">ยอดถอนเงิน</th>
                        <th scope="col">หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $Datenow = date('Y-m-d');
                    $SqlShowTable = "SELECT * from deposit where Amount<0 and createdate='$Datenow' order by IDDeposit DESC ";
                    $QueryShowTable = mysqli_query($link, $SqlShowTable);
                    $ShowSumAmount = 0;
                    $num1 = 1;
                    while ($Result1 = mysqli_fetch_array($QueryShowTable)) {

                        $IDRegFund = $Result1['IDRegFund'];
                        $Amount = $Result1['Amount'];
                        $Username = $Result1['Username'];
                        $IDDeposit = $Result1['IDDeposit'];

                        $SqlIDMember = "SELECT * FROM regfund WHERE IDRegfund=$IDRegFund";
                        $QueryIDMember = mysqli_query($link, $SqlIDMember);
                        while ($RQid = mysqli_fetch_array($QueryIDMember)) {
                            $IDMember = $RQid['IDMember'];
                            //     $SqlFullName = "SELECT * FROM member WHERE IDMember=$IDMember";
                            //     $QueryFullName = mysqli_query($link, $SqlFullName);
                            //     while ($RQFullName = mysqli_fetch_array($QueryFullName)) {
                            //         $FullName = $RQFullName['Title'] . $RQFullName['Firstname'] . " " . $RQFullName['Lastname'];
                            // }
                        }

                        $ShowSumAmount = $ShowSumAmount + $Amount;
                    ?>
                        <tr>
                            <td scope="row"><?php echo $num1; ?></td>
                            <td><?php echo $IDMember; ?></td>
                            <td><?php echo  $fullnamemember[$IDMember]; ?></td>
                            <td><?php echo $Username; ?></td>
                            <td class="text-right"><?php 
                            
                            echo number_format(-$Amount,'0'); 
                            ?>
                            </td>
                            <td></td>
                            <!-- <td>
                                <a href="dep-pay-edit.php?IDDeposit=<?php echo $IDDeposit; ?>" class="btn-warning btn-sm">แก้ไข</a>
                                <a href="dep-pay-tool-del.php?IDDeposit=<?php echo $IDDeposit; ?>" class="btn-danger btn-sm" onclick="return confirm('ต้องการลบรายการ')">ลบ</a>
                            </td> -->
                        </tr>
                    <?php
                        $num1++;
                    }
                    ?>
                    <!--
            <tr>
                <td scope="row"></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo $ShowSumAmount; ?></td>
                <td></td>
            </tr>
-->
                </tbody>
            </table>
            <?php
            // echo $SqlFullname;
            // print_r($QueryShowTable);

            // $SqlCountTable = "SELECT count(amount) from deposit where username='$employee_use' and createdate='$Datenow' and amount='30'";
            // $QueryCountTable = mysqli_query($link, $SqlCountTable);
            // // echo $SqlCountTable;
            // while ($RQCT = mysqli_fetch_array($QueryCountTable)) {
            //     $showCountTable = $RQCT['count(amount)'];
            //     // print_r($RQCT);
            // }
            // $showRowCountTable = $showCountTable % 30;
            // $showPageCountTable = $showCountTable / 90;

            // exit();
            ?>
            <div>
                <h4>

                    <!-- <span style="color:red">
                        ลำดับที่ = <?php echo $showRowCountTable; ?>
                    </span> -->

                    <!-- จำนวนแผ่นที่ทำงานอยู่ = แผ่นที่ <?php echo number_format($showPageCountTable, 0) + 1; ?> <br> -->
                    <!-- จำนวนแผ่นทั้งหมด = <?php echo number_format($showPageCountTable, 0); ?> แผ่น <br> -->

                </h4>
                <!-- จำนวนผู้ฝากรวมทั้งสิ้น <?php echo $showCountTable; ?> ราย -->
            </div>
            <!-- <a href="dep-pay-tool-showall.php" class="btn btn-success col-12">show detail</a> -->
            <!-- <a href="dep-pay-tool-showall.php" class="btn btn-danger col">แสดงทั้งหมด</a> -->
        </div>
    </div>

</div>
<?PHP
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>