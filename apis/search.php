<?php
    require_once '../db.php';
    // 書本分類
    $cate = $_POST["cate"];
    $keyword = $_POST["keyword"];

    // 設置一個空陣列來放資料
    $datas = array();
    // sql語法存在變數中
    if($cate == "全部圖書" && $keyword != ""){
        $sql = "SELECT * FROM books WHERE books.bookname LIKE '%$keyword%'";
    }
    else{
        $sql = "SELECT * FROM books WHERE books.category = '$cate' AND books.bookname LIKE '%$keyword%'";
    }

    // 用mysqli_query方法執行(sql語法)將結果存在變數中
    $result = $connect->query($sql);

    // 如果有資料
    if ($result) {
        // mysqli_num_rows方法可以回傳我們結果總共有幾筆資料
        if (mysqli_num_rows($result) > 0) {
            // 取得大於0代表有資料
            // while迴圈會根據資料數量，決定跑的次數
            // mysqli_fetch_assoc方法可取得一筆值
            while ($row = mysqli_fetch_assoc($result)) {
                // 每跑一次迴圈就抓一筆值，最後放進data陣列中
                $datas[] = $row;
            }
        }
        // 釋放資料庫查到的記憶體
        mysqli_free_result($result);
    } else {
        echo "{$sql} 語法執行失敗，錯誤訊息: " . mysqli_error($link);
    }
    echo json_encode($datas)
?>