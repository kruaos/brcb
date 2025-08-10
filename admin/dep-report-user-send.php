<?php
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

// รับค่าตัวแปร Username และ DepDate ผ่าน GET
$Username = isset($_GET['Username']) ? $_GET['Username'] : '';
$DepDate = isset($_GET['DepDate']) ? $_GET['DepDate'] : date('Y-m-d');

// ฟังก์ชันแปลงวันที่เป็นรูปแบบภาษาไทย
function show_day($showday)
{
    $m_name = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    return number_format(substr($showday, 8, 2)) . " " . $m_name[number_format(substr($showday, 5, 2))] . " " . (substr($showday, 0, 4) + 543);
}

// ดึงข้อมูลชื่อผู้ใช้งาน
$sqlSelectName = "SELECT * FROM employee WHERE Username = '$Username'";
$qSelectName = mysqli_query($link, $sqlSelectName);
$rs4 = mysqli_fetch_array($qSelectName);
$FullnameUser = $rs4['Firstname'] . " " . $rs4['Lastname'];
?>
<div class="container-fluid">
    <h3 class="m-0 font-weight-bold text-primary">รายละเอียดการรับเงินฝากสัจจะ/เพื่อนช่วยเพื่อน</h3>
    <h3 class="m-0 font-weight-bold">ของ <?php echo $FullnameUser; ?></h3>
    <h3 class="m-0 font-weight-bold">ประจำวันที่ <?php echo show_day($DepDate); ?></h3>

    <!-- ฟอร์มเลือกวันที่ -->
    <form method="GET" class="mt-3">
        <input type="hidden" name="Username" value="<?php echo htmlspecialchars($Username); ?>">
        <label for="DepDate">เลือกวันที่:</label>
        <input type="date" id="DepDate" name="DepDate" value="<?php echo htmlspecialchars($DepDate); ?>">
        <button type="submit" class="btn btn-primary">แสดงข้อมูล</button>
    </form>

    <div class="row pt-5">
        <table class="table table-sm" cellspacing="0" style="font-size: 20px;">
            <tbody>
                <?php
                // คำสั่ง SQL เพื่อดึงข้อมูลและคำนวณยอดรวม
                $query = "
                    SELECT 
                        SUM(CASE WHEN Amount = 30 THEN Amount ELSE 0 END) AS amountDepSum,
                        COUNT(CASE WHEN Amount = 30 THEN 1 ELSE NULL END) AS amountDepCount,
                        SUM(CASE WHEN Amount <> 30 THEN Amount ELSE 0 END) AS amountInsSum,
                        COUNT(CASE WHEN Amount <> 30 THEN 1 ELSE NULL END) AS amountInsCount,
                        SUM(Amount) AS amountSUM
                    FROM deposit
                    WHERE CreateDate = '$DepDate' AND Username = '$Username'";
                $result = mysqli_query($link, $query);
                $data = mysqli_fetch_assoc($result);
                ?>
                <tr class='table-active'>
                    <td colspan="2">จำนวน เงินฝากสัจจะ</td>
                    <td style='text-align:right'><?php echo $data['amountDepCount']; ?></td>
                    <td>ราย</td>
                    <td>เป็นเงิน</td>
                    <td style='text-align:right'><?php echo number_format($data['amountDepSum'], 2); ?></td>
                    <td>บาท</td>
                </tr>
                <tr class='table-active'>
                    <td colspan="2">จำนวน เงินฝากเพื่อนช่วยเพื่อน</td>
                    <td style='text-align:right'><?php echo $data['amountInsCount']; ?></td>
                    <td>ราย</td>
                    <td>เป็นเงิน</td>
                    <td style='text-align:right'><?php echo number_format($data['amountInsSum'], 2); ?></td>
                    <td>บาท</td>
                </tr>
                <tr class='table-active'>
                    <td colspan="4"></td>
                    <td>ยอดรวม</td>
                    <td style='text-align:right'><?php echo number_format($data['amountSUM'], 2); ?></td>
                    <td>บาท</td>
                </tr>
            </tbody>
        </table>
        <button class="col-3 btn btn-danger col d-print-none" onclick="window.print()">พิมพ์รายงาน</button>
        <a class="col-3 btn btn-secondary col d-print-none" href="dep-report.php">ย้อนกลับ</a>
    </div>
</div>

<?php
mysqli_close($link);
include('../tmp_dsh2/footer.php');
?>
