<?php
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

// ฟังก์ชันแสดงวันที่แบบไทย
function show_day($showday)
{
    $m_name = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    echo number_format(substr($showday, 8, 2)) . " " . $m_name[number_format(substr($showday, 5, 2))] . " " . (substr($showday, 0, 4) + 543);
}

// ตั้งค่าการแบ่งหน้า
$perpage = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$start = ($page - 1) * $perpage;

// ค้นหา
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = "bankstatus='op'";
if ($search != '') {
    $search_sql = mysqli_real_escape_string($link, $search);
    $where .= " AND (bankname LIKE '%$search_sql%' OR bankid LIKE '%$search_sql%')";
}



// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตั้งค่า character set
mysqli_set_charset($link, "utf8");

// ตรวจสอบว่ามีการส่งค่า page และ search มาหรือไม่
if (isset($_GET['page'])) {
    $page = intval($_GET['page']);
} else {
    $page = 1; // กำหนดหน้าเริ่มต้นเป็น 1
}
if ($page < 1) {
    $page = 1; // ป้องกันการตั้งค่าหน้าเป็นค่าติดลบ
}
// ตรวจสอบว่ามีการส่งค่า search มาหรือไม่
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
} else {
    $search = ''; // กำหนดค่าเริ่มต้นเป็นค่าว่าง
}

// สร้างเงื่อนไขสำหรับการค้นหา
$where = "bankstatus='op'";
if ($search != '') {
    $search_sql = mysqli_real_escape_string($link, $search);
    $where .= " AND (bankname LIKE '%$search_sql%' OR bankid LIKE '%$search_sql%')";
}





// นับจำนวนทั้งหมด
$sql_count = "SELECT COUNT(*) AS total FROM bankmember WHERE $where";
$query_count = mysqli_query($link, $sql_count);
$total_record = mysqli_fetch_assoc($query_count);
$total_record = $total_record['total'];
$total_page = ceil($total_record / $perpage);

// ดึงข้อมูลสมาชิก
$sql = "SELECT * FROM bankmember WHERE $where ORDER BY bankno ASC LIMIT $start, $perpage";
$query = mysqli_query($link, $sql);
?>
<div class="container-fluid">
    <div class="card-body">
        <h6 class="m-0 font-weight-bold text-primary">ข้อมูลสมาชิกธนาคารชุมชน</h6>
        <form class="form-inline mb-2" method="GET" action="bank-show.php">
            <input type="text" class="form-control mr-2" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="ชื่อสมาชิก / รหัสสมาชิก">
            <button type="submit" class="btn btn-primary">ค้นหา</button>
            <a href="bank-member-add.php" class="btn btn-success ml-2">เพิ่มสมาชิก</a>
        </form>
        <!-- <table class="table table-sm" width="100%" cellspacing="0" id='EdataTable'> -->
        <table class="table table-sm" width="100%" cellspacing="0" >
            <thead>
                <tr class="table-secondary">
                    <th>รหัส</th>
                    <th width="400px">ชื่อบัญชี</th>
                    <th align='right'>เงินคงเหลือ</th>
                    <th align="center">ฝาก-ถอน ล่าสุด</th>
                    <th>ฝาก-ถอน</th>
                    <th>แก้ไข</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($rs1 = mysqli_fetch_array($query)) {
                    $bankid = $rs1['bankid'];
                    ?>
                    <tr>
                        <td><a href="bank-view.php?bankid=<?php echo $rs1['bankid']; ?>"><?php echo $rs1['bankid']; ?></a></td>
                        <td><?php echo $rs1['bankname']; ?></td>
                        <td align='right'>
                            <?php
                            $sql1 = "SELECT SUM(income) AS sumbankevent FROM bankevent WHERE bank_event_status='1' AND bankid=$bankid";
                            $query1 = mysqli_query($link, $sql1);
                            $rs2 = mysqli_fetch_array($query1);
                            echo number_format($rs2['sumbankevent'], 2);
                            ?>
                        </td>
                        <td align="center">
                            <?php
                            $sql2 = "SELECT * FROM bankevent WHERE bank_event_status='1' AND bankid='$bankid' ORDER BY num DESC LIMIT 1";
                            $query2 = mysqli_query($link, $sql2);
                            if ($rs3 = mysqli_fetch_array($query2)) {
                                show_day($rs3['createdate']);
                            }
                            ?>
                        </td>
                        <td>
                            <a href="bank-event-dewi.php?bankid=<?php echo $rs1['bankid']; ?>" class="btn btn-primary btn-sm">ฝาก/ถอน</a>
                        </td>
                        <td>
                            <a href="bank-event-edit.php?bankid=<?php echo $rs1['bankid']; ?>" class="btn btn-warning btn-sm">แก้ไขรายการ</a>
                            <a href="bank-member-edit.php?bankid=<?php echo $rs1['bankid']; ?>" class="btn btn-danger btn-sm">แก้ไขบัญชี</a>
                        </td>
                    </tr>
                    <?php
                }
                mysqli_close($link);
                ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <ul class="pagination">
            <?php
            // กำหนดช่วงของเลขหน้า
            $range = 1; // จำนวนหน้าก่อนและหลังหน้าปัจจุบัน
            $start_page = max(1, $page - $range);
            $end_page = min($total_page, $page + $range);

            // ปุ่มหน้าแรก
            if ($page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=1&search=' . urlencode($search) . '">หน้าแรก</a></li>';
            }

            // ปุ่มย้อนกลับ
            if ($page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&search=' . urlencode($search) . '">ย้อนกลับ</a></li>';
            }

            // แสดงเลขหน้า
            for ($i = $start_page; $i <= $end_page; $i++) {
            $active = ($i == $page) ? 'active' : '';
            echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . '&search=' . urlencode($search) . '">' . $i . '</a></li>';
            }

            // ปุ่มถัดไป
            if ($page < $total_page) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&search=' . urlencode($search) . '">ถัดไป</a></li>';
            }

            // ปุ่มหน้าสุดท้าย
            if ($page < $total_page) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . $total_page . '&search=' . urlencode($search) . '">หน้าสุดท้าย</a></li>';
            }
            ?>
            </ul>
        </nav>
        <div>จำนวนสมาชิกทั้งหมด: <?php echo $total_record; ?></div>
    </div>
</div>
<?php
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>
