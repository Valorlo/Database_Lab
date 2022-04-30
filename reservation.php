<?php
// 載入db.php來連結資料庫
include 'nav.php';
require_once 'db.php';
?>

<?php
$stdnum = $_SESSION['stdnum'];

// 借書單
$sql = "SELECT * FROM reservation WHERE reservation.stdnum = '$stdnum'";

// 用mysqli_query方法執行(sql語法)將結果存在變數中
$result = $connect->query($sql);
$datas = array();

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>預約單</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="book.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/backend.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <!-- Product section-->
    <section class="py-5">
        <div class="container-fluid px-4 px-lg-5 my-5">
            <h1 class="mt-4 mb-3">Reservation</h1>
            <div class="card">
                <div class="card-body">
                    <?php if (!empty($datas)) : ?>
                    <div class="m-2"></div>
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="chkAll" ></th>
                                <th>Reservation Id</th>
                                <th>Stdnum</th>
                                <th>Book Id</th>
                                <th>Reserved Date</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><input type="checkbox" name="chkAll"></th>
                                <th>Reservation Id</th>
                                <th>Stdnum</th>
                                <th>Book Id</th>
                                <th>Reserved Date</th>
                            </tr>
                        </tfoot>
                        <tbody>
                                <!-- 資料 as key(下標) => row(資料的row) -->
                                <?php foreach ($datas as $key => $reserve) : ?>
                                    <tr>
                                        <td><input type="checkbox" id=<?php echo $reserve['rid'] ?>></td>
                                        <td><?php echo $reserve['rid'] ?></td>
                                        <td><?php echo $reserve['stdnum'] ?></td>
                                        <td><?php echo $reserve['bkid']; ?></td>
                                        <td><?php echo $reserve['reserved_date']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                        <h4>沒有預約紀錄</h4>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Designed by &copy; startbootstrap </p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>