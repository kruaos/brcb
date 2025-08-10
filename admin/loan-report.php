<?php
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

function show_day($showday)
{
    $m_name = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    return number_format(substr($showday, 8, 2)) . "  " . $m_name[number_format(substr($showday, 5, 2))] . " " . (substr($showday, 0, 4) + 543);
}

$DateNow = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
?>

<style>
@media print {
    body {
        background: #fff !important;
    }
    .d-print-none, .navbar, .sidebar, form, .btn, .footer {
        display: none !important;
    }
    .container-fluid {
        margin: 0;
        padding: 0;
        width: 100%;
    }
    .report-title {
        font-size: 2.2rem;
        font-weight: bold;
        text-align: center;
        margin-bottom: 0.5em;
    }
    .report-date {
        font-size: 1.5rem;
        text-align: center;
        margin-bottom: 1em;
    }
    table {
        border-collapse: collapse !important;
        width: 100%;
        font-size: 1.1rem;
    }
    th, td {
        border: 1px solid #333 !important;
        padding: 8px !important;
    }
    th {
        background: #f2f2f2 !important;
        font-size: 1.1rem;
    }
    .table-active td {
        font-weight: bold;
        background: #e9ecef !important;
    }
}
.report-title {
    font-size: 2.2rem;
    font-weight: bold;
    text-align: center;
    margin-bottom: 0.5em;
}
.report-date {
    font-size: 1.5rem;
    text-align: center;
    margin-bottom: 1em;
}
.table th, .table td {
    vertical-align: middle !important;
}
</style>

<div class="container-fluid">
    <div class="report-title">รายงานการส่งเงินกู้</div>
    <div class="report-date">ประจำวันที่ <?php echo show_day($DateNow); ?> </div>
    <form method="get" class="d-print-none mb-3">
        <label>เลือกวันที่:</label>
        <input type="date" name="date" value="<?php echo $DateNow; ?>" />
        <button type="submit" class="btn btn-info">แสดงผล</button>
    </form>

    <?php
    $allCountPay = 0;
    $allPaytotal = 0;
    $allInterest = 0;
    $TotalSumAmount = 0;

    $sql = "
        SELECT 
            Username,
            COUNT(Payment) AS CountPay,
            SUM(PayTotal) AS PayTotal,
            SUM(Interest) AS Interest,
            SUM(Payment) AS SumPay
        FROM loanpayment
        WHERE LastUpdate = '$DateNow'
        GROUP BY Username
    ";
    $result = mysqli_query($link, $sql);
    ?>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th style="width:5%">ที่</th>
                <th style="width:20%">เจ้าหน้าที่</th>
                <th style="text-align:center; width:10%">จำนวนรายการ</th>
                <th style="text-align:right; width:15%">เงินต้น</th>
                <th style="text-align:right; width:15%">ดอกเบี้ย</th>
                <th style="text-align:right; width:15%">ยอดเงินรวม</th>
                <th style="width:5%"></th>
                <th class="d-print-none" style="width:10%">จัดการ</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $num = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $Username = $row['Username'];
            $empSql = "SELECT Firstname, Lastname FROM employee WHERE Username='$Username' LIMIT 1";
            $empRes = mysqli_query($link, $empSql);
            $emp = mysqli_fetch_assoc($empRes);
            $FullNameEmp = $emp ? $emp['Firstname'] . " " . $emp['Lastname'] : $Username;

            echo '<tr>
                <td>' . $num . '</td>
                <td>' . $FullNameEmp . '</td>
                <td style="text-align:center">' . number_format($row['CountPay']) . '</td>
                <td style="text-align:right;">' . number_format($row['PayTotal'], 2) . '</td>
                <td style="text-align:right;">' . number_format($row['Interest'], 2) . '</td>
                <td style="text-align:right;">' . number_format($row['SumPay'], 2) . '</td>
                <td></td>
                <td class="d-print-none">
                    <a href="loan-report-user.php?username=' . $Username . '&date=' . $DateNow . '" class="btn btn-primary btn-sm">แสดง</a>
                </td>
            </tr>';

            $num++;
            $allCountPay += $row['CountPay'];
            $allPaytotal += $row['PayTotal'];
            $allInterest += $row['Interest'];
            $TotalSumAmount += $row['SumPay'];
        }
        ?>
        <tr class="table-active">
            <td></td>
            <td><div style="font-size:20px">ผลรวม</div></td>
            <td style="font-size:20px; text-align:center"><?php echo number_format($allCountPay); ?></td>
            <td style="text-align:right ;font-size:20px"><?php echo number_format($allPaytotal, 2); ?></td>
            <td style="text-align:right ;font-size:20px"><?php echo number_format($allInterest, 2); ?></td>
            <td style="text-align:right ;font-size:20px"><?php echo number_format($TotalSumAmount, 2); ?></td>
            <td class="d-print-none"></td>
            <td></td>
        </tr>
        </tbody>
    </table>
    <button class="btn btn-danger col d-print-none" onclick="window.print()">พิมพ์รายงาน</button>
</div>

<?php
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>
