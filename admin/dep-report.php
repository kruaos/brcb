<?php
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

function show_day($showday)
{
    $m_name = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    return number_format(substr($showday, 8, 2)) . " " . $m_name[number_format(substr($showday, 5, 2))] . " " . (substr($showday, 0, 4) + 543);
}

$DateNow = isset($_POST['selected_date']) ? $_POST['selected_date'] : date('Y-m-d');
$TotalSumAmountDep = 0;
$TotalSumAmountIns = 0;
$TotalCountAmount = 0;
?>

<style>
    @media print {
        .d-print-none { display: none !important; }
        body { background: #fff; }
        .container-fluid { margin: 0; padding: 0; }
        .report-title { font-size: 2.5rem; font-weight: bold; text-align: center; margin-bottom: 0.5em; }
        .report-date { font-size: 1.5rem; text-align: center; margin-bottom: 1em; }
        table { font-size: 1rem; }
        th, td { border: 1px solid #333 !important; }
        tfoot td { font-weight: bold; background: #f8f9fa !important; }
    }
    .report-title { font-size: 2.5rem; font-weight: bold; text-align: center; margin-bottom: 0.5em; color: #2c3e50; }
    .report-date { font-size: 1.5rem; text-align: center; margin-bottom: 1em; color: #34495e; }
    .table-report th { background: #2980b9; color: #fff; text-align: center; }
    .table-report tfoot td { background: #ecf0f1; font-weight: bold; }
    .table-report tbody tr:nth-child(even) { background: #f2f6fc; }
    .btn-print { font-size: 1.2rem; padding: 0.5em 2em; }
    .form-inline { display: flex; align-items: center; gap: 1em; margin-bottom: 1em; }
    label { font-weight: bold; }
</style>

<div class="container-fluid">
    <div class="report-title">รายงานการส่งเงินสัจจะ</div>
    <div class="report-date">ประจำวันที่ <?php echo show_day($DateNow); ?></div>

    <!-- ฟอร์มเลือกวันที่ -->
    <form method="POST" class="form-inline d-print-none">
        <label for="selected_date">เลือกวันที่:</label>
        <input type="date" id="selected_date" name="selected_date" value="<?php echo $DateNow; ?>" class="form-control">
        <button type="submit" class="btn btn-primary">แสดงข้อมูล</button>
    </form>

    <?php
    $query = "
        SELECT 
            d.Username,
            e.Firstname,
            e.Lastname,
            COUNT(d.Amount) AS CountAmount,
            SUM(CASE WHEN d.Amount = 30 THEN d.Amount ELSE 0 END) AS SumAmountDep,
            SUM(CASE WHEN d.Amount != 30 THEN d.Amount ELSE 0 END) AS SumAmountIns,
            SUM(d.Amount) AS TotalAmount
        FROM deposit d
        LEFT JOIN employee e ON d.Username = e.Username
        WHERE d.CreateDate = '$DateNow'
        GROUP BY d.Username, e.Firstname, e.Lastname
    ";
    $result = mysqli_query($link, $query);
    ?>

    <table class="table table-hover table-report">
        <thead>
            <tr>
                <th>ที่</th>
                <th>เจ้าหน้าที่</th>
                <th>จำนวนราย</th>
                <th>ยอดฝากสัจจะ</th>
                <th>ยอด พชพ</th>
                <th>ยอดเงินรวม</th>
                <th class="d-print-none">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $num = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $fullname = $row['Firstname'] . " " . $row['Lastname'];
                $TotalCountAmount += $row['CountAmount'];
                $TotalSumAmountDep += $row['SumAmountDep'];
                $TotalSumAmountIns += $row['SumAmountIns'];
            ?>
                <tr>
                    <td style="text-align: center;"><?php echo $num++; ?></td>
                    <td><?php echo htmlspecialchars($fullname); ?></td>
                    <td style="text-align: center;"><?php echo number_format($row['CountAmount']); ?></td>
                    <td style="text-align: right;"><?php echo number_format($row['SumAmountDep'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($row['SumAmountIns'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($row['TotalAmount'], 2); ?></td>
                    <td style="text-align: center;" class="d-print-none">
                        <a class="btn btn-warning btn-sm" href="dep-report-user.php?Username=<?php echo urlencode($row['Username']); ?>&DepDate=<?php echo $DateNow; ?>">รายการทั้งหมด</a>
                        <a class="btn btn-success btn-sm" href="dep-report-user-send.php?Username=<?php echo urlencode($row['Username']); ?>&DepDate=<?php echo $DateNow; ?>">ส่งรายงาน</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:right;">จำนวนสมาชิกฝากจำวัน</td>
                <td colspan="2" style="text-align:right;"><?php echo number_format($TotalCountAmount, 0); ?> ราย</td>
                <td class="d-print-none"></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right;">รวมเงินฝากสัจจะ</td>
                <td colspan="2" style="text-align:right;"><?php echo number_format($TotalSumAmountDep, 2); ?> บาท</td>
                <td class="d-print-none"></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right;">รวมเงินฝากเพื่อนช่วยเพื่อน</td>
                <td colspan="2" style="text-align:right;"><?php echo number_format($TotalSumAmountIns, 2); ?> บาท</td>
                <td class="d-print-none"></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right;">ผลรวม</td>
                <td colspan="2" style="text-align:right;"><?php echo number_format($TotalSumAmountDep + $TotalSumAmountIns, 2); ?> บาท</td>
                <td class="d-print-none"></td>
            </tr>
        </tfoot>
    </table>

    <div class="text-center mt-4 d-print-none">
        <button class="btn btn-danger btn-print" onclick="window.print()">
            <i class="fa fa-print"></i> พิมพ์รายงาน
        </button>
    </div>
</div>

<?php
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>
