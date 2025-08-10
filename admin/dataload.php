<?php
// เชื่อมต่อฐานข้อมูล
$conn = mysql_connect('localhost', 'root', 'village');
mysql_select_db('finance', $conn);

// การบันทึกข้อมูลลงฐานข้อมูล
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
    $data = json_decode($_POST['data'], true);
    foreach ($data as $row) {
        $collector_name = mysql_real_escape_string($row['collector_name']);
        $loan_code = mysql_real_escape_string($row['loan_code']);
        $principal_amount = (float)$row['principal_amount'];
        $interest_amount = (float)$row['interest_amount'];

        $sql = "INSERT INTO loan_records (collector_name, loan_code, principal_amount, interest_amount)
                VALUES ('$collector_name', '$loan_code', $principal_amount, $interest_amount)";
        mysql_query($sql, $conn);
    }
    echo json_encode(array('status' => 'success'));
    exit;
}

// ดึงข้อมูลสำหรับการแสดงผล
$query = "SELECT * FROM loan_records ORDER BY created_at DESC";
$result = mysql_query($query, $conn);
$data = array();
while ($row = mysql_fetch_assoc($result)) {
    $data[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Data Management</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>ระบบจัดการข้อมูลเงินกู้</h1>
    <form id="dataForm">
        <textarea id="excelData" rows="10" cols="50" placeholder="Paste your data here"></textarea><br>
        <button type="button" id="saveButton">บันทึกข้อมูล</button>
    </form>

    <h2>รายการที่บันทึก</h2>
    <table border="1">
        <thead>
            <tr>
                <th>#</th>
                <th>ชื่อผู้จัดเก็บ</th>
                <th>รหัสเงินกู้</th>
                <th>เงินต้น</th>
                <th>ดอกเบี้ย</th>
                <th>วันที่บันทึก</th>
            </tr>
        </thead>
        <tbody id="recordTable">
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['collector_name']) ?></td>
                    <td><?= htmlspecialchars($row['loan_code']) ?></td>
                    <td><?= number_format($row['principal_amount'], 2) ?></td>
                    <td><?= number_format($row['interest_amount'], 2) ?></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function () {
            $('#saveButton').on('click', function () {
                const rawData = $('#excelData').val().trim();
                if (!rawData) {
                    alert('กรุณาวางข้อมูล');
                    return;
                }

                // แปลงข้อมูลจาก Text เป็น JSON
                const rows = rawData.split('\n').map(function(row) {
                    return row.split('\t');
                });
                const jsonData = rows.map(function(row) {
                    return {
                        collector_name: row[0],
                        loan_code: row[1],
                        principal_amount: parseFloat(row[2]) || 0,
                        interest_amount: parseFloat(row[3]) || 0
                    };
                });

                // ส่งข้อมูลไปยังเซิร์ฟเวอร์
                $.post('', { data: JSON.stringify(jsonData) }, function (response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert('บันทึกข้อมูลสำเร็จ');
                        location.reload();
                    } else {
                        alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
                    }
                });
            });
        });
    </script>
</body>
</html>
