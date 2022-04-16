<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIlab library system!</title>
</head>

<body>
    <?php
    // 載入db.php來連結資料庫
    require_once 'db.php';
    ?>

    <h3>sql查詢結果</h3>

    <?php
    // 設置一個空陣列來放資料
    $datas = array();
    // sql語法存在變數中
    $sql = "SELECT * FROM books";

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
    ?>

    <h3>foreach列出查詢結果</h3>
    <div>
        <?php if (!empty($datas)) : ?>
            <ul>
                <!-- 資料 as key(下標) => row(資料的row) -->
                <?php foreach ($datas as $key => $row) : ?>
                    <li>
                        第<?php echo ($key + 1); ?> 筆資料，書名<?php echo $row['bookname']; ?>，照片 <img src=<?php echo $row['img']; ?>>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else :  ?>
            查無資料
        <?php endif; ?>
    </div>

    <?php mysqli_close($connect); ?>
</body>

</html>