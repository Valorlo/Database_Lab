<?php
// 載入db.php來連結資料庫
include 'nav.php';
require_once 'db.php';
?>

<?php
// 取得特定書籍資料
$bkid = $_GET["bkid"];
$stdnum = $_SESSION['stdnum'];

// 尋找書籍資訊
$sql = "SELECT * FROM books WHERE books.bkid = '$bkid'";

// 用mysqli_query方法執行(sql語法)將結果存在變數中
$result = $connect->query($sql);

// 如果有資料
if ($result) {
    $datas = $result->fetch_assoc();
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
    <title><?php echo $datas['bookname'] ?></title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="book.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
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
    <!-- Product section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6">
                    <img class="card-img-top mb-5 mb-md-0" src=<?php echo $datas['img'] ?> />
                </div>
                <div class="col-md-6">
                    <?php if ($datas['status'] == 2) : ?>
                        <div class="badge bg-danger text-white mb-2">New</div>
                    <?php endif; ?>
                    <div class="small mb-1">
                        <?php
                        if ($datas['ISBN'] != "") {
                            echo "ISBN : " . $datas['ISBN'];
                        }
                        ?>
                    </div>
                    <h1 class="display-5 fw-bolder"><?php echo $datas['bookname'] ?></h1>
                    <div class="fs-5 mb-5">
                        <span>作者: <?php echo $datas['author'] ?></span>
                    </div>
                    <p class="lead">
                        出版商: <?php echo $datas['publisher'] ?><br>
                        狀態: <?php
                            if ($datas['status'] != 0) {
                                echo "可借閱";
                            } else {
                                echo "已借閱";
                            }
                            ?>
                        <br>
                    </p>
                    <div class="d-flex">
                        <?php

                        $sql = "SELECT bookslip.status FROM bookslip, borrowing
                            WHERE bookslip.stdnum = '$stdnum' AND bookslip.bid = borrowing.bid AND borrowing.bkid = $bkid AND DATEDIFF(bookslip.returned_date, now()) > 0";

                        // 用mysqli_query方法執行(sql語法)將結果存在變數中
                        $result = $connect->query($sql);
                        $borrowed = array();

                        // 如果有資料
                        if ($result) {
                            $borrowed = $result->fetch_assoc();
                            // 釋放資料庫查到的記憶體
                            mysqli_free_result($result);
                        } else {
                            echo "{$sql} 語法執行失敗，錯誤訊息: " . mysqli_error($link);
                        }
                        ?>
                        <?php if (is_countable($borrowed) && count($borrowed) > 0) : ?>
                            <p style="color:blue;">您已借閱</p>
                        <?php else : ?>
                            <button class="btn btn-outline-dark flex-shrink-0 operations" type="button">
                                <i class="bi bi-journal-plus"></i><?php
                                if ($datas['status'] != 0) {
                                    echo "借閱";
                                } else {
                                    echo "預約";
                                }
                                ?>
                            </button>
                        <?php endif; ?>

                    </div>
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
    <script src="js/login.js"></script>
    <script src="js/register.js"></script>
    <script src="js/borrow.js"></script>
</body>

</html>