<?php
session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

$employee_use = $_SESSION['employee_USER'];

$sql_show_fullname = "SELECT IDMember, Title, Firstname, Lastname  from  member ";
$qshow_fullname = mysqli_query($link, $sql_show_fullname);
$fullnamemember = array();
while ($re_show_fullname = mysqli_fetch_array($qshow_fullname)) {
    $fullnamemember[$re_show_fullname['IDMember']] = $re_show_fullname['Title'] . $re_show_fullname['Firstname'] . " " . $re_show_fullname['Lastname'];
}

?>


<div class="container-fluid ">
    <div class="row">
        <div class="p-3 mb-2 col bg-primary">
            <h1 class="display-6">ระบบฝากสัจจะ </h1>
            <?php
            echo "รหัสเจ้าหน้าที่ : " . $employee_use;
            ?>
        </div>
    </div>
    <div class="row">

    </div>
    <div class="col col-sm-12 col-md-12 col-lg-12 ">

        <table class="table table-bordered table-sm" id='EdataTable'>
            <!-- <table class="table table-bordered"  id='EdataTable' > -->
            <thead>
                <tr>
                    <th scope="col">ที่</th>
                    <th scope="col">รหัสสมาชิก</th>
                    <th scope="col">รหัสบัญชี</th>
                    <th scope="col">ชื่อ - สกุล</th>
                    <th scope="col">เงินสัจจะ</th>
                    <th scope="col">แก้ไข</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $Datenow = date('Y-m-d');
                $SqlShowTable = "SELECT deposit.* , member.* , regfund.*  from deposit , member, regfund where  deposit.IDRegfund = regfund.IDRegfund and regfund.IDMember = member.IDMember and deposit.username='$employee_use' and deposit.createdate='$Datenow' order by deposit.IDDeposit DESC";
                //$SqlShowTable="SELECT * from deposit where username='$employee_use' and createdate='$Datenow' order by IDDeposit DESC";
                $QueryShowTable = mysqli_query($link, $SqlShowTable);
                $ShowSumAmount = 0;
                $num1 = 1;
                while ($Result1 = mysqli_fetch_array($QueryShowTable)) {

                    $IDRegFund = $Result1['IDRegFund'];
                    $Amount = $Result1['Amount'];
                    $IDDeposit = $Result1['IDDeposit'];
                    $IDMember = $Result1['IDMember'];
                    // $FullName = $Result1['Title'] . $Result1['Firstname'] . " " . $Result1['Lastname'];

                    $ShowSumAmount = $ShowSumAmount + $Amount;
                ?>
                    <tr>
                        <td scope="row"><?php echo $num1; ?></td>
                        <td><?php echo $IDMember; ?></td>
                        <td><?php echo $IDRegFund; ?></td>
                        <td><?php echo $fullnamemember[$IDMember]; ?></td>
                        <td><?php echo $Amount; ?></td>
                        <td>
                            <a href="dep-pay-edit.php?IDDeposit=<?php echo $IDDeposit; ?>" class="btn-warning btn-sm">แก้ไข</a>
                            <a href="dep-pay-tool-delshowall.php?IDDeposit=<?php echo $IDDeposit; ?>" class="btn-danger btn-sm" onclick="myFunction()">ลบ</a>
                        </td>
                    </tr>
                <?php
                    $num1++;
                }
                ?>
                <tr>
                    <td scope="row"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo $ShowSumAmount; ?></td>
                    <td></td>
                </tr>

            </tbody>
        </table>
        <?php
        // echo $SqlFullname;
        // print_r($QueryShowTable);
        $SqlCountTable = "Select count(amount) from deposit where username='$employee_use' and createdate='$Datenow' and amount='30'";
        $QueryCountTable = mysqli_query($link, $SqlCountTable);
        // echo $SqlCountTable;
        while ($RQCT = mysqli_fetch_array($QueryCountTable)) {
            $showCountTable = $RQCT['count(amount)'];
            // print_r($RQCT);
        }
        $showRowCountTable = $showCountTable % 30;
        // exit();
        ?>
       
    </div>
    <a href="dep-pay-tool.php" class="btn btn-danger col-12">ย้อนกลับ</a>
</div>

</div>

<script>
    function myFunction() {
        confirm("ยืนยันการลบ");
    }
</script>
<?PHP
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>