<?php
    require_once '../db.php';
    session_start();
    // 帳號密碼
    $stdnum = $_POST["std"];
    $pwd = $_POST["pwd"];
    // 尋找帳號密碼
    $sql = "SELECT * FROM borrower WHERE borrower.stdnum = '$stdnum' AND borrower.password = MD5('$pwd')";

    $datas = array();
    // 用mysqli_query方法執行(sql語法)將結果存在變數中
    $result = $connect->query($sql);

    // 如果有資料
    if ($result) {
        // mysqli_num_rows方法可以回傳我們結果總共有幾筆資料
        if (mysqli_num_rows($result) > 0) {
            // 取得大於0代表有資料
            while ($row = mysqli_fetch_assoc($result)) {
                // 每跑一次迴圈就抓一筆值，最後放進data陣列中
                $datas[] = $row;
            }
            $_SESSION["stdnum"] = $datas[0]['stdnum'];
            $_SESSION["username"] = $datas[0]['name'];
            $_SESSION["type"] = $datas[0]['type'];
            echo true;
        }else{
            echo false;
        }
        // 釋放資料庫查到的記憶體
        mysqli_free_result($result);
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息: " . mysqli_error($link);
    }
?>