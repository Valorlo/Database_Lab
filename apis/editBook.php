<?php
    require_once '../db.php';

    // 書籍資料
    $bkid = $_POST['bkid'];
    $isbn = $_POST["isbn"];
    $pub = $_POST["pub"];
    $author = $_POST["author"];
    $bookname = $_POST["bookname"];
    $status = $_POST["status"];
    $cate = $_POST["cate"];
    $img = $_POST["img"];
    // 更新書籍資料
    $sql = "UPDATE books SET ISBN = '$isbn', publisher = '$pub', author = '$author', bookname = '$bookname', category = '$cate', status = '$status', img = '$img'
    WHERE bkid = '$bkid'";

    // 用mysqli_query方法執行(sql語法)將結果存在變數中
    $result = $connect->query($sql);

    // 判斷是否執行成功
    if ($result) {
        echo true;
    } else {
        echo false;
    }
?>