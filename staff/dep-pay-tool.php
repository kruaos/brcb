<?php 
session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

$employee_use=$_SESSION['employee_USER'];

?>
<div class="container-fluid ">
    <div class="row">
        <div class="p-3 mb-2 col bg-primary">
            <h1 class="display-6">ระบบฝากสัจจะ </h1>
            <?php 
        echo "รหัสเจ้าหน้าที่ : ".$employee_use;
    ?>
        </div>    
    </div>
    <div class="row">
        <div class="col col-sm-12 col-md-4 col-lg-4 ">
        <!-- <form method="POST" action="dep-pay-tool-chk.php" > -->
        <form method="POST" action="dep-pay-insert.php" >
            <div class="form-group">
                <label >รหัสสมาชิก</label>
                <input type="text" class="form-control " placeholder="รหัสสมาชิก" name="IDMember_Dep" 
                onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}"
                onfocus="this.value = this.value;" autofocus >
                <!-- <input type="hidden" class="form-control "  value='a' name="switch_menu1"> -->
                <!-- <input type="submit" class="form-control btn-warning"  name="switch_menu1"> -->
            </div>
    </form>
    <form method="POST" action="dep-pay-tool.php" >
			
    </form>
</div>
<div class="col col-sm-12 col-md-8 col-lg-8 ">

    <table class="table table-bordered table-sm"  id='EdataTable' >
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
            $Datenow=date('Y-m-d');
            $SqlShowTable="Select * from deposit where username='$employee_use' and createdate='$Datenow' order by IDDeposit DESC";
            $QueryShowTable=mysqli_query($link,$SqlShowTable);
			$ShowSumAmount=0;
            $num1=1;
            while ($Result1=mysqli_fetch_array($QueryShowTable)){
                
                $IDRegFund=$Result1['IDRegFund'];
                $Amount=$Result1['Amount'];
                $IDDeposit=$Result1['IDDeposit'];
                
                $SqlIDMember="SELECT * FROM regfund WHERE IDRegfund=$IDRegFund";
                $QueryIDMember=mysqli_query($link,$SqlIDMember);
                while ($RQid=mysqli_fetch_array($QueryIDMember)){
                    $IDMember=$RQid['IDMember'];
                    $SqlFullName="SELECT * FROM member WHERE IDMember=$IDMember";
                    $QueryFullName=mysqli_query($link,$SqlFullName);
                    while ($RQFullName=mysqli_fetch_array($QueryFullName)){
                        $FullName=$RQFullName['Title'].$RQFullName['Firstname']." ".$RQFullName['Lastname'];
                        }
                }
			$ShowSumAmount=$ShowSumAmount+$Amount;
                ?>
            <tr>
                <td scope="row"><?php echo $num1;?></td>
                <td><?php echo $IDMember;?></td>
                <td><?php echo $IDRegFund;?></td>
                <td><?php echo $FullName;?></td>
                <td><?php echo $Amount;?></td>
                <td><a href="dep-pay-edit.php?IDDeposit=<?php echo $IDDeposit;?>" class="btn-danger btn-sm">แก้ไข</a></td>
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
            ?>
        </div>
    </div>
</div>
<?PHP 
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>