<?php
require_once '../db.php';

// 要刪除的書籍bkid
$ids = $_POST["ids"];
$bids = "";

foreach ($ids as $id => $val) {
    if (!empty($bids)) {
        $bids .= ", '" . $val . "'";
    } else {
        $bids .= "'" . $val . "'";
    }
}
// 尋找帳號密碼
$sql = "UPDATE bookslip SET bookslip.status = 1, bookslip.returned_date = now() WHERE bookslip.bid in ($bids);";
$sql .= "UPDATE books SET books.status = 1 WHERE books.bkid in (SELECT borrowing.bkid FROM borrowing WHERE borrowing.bid in ($bids));";
// $sql .= "DELETE FROM borrowing WHERE 1;";

// 執行多筆sql語法
mysqli_multi_query($connect, $sql);
do{
    if ($result = mysqli_store_result($connect)){
        while($row = mysqli_fetch_row($result)); 
    }
}while(mysqli_next_result($connect));

// 判斷是否執行成功

echo true;

?>