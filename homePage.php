<?php
// 載入db.php來連結資料庫
include 'nav.php';
require_once 'db.php';
?>

<?php
if (!isset($_GET["category"]) && !isset($_GET["keyword"])) {
    // 將書籍資料載入 
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

    $datas = array_reverse($datas);
}
?>

<?php
// 書本分類
if (isset($_GET["category"]) || isset($_GET["keyword"])) {
    $cate = $_GET["category"];
    $keyword = $_GET["keyword"];

    // 設置一個空陣列來放資料
    $datas = array();
    // sql語法存在變數中
    if ($cate == "全部圖書" && $keyword != "") {
        $sql = "SELECT * FROM books WHERE books.bookname LIKE '%$keyword%'";
    } else {
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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>AIlab library system</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="book.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- my CSS -->
    <link href="css/homePage.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <!-- Login section -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Student Number</span>
                        <input type="text" class="form-control" id="stdnum">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Password</span>
                        <input type="password" class="form-control" id="pwd">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="login">Login</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Register section -->
    <div class="modal fade" id="register" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="registerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerLabel">Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Student Number</span>
                        <input type="text" class="form-control" id="stdnum_r">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Password</span>
                        <input type="password" class="form-control" id="pwd_r">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Name</span>
                        <input type="text" class="form-control" id="name_r">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Phone number</span>
                        <input type="text" class="form-control" id="phone_r">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Identification number</span>
                        <input type="text" class="form-control" id="id_r">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">E-mail</span>
                        <input type="text" class="form-control" id="email_r">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="createUser">Register</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Welcome to AI Lab Library System !</h1>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="pb-5">
        <div class="container px-4 px-lg-5 mt-5">
            <row>
                <div class="input-group mb-5">
                    <input type="text" class="form-control keyword" placeholder="want somthing?">
                    <button class="btn btn-outline-secondary" type="button" id="search"><i class="bi bi-search"></i></button>
                    <select class="btn btn-outline-secondary" id="bookCate">
                        <option selected>全部圖書</option>
                        <option>圖書</option>
                        <option>期刊</option>
                        <option>學位論文</option>
                    </select>
                </div>
            </row>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center display">

                <?php if (!empty($datas)) : ?>
                    <!-- 資料 as key(下標) => row(資料的row) -->
                    <?php foreach ($datas as $key => $book) : ?>
                        <div class="col mb-5" id=<?php echo $book['bkid'] ?>>
                            <div class="card h-100">
                                <?php if ($book['status'] == 2) : ?>
                                    <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">New</div>
                                <?php endif; ?>
                                <!-- Product image-->
                                <img class="card-img-top" src=<?php echo $book['img']; ?> alt="..." />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder"><?php echo $book['bookname']; ?></h5>
                                        <!-- Product price-->
                                        <?php echo $book['author']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <h4>查無資料</h4>
                <?php endif; ?>
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
    <!-- my JS -->
    <script src="js/searchDB.js"></script>
    <script src="js/login.js"></script>
    <script src="js/register.js"></script>
    <script src="js/bookinfo.js"></script>
</body>

</html>