<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');
?>
<div class="container-fluid">
<?php 
function show_day($showday){
  $m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  echo  number_format(substr($showday, 8,2))."  ".$m_name[number_format(substr($showday, 5,2))]." ".(substr($showday, 0,4)+543);
}
$perpage = 500;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
  } else {
    $page = 1;
  }
    $start = ($page - 1) * $perpage;

    $IDMemberSql = "SELECT * from member ORDER BY IDMember ASC";
    $LoanBookSql="SELECT * from loanbook where LoanStatus ='N' Order by CreateDate " ;
    $query = mysqli_query($link, $LoanBookSql);
    $total_record=$query->num_rows;
    $total_page = ceil($total_record / $perpage);
?>
    <div class="card-body">    
    <h6 class="m-0 font-weight-bold text-primary">ข้อมูลสมาชิกเงินกู้ จำนวน <?php echo $total_record; ?> ราย </h6>
    <!-- nav แสดงหน้า -->
   

                   </ul>
                   </nav> 
                <table class="table table-sm "  width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th >รหัส</th>
                      <th >ชื่อ - สกุล </th>
                      <th >สัญญากู้ปัจจุบัน</th>
                      <th >วันที่ยื่นกู้</th>
                      <th >วันที่จ่ายล่าสุด</th>
                      <th >จำนวนเงิน </th>
                      <th class="d-print-none">แสดงรายการ</th>
                      <th class="d-print-none">ประวัติการกู้</th>
                      <th class="d-print-none">ประวัติการค้ำ</th>
                    </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
$EndCreateDate='0000-00-00';
$Loan2BookSql="SELECT * from loanbook where LoanStatus ='N' Order by IDMember " ;
$query = mysqli_query($link, $Loan2BookSql);
$num=0; 
while($rs1 = mysqli_fetch_array($query))
{
    $IDMember=$rs1['IDMember'];
    $sqlin3 = "select * from Loanbook where IDMember='$IDMember' and LoanStatus='N'";
    $queryin3 = mysqli_query($link, $sqlin3);
    if ($queryin3->num_rows==2){

    $IDMember=$rs1['IDMember'];
    $RefNo=$rs1['RefNo'];
    $FullNameSql = "SELECT * from member where IDMember='$IDMember' ";
    $FullNameQuery = mysqli_query($link, $FullNameSql);
    while($FNQ = mysqli_fetch_array($FullNameQuery)){
        $FullName=$FNQ['Title'].$FNQ['Firstname']." ".$FNQ['Lastname'] ;
    } 
    $LastLoanPaymentSql="SELECT * from loanpaymentlastdate where RefNo='$RefNo' ";
    $LastLoanPaymentQuery = mysqli_query($link, $LastLoanPaymentSql);
    ?>             
        <tr>
            <td><?php echo sprintf('%04d',$rs1['IDMember']); ?></td>
            <td><?php echo $FullName; ?>
            </td>
            <td >
            <?php 
            $sqlin3 = "select * from Loanbook where IDMember='$IDMember' and LoanStatus='N'";
            $queryin3 = mysqli_query($link, $sqlin3);
            if ($queryin3->num_rows==0){
              // print_r($queryin3);
              ?>
            ไม่มีการกู้ขณะนี้ 
            <?php }else if ($queryin3->num_rows==1){?>
            <div class='bg-success'> มีการกู้ <?php echo $queryin3->num_rows; ?> สัญญา</div>
            <?php }else{ ?>         
            <div class='bg-warning'> มีการกู้ <?php echo $queryin3->num_rows; ?> สัญญา</div>
            <?php } ?>         
            </td>  
            <td><?php 

            $StartCreateDate=$rs1['CreateDate']; 

            echo show_day($rs1['CreateDate']); 
            ?></td>
            <td><?php 
                  while($LLPQ = mysqli_fetch_array($LastLoanPaymentQuery)){
                  $EndCreateDate=$LLPQ['LastDate'] ;
                   echo show_day($LLPQ['LastDate']);
                  } 

                ?>
        </td>
            <td style="text-align:right;">
<?php 
            echo number_format($rs1['Amount']);
?>
            </td>             
            <td class="d-print-none"><a href="loan-pay-show1.php?RefNo=<?php echo $RefNo;?>">แสดง</a></td>             
            <td class="d-print-none">
            <?php 
            $sqlloan = "select * from Loanbook where IDMember='$IDMember'";
            $queryloan = mysqli_query($link, $sqlloan);
            if ($queryloan->num_rows<>0){
            ?>
            <a href="loan-cus-show.php?memid=<?php echo $rs1['IDMember'];?>" class="btn btn-danger btn-sm">ประวัติการกู้ <?php echo $queryloan->num_rows;?> ครั้ง</a>
            <?php }else{?>
            ไม่มีประวัติการกู้
            <?php } ?>
            </td>
            <td class="d-print-none">
            <?php 
            $sqlin1 = "select * from Loanbook where Insurer1=".$rs1['IDMember']." or Insurer2=".$rs1['IDMember'];
            $queryin1 = mysqli_query($link, $sqlin1);
            if ($queryin1->num_rows<>0){
            ?>
            <a href="loan-in-show.php?memid=<?php echo $rs1['IDMember'];?>" class="btn btn-success btn-sm">ตรวจผู้ค้ำ <?php echo $queryin1->num_rows;?> ราย </a>
            <?php }else{?>
            ไม่มีประวัติการค้ำประกัน
            <?php } ?>                        
            </td>
        </tr>

<?php 
            }
        } 
  mysqli_close($link);
?>                    
                  </tbody>
                </table>
            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>