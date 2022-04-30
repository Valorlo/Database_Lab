<?php
    require_once '../db.php';

    // 書籍資料
    $isbn = $_POST["isbn"];
    $pub = $_POST["pub"];
    $author = $_POST["author"];
    $bookname = $_POST["bookname"];
    $cate = $_POST["cate"];
    $img = $_POST["img"];

    $sql = "INSERT INTO books VALUES (DEFAULT, '$isbn', '$pub', '$author', '$bookname', '$cate', 2, ($img == '') ? DEFAULT : '$img')";

    // 用mysqli_query方法執行(sql語法)將結果存在變數中
    $result = $connect->query($sql);

    // 判斷是否執行成功
    if ($result) {
        echo true;
    } else {
        echo false;
    }
?>