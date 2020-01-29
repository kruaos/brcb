<?php 
function DateTimeDiff($strDateTime1,$strDateTime2)
{
    return((strtotime($strDateTime2)-strtotime($strDateTime1))/(60*60))/24;
}
/*      
หลักคิด 
    1. เมื่อมียอดเข้า รายการวันเข้า ต้องทราบว่า รายการวันนั้น ครบปีเมื่อใด 
    2. วันที่ครบปี น้อยกว่าวันปัจจะบัน (ยังมาไม่ถึง) หรือมากกว่าปัจจุบัน (เลยมาแล้ว)
    3. แสดงจำนวนปีที่ครบ และจำนวนวันที่ครบ 
    4. เศษปี จะต้อง แสดงเพือให้ทราบ
*/
// ........ทดสอบการดึงข้อมูล................................
include('../config/config.php');
    $sqlname = "SELECT * FROM eventbank where num='1439' ";
    $query = mysqli_query($link, $sqlname);
    $result = mysqli_fetch_array($query);

//.........................................................
$dateinput=$result['createdate'];
$inputday=substr($dateinput,8,2);
$inputmonth=substr($dateinput,5,2);
$inputyear=substr($dateinput,0,4);
$inputHH=substr($dateinput,11,2);
$inputMM=substr($dateinput,14,2);
$inputYY=substr($dateinput,17,4);

$dateincome=mktime($inputHH ,$inputMM  ,$inputYY ,$inputmonth,$inputday,$inputyear);
$last_day = mktime(23, 59, 59, 12, 31, date('Y'));//วันสุดท้ายของปี 

$nowday=date('Y-m-d H:i:s');
$inputnday=substr($nowday,8,2);
$inputnmonth=substr($nowday,5,2);
$inputnyear=substr($nowday,0,4);
$inputnHH=substr($nowday,11,2);
$inputnMM=substr($nowday,14,2);
$inputnYY=substr($nowday,17,4);

$now_day = mktime($inputnHH ,$inputnMM  ,$inputnYY ,$inputnmonth,$inputnday,$inputnyear);
//$now_day = mktime(23, 59, 59, 10, 14, date('Y'));
$countaYears=date("Y",$dateincome);
//$last_day = mktime(23, 59, 59, 12, 31, date('Y'));

$countaYY=((date('y',$now_day)-date('y',$dateincome)));
$countaDD=floor(DateTimeDiff(date('Y-m-d', $dateincome),date('Y-m-d', $now_day)));
// วันสิ้นเดือน คำนวณจากวันต้นเดือน - เดือนสุดท้าย ตามปฏิทินปัจจุบัน วันนี้ตอนนี้ 
// แสดงผล
echo 'วันที่ฝาก '.date("Y-m-d",$dateincome);
echo '<br>วันที่ปัจจุบัน '.date('Y-m-d H:i:s', $now_day).'<hr>';
// สูตรหาจำนวน หาจำนวนปี  
echo 'ปีที่เริ่มต้น '.$countaYears."<br>";
echo 'จำนวนปีที่ครบ '.$countaYY.' ปี <br>';
// สูตรหาจำนวน วัน 
echo 'จำนวนวันที่ฝาก '.$countaDD.' วัน<hr>';
$countenddaylast=0;
for ($d=1;$d<=$countaYY;$d++){
    $last_day = mktime(23, 59, 59, 12, 31,$countaYears);
    $countendday=floor(DateTimeDiff(date('Y-m-d', $dateincome),date('Y-m-d', $last_day)));
    $countshowday=$countendday-$countenddaylast;
    $intincome=(($result['income']*0.0125)/365)*$countshowday;
    echo 'ปีที่ '.$d.' = '.date('Y',$last_day) .'  >> '.$countshowday.' ฝาก ['.$result['income'].'] ดอก ['.$intincome.']'.'<br><hr>';
    $countaYears=$countaYears+1;
    $countenddaylast=floor(DateTimeDiff(date('Y-m-d', $dateincome),date('Y-m-d', $last_day)));
}

if($countaYY=='0'){
    //ถ้าไม่ครบปีเลย
    $intincome2=(($result['income']*0.0125)/365)*$countaDD;
    echo 'ปีที่ '.$d.' = '.date('Y',$dateincome) .'  >> '.$countaDD.' ฝาก ['.$result['income'].'] ดอก ['.$intincome2.']'.'<br><hr>';
}else{
    //ถ้าครบปี 
    $countshowday=floor(DateTimeDiff(date('Y-m-d', $last_day),date('Y-m-d', $now_day)));
    $intincome3=(($result['income']*0.0125)/365)*$countshowday;
    echo 'ปีที่ '.$d.' = '.date('Y',$now_day) .'  >> '.$countshowday.' ฝาก ['.$result['income'].'] ดอก ['.$intincome3.']'.'<br><hr>';
}
    
?>