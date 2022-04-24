<?php
// 載入db.php來連結資料庫
include 'nav.php';
require_once 'db.php';
?>

<?php
$stdnum = $_SESSION['stdnum'];

// 借書單
$sql = "SELECT * FROM bookslip, borrowing, books 
WHERE bookslip.stdnum = '$stdnum' AND bookslip.status = '0' AND borrowing.bid = bookslip.bid AND books.bkid = borrowing.bkid";

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

// 借書單
$sql = "SELECT * FROM bookslip, borrowing, books 
WHERE bookslip.stdnum = '$stdnum' AND bookslip.status = '1' AND borrowing.bid = bookslip.bid AND books.bkid = borrowing.bkid";

// 用mysqli_query方法執行(sql語法)將結果存在變數中
$result = $connect->query($sql);
$record = array();

// 如果有資料
if ($result) {
    // mysqli_num_rows方法可以回傳我們結果總共有幾筆資料
    if (mysqli_num_rows($result) > 0) {
        // 取得大於0代表有資料
        // while迴圈會根據資料數量，決定跑的次數
        // mysqli_fetch_assoc方法可取得一筆值
        while ($row = mysqli_fetch_assoc($result)) {
            // 每跑一次迴圈就抓一筆值，最後放進data陣列中
            $record[] = $row;
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
    <title>借書單</title>
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
    <!-- 借書單 section-->
    <section class="pt-4">
        <div class="container-fluid px-4 px-lg-5 my-5">
            <h1 class="mt-4 mb-3">Book slip</h1>
            <div class="card">
                <div class="card-body">
                    <?php if (!empty($datas)) : ?>
                        <button class="btn btn-outline-success" id="returned">
                            還書
                        </button>

                        <div class="m-2"></div>
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="chkAll"></th>
                                    <th>Stdnum</th>
                                    <th>Book Slip Id</th>
                                    <th>Book Id</th>
                                    <th>Book name</th>
                                    <th>Borrow Date</th>
                                    <th>Return Date</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th><input type="checkbox"></th>
                                    <th>Stdnum</th>
                                    <th>Book Slip Id</th>
                                    <th>Book Id</th>
                                    <th>Book name</th>
                                    <th>Borrow Date</th>
                                    <th>Return Date</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <!-- 資料 as key(下標) => row(資料的row) -->
                                <?php foreach ($datas as $key => $bookslip) : ?>
                                    <tr>
                                        <td><input type="checkbox" id=<?php echo $bookslip['bid'] ?>></td>
                                        <td><?php echo $bookslip['stdnum'] ?></td>
                                        <td><?php echo $bookslip['bid']; ?></td>
                                        <td><?php echo $bookslip['bkid'] ?></td>
                                        <td><?php echo $bookslip['bookname'] ?></td>
                                        <td><?php echo $bookslip['borrow_date']; ?></td>
                                        <td><?php echo $bookslip['returned_date']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <h4>沒有借書單</h4>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <hr>
    <!-- 借書紀錄 section-->
    <section class="pb-4">
        <div class="container-fluid px-4 px-lg-5 my-5">
            <h1 class="mt-4 mb-3">Borrowing Record</h1>
            <div class="card">
                <div class="card-body">
                    <?php if (!empty($record)) : ?>
                        <div class="m-2"></div>
                        <table id="borrowRecord">
                            <thead>
                                <tr>
                                    <th>Stdnum</th>
                                    <th>Book Slip Id</th>
                                    <th>Book Id</th>
                                    <th>Book name</th>
                                    <th>Borrow Date</th>
                                    <th>Return Date</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Stdnum</th>
                                    <th>Book Slip Id</th>
                                    <th>Book Id</th>
                                    <th>Book name</th>
                                    <th>Borrow Date</th>
                                    <th>Return Date</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <!-- 資料 as key(下標) => row(資料的row) -->
                                <?php foreach ($record as $key => $bookrecord) : ?>
                                    <tr>
                                        <td><?php echo $bookrecord['stdnum'] ?></td>
                                        <td><?php echo $bookrecord['bid']; ?></td>
                                        <td><?php echo $bookrecord['bkid'] ?></td>
                                        <td><?php echo $bookrecord['bookname'] ?></td>
                                        <td><?php echo $bookrecord['borrow_date']; ?></td>
                                        <td><?php echo $bookrecord['returned_date']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <h4>沒有借書紀錄</h4>
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
    <script src="js/returnBook.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>