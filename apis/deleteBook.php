<?php
require_once '../db.php';

// 要刪除的書籍bkid
$ids = $_POST["ids"];
$bkids = "";

foreach ($ids as $id => $val) {
    if (!empty($bkids)) {
        $bkids .= ", '" . $val . "'";
    } else {
        $bkids .= "'" . $val . "'";
    }
}
// 尋找帳號密碼
$sql = "DELETE FROM books WHERE bkid in ($bkids)";

// 用mysqli_query方法執行(sql語法)將結果存在變數中
$result = $connect->query($sql);

// 判斷是否執行成功

if ($result) {
    echo true;
} else {
    echo false;
}
?>