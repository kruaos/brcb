<?
$income=$result['income'];
$createdate=$result['createdate'];
$deptime=$result['deptime'];
$time=$result['time'];
$code=null;
include('../config/config.php');
    mysqli_set_charset($link,'utf8');
    $result = mysqli_query($link, $sql);
    $sql = "Insert into eventbankaddint values(
        '$income','$code',
        '$deptime',
        '$createdate',
        '$time'
        )";
    $result = mysqli_query($link, $sql);

?>