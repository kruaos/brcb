<?php
ob_start();

session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');


unset($_SESSION['IDMember']);

// $employee_use = $_SESSION['employee_USER'];
$IDMember = $_POST['IDMember_Dep'];
// $DepPage = $_SESSION['DepPage'];


$ShowMember = "SELECT m.Title, m.Firstname, m.Lastname, m.MemberStatus from Member as m where  m.IDMember=$IDMember";
$SMQuery = mysqli_query($link, $ShowMember);
if ($IDMember == null) {
    echo "กรุณากรอกรหัสสมาชิก  <br>  ";
    echo "<a href='wit-pay-tool.php'>ย้อนกลับ</a>";
    exit();
} else if (mysqli_num_rows($SMQuery) == 0) {
    echo "รหัสสมาชิกไม่ถูกต้อง <br>";
    echo "ไม่พบรหัส " . $IDMember . " ในฐานข้อมูล <br>";
    echo "<a href='wit-pay-tool.php'>ย้อนกลับ</a>";
    exit();
}
while ($SM = mysqli_fetch_array($SMQuery)) {
    $FullNameMember = $SM['Title'] . $SM['Firstname'] . " " . $SM['Lastname'];
}
$n = 1;
$ShowRegfund = "select * from regfund where  IDMember=$IDMember order by IDFund ASC";
$SRfQuery = mysqli_query($link, $ShowRegfund);


while ($SRf = mysqli_fetch_array($SRfQuery)) {
    $SRFArray[$n]['IDRegFund'] = $SRf['IDRegFund'];
    $SRFArray[$n]['IDFund'] = $SRf['IDFund'];
    $SRFArray[$n]['LastUpdate'] = $SRf['LastUpdate'];
    $SRFArray[$n]['Closedate'] = $SRf['Closedate'];
    $SRFArray[$n]['Balance'] = $SRf['Balance'];
    $n++;
}


// print_r($SRFArray);

$ShowAmount1 = $SRFArray['1']['Balance'];
// select 
// $ShowAmount2 = $SRFArray['2']['Balance'];

$Amount1 = 30;
$Amount2 = 5;

$TodayDate = date('Y-m-d');
$IDRegFund1 = $SRFArray['1']['IDRegFund'];
$SqlCheckInput = "SELECT d.*, e.firstname, e.lastname  FROM deposit as d , employee as e where d.IDRegFund=$IDRegFund1 and d.createdate='$TodayDate' and d.username=e.username";
$CheckInputQuery = mysqli_query($link, $SqlCheckInput);
// echo $SqlCheckInput;
// print_r($CheckInputQuery);
// exit(); 
$CheckInputNumrows = mysqli_num_rows($CheckInputQuery);

?>
<script type="text/javascript">
    function clicked() {
        alert('clicked');
    }
</script>
<div class="container-fluid ">
    <div class="row">
        <div class="p-3 mb-2 col bg-danger">
            <h1 class="display-6">ระบบถอนเงินสัจจะ </h1>
            <?php
            // echo "รหัสเจ้าหน้าที่ : " . $employee_use;
            // echo " [ แผ่นที่ " . $DepPage . " ] ";
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-12 col-md-6 col-lg-6 ">
            <form action="#">
                <div class="form-group">
                    <label>รหัสสมาชิก</label> <span class="text-danger"><?php echo $IDMember; ?></span>
                    <label>ชือ-สกุล</label> <span class="text-danger"><?php echo $FullNameMember; ?></span>
                    <!-- <input type="text" class="form-control " value="<?php echo $IDMember; ?>" disabled> -->
                </div>
            </form>
            <?php
            // if ($CheckInputNumrows <> 0) {
                // แจ้งว่ามีการฝากแล้ว 

                // while ($CIQ = mysqli_fetch_array($CheckInputQuery)) {
                //     $showUsername = $CIQ['firstname'] . "  " . $CIQ['lastname'];
                //     // print_r($RQCT);
                // }
            ?>
                <!-- <div class="alert alert-danger" role="alert">
                    มีการฝากแล้วโดย
                    <?php
                    echo $showUsername;
                    ?>
                </div> -->

                <div class="form-group">
                    <!-- <label>ข้อมูลสมาชิก</label>
                    <input class="form-control " type="text" value="<?php echo $FullNameMember; ?>" disabled>
                    <input class="form-control " type="text" value="เงินฝากสัจจะ : <?php echo number_format($ShowAmount1, 2); ?>" disabled>
                    <input class="form-control " type="text" value="เงินฝากเพื่อนช่วยเพื่อน : <?php echo number_format($ShowAmount2, 2); ?>" disabled> -->

                <?php
            // } else {
                ?>
                    <form method="POST" action="wit-pay-add.php">
                        <div class="form-group">
                            <label>ยอดเงินสัจจะคงเหลือ</label> <span class="text-danger"><?php echo number_format($ShowAmount1, 2); ?></span>
                            <!-- <label>ข้อมูลสมาชิก</label> <span class="text-danger"><?php echo $FullNameMember; ?></span> -->
                            <!-- <input class="form-control " type="text" value="<?php echo $FullNameMember; ?>" disabled> -->
                            <!-- <input class="form-control " type="text" value="เงินฝากสัจจะ : <?php echo number_format($ShowAmount1, 2); ?>" disabled> -->
                            <!-- <input class="form-control " type="text" value="เงินฝากเพื่อนช่วยเพื่อน : <?php echo number_format($ShowAmount2, 2); ?>" disabled> -->
                <br>
                            <label>ถอนเงินสัจจะ</label>
                            <input class="form-control " type="number" 
                                name="Amount1" value="0" 
                                <?php if($ShowAmount1>600){
                                    $maxValue = $ShowAmount1-600;
                                }else{
                                    $maxValue = 0;
                                }
                                ?>
                                max="<?php //echo $maxValue; ?>" 
                                style="font-size:30px; text-align:right"
                                <?php if($ShowAmount1<600){echo "disabled";} ?>
                                required>
                                <?php if($ShowAmount1<600){
                                    echo "<div class='alert alert-danger'> ยอดเงินสัจจะคงเหลือไม่เพียงพอ </div>";
                                }else{
                                    echo "<div class='alert alert-primary'> ถอนได้ไม่เกิน ".number_format($maxValue)."</div>";
                                    } ?>
                                
                                <div class="from-group">
                                    <label>ผู้ถอนเงิน</label>
                                    <input class="form-control " type="text" name="witname" value="" style="font-size:30px; text-align:right" required>
                                </div>
                                    
                            <!-- <input type="hidden" name="Fullname" value="<?php echo $FullNameMember; ?>"> -->
                            <input type="hidden" name="IDMember" value="<?php echo $IDMember; ?>">
                            <!-- <input type="hidden" name="DepPage" value="<?php echo $DepPage; ?>"> -->
                            <label>สถานะ</label>
                            <select class="form-control " name="Comment">
                                <option value="เป็นสมาชิก">เป็นสมาชิก</option>
                                <option value="ลาออก">ลาออกจากสมาชิก</option>
                            </select>
                            <br>
                            <input type="submit" class="form-control btn-warning " value="ทำรายการถอน">
                        <?php
                    // }
                        ?>
                        </div>
                    </form>
                    <a href="wit-pay-tool.php" class="form-control btn btn-danger">ยกเลิก</a>
                </div>
                <div class="col col-sm-12 col-md-6 col-lg-6 ">

                </div>
                <?PHP
                include('../tmp_dsh2/table.php');
                include('../tmp_dsh2/footer.php');
                ?>