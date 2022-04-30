<?php
require_once '../db.php';

$bkid = $_GET['bkid'];
$stdnum = $_SESSION["stdnum"];

// sql語法存在變數中
$sql = "INSERT INTO reservation VALUES (DEFAULT, '$stdnum', '$bkid', NOW());";

// 用mysqli_query方法執行(sql語法)將結果存在變數中
$result = $connect->query($sql);


// 判斷是否執行成功
if ($result) {
    echo true;
} else {
    echo false;
}
?>