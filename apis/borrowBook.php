<?php
    require_once '../db.php';

    // 借書資料
    $bkid = $_POST["bkid"];
    $stdnum = $_SESSION["stdnum"];

    // 尋找帳號密碼
    $sql = "INSERT INTO bookslip VALUES ('$stdnum', DEFAULT, NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY), DEFAULT);";
    $sql .= "UPDATE books SET books.status = 0 WHERE books.bkid = '$bkid';";

    // 執行多筆sql語法
    mysqli_multi_query($connect, $sql);
    do{
        if ($result = mysqli_store_result($connect));
    }while(mysqli_next_result($connect));

    $sql = "SELECT * FROM bookslip WHERE stdnum = '$stdnum' ORDER BY bookslip.bid DESC LIMIT 1";
    $sel = $connect->query($sql);
    $row = $sel->fetch_assoc();
    mysqli_free_result($sel);

    $bid = $row["bid"];
    $sql = "INSERT INTO borrowing VALUES('$bid', '$bkid')";
    $ins = $connect->query($sql);

    // 判斷是否執行成功
    if ($ins) {
        echo true;
    } else {
        echo false;
    }
?>