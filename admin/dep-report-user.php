<?php
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

$Username = isset($_GET['Username']) ? mysqli_real_escape_string($link, $_GET['Username']) : '';
$DepDate = isset($_GET['DepDate']) ? mysqli_real_escape_string($link, $_GET['DepDate']) : date('Y-m-d');

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $DepDate)) {
    $DepDate = date('Y-m-d');
}

function show_day($showday)
{
    $m_name = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    return number_format(substr($showday, 8, 2)) . " " . $m_name[number_format(substr($showday, 5, 2))] . " " . (substr($showday, 0, 4) + 543);
}

// Query เรียงให้ amount = 30 มาก่อน
$sql = "
    SELECT m.IDMember, m.Firstname, m.Lastname, d.Amount, d.CreateDate, d.DepositStatus
    FROM deposit AS d
    JOIN regfund AS r ON d.IDRegFund = r.IDRegFund
    JOIN member AS m ON r.IDMember = m.IDMember
    WHERE d.CreateDate = '$DepDate' AND d.Username = '$Username'
    ORDER BY m.IDMember,
             CASE WHEN d.Amount = 30 THEN 0 ELSE 1 END, 
             d.IDRegFund ASC
";
$querydep = mysqli_query($link, $sql);

$data = array();
$total_sajja = 0; // รวมเงินสัจจะ
$total_friend = 0; // รวมเงินเพื่อนช่วยเพื่อน



while ($row = mysqli_fetch_assoc($querydep)) {
    $IDMember = $row['IDMember'];
    if (!isset($data[$IDMember])) {
        $data[$IDMember] = array(
            'IDMember' => $IDMember,
            'Name' => $row['Firstname'] . " " . $row['Lastname'],
            'Funds' => array(),
            'TotalAmount' => 0
        );
    }

    $data[$IDMember]['Funds'][] = array(
        'Amount' => $row['Amount'],
        'Date' => show_day($row['CreateDate']),
        'Status' => $row['DepositStatus']
    );
    $data[$IDMember]['TotalAmount'] += $row['Amount'];

    // รวมยอดตามประเภท
    if ($row['Amount'] == 30) {
        $total_sajja += $row['Amount'];
    } else {
        $total_friend += $row['Amount'];
    }
}
$grand_total = $total_sajja + $total_friend;

?>
<div class="container-fluid">

    <!-- ฟอร์มเลือกวันที่ -->
    <form method="GET" class="mt-3">
        <input type="hidden" name="Username" value="<?php echo htmlspecialchars($Username); ?>">
        <label for="DepDate">เลือกวันที่:</label>
        <input type="date" id="DepDate" name="DepDate" value="<?php echo htmlspecialchars($DepDate); ?>">
        <button type="submit" class="btn btn-primary">แสดงข้อมูล</button>
    </form>

   <h2 style="font-weight: bold; color: #000;">สรุปยอดรับเงิน</h2>
<div style="font-size: 18px;">
    <span style="margin-right: 20px;">เจ้าหน้าที่ผู้รับเงิน: <strong><?php echo htmlspecialchars($Username); ?></strong></span>
    <span style="margin-right: 20px;">วันที่: <strong><?php echo show_day($DepDate); ?></strong></span>
    <span style="margin-right: 20px;">เงินสัจจะ (30 บาท): <strong><?php echo number_format($total_sajja, 2); ?></strong> บาท</span>
    <span style="margin-right: 20px;">เงินเพื่อนช่วยเพื่อน: <strong><?php echo number_format($total_friend, 2); ?></strong> บาท</span>
    <span>รวมเป็นเงินทั้งสิ้น: <strong><?php echo number_format($grand_total, 2); ?></strong> บาท</span>
</div>

    <div class="row mt-3">
        <button class="btn btn-success col d-print-none" onclick="exportTableToExcel('reportTable', 'รายงานรับเงิน_<?php echo $DepDate; ?>')">Export เป็น Excel</button>
        <button class="btn btn-danger col d-print-none" onclick="window.print()">พิมพ์รายงาน</button>
<button class="btn btn-primary col d-print-none" 
    onclick="window.location.href='dep-report.php?Username=<?php echo urlencode($Username); ?>&DepDate=<?php echo urlencode($DepDate); ?>'">
ย้อนกลับ
</button>

       <table id="reportTable" class="table table-sm" cellspacing="0" style="font-size: 20px;">
            <thead>
                <tr>
                    <th>รหัสสมาชิก</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>ยอดสัจจะ</th>
                    <th>ยอดเพื่อนช่วยเพื่อน</th>
                    <th>ยอดรวม</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $member): ?>
                    <tr>
                        <td style='text-align:center'><?php echo $member['IDMember']; ?></td>
                        <td><?php echo $member['Name']; ?></td>
                        <?php
                        $sajja = '';
                        $friend = '';
                        foreach ($member['Funds'] as $f) {
                            if ($f['Amount'] == 30 && $sajja === '') {
                                $sajja = number_format($f['Amount'], 2);
                            } elseif ($friend === '') {
                                $friend = number_format($f['Amount'], 2);
                            }
                        }
                        echo "<td style='text-align:right'>" . $sajja . "</td>";
                        echo "<td style='text-align:right'>" . $friend . "</td>";
                        ?>
                        <td style='text-align:right; font-weight:bold;'><?php echo number_format($member['TotalAmount'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

     <tfoot>
                <tr style="font-weight: bold; background-color: #f0f0f0;">
                    <td colspan="2" style="text-align:center;">รวมทั้งหมด</td>
                    <td style="text-align:right;"><?php echo number_format($total_sajja, 2); ?></td>
                    <td style="text-align:right;"><?php echo number_format($total_friend, 2); ?></td>
                    <td style="text-align:right;"><?php echo number_format($grand_total, 2); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
// ฟังก์ชัน Export เป็น Excel
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    filename = filename?filename+'.xls':'excel_data.xls';

    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);

    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], { type: dataType });
        navigator.msSaveOrOpenBlob(blob, filename);
    }else{
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        downloadLink.download = filename;
        downloadLink.click();
    }
}
</script>

<?php
mysqli_close($link);
include('../tmp_dsh2/footer.php');
?>