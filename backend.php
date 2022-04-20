<?php
require_once 'db.php';

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
?>

<?php if (!isset($_SESSION["type"])) :
    header("Location: 401.php");
?>
<?php else : ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>System Backend</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="css/backend.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>

    <body class="sb-nav-fixed">
        <!-- new books -->
        <div class="modal fade" id="addBooks" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addbooksLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerLabel">Add Books</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text">ISBN</span>
                            <input type="text" class="form-control" id="ISBN">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Publisher</span>
                            <input type="password" class="form-control" id="pub">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Author</span>
                            <input type="text" class="form-control" id="author">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Book Name</span>
                            <input type="text" class="form-control" id="bookname">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Category</span>
                            <select class="form-select cate">
                                <option selected>圖書</option>
                                <option>期刊</option>
                                <option>學位論文</option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Image Path</span>
                            <input type="text" class="form-control" id="img">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="newBook">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- edit books -->
        <div class="modal fade" id="editBooks" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editbooksLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerLabel">Edit Books</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text">ISBN</span>
                            <input type="text" class="form-control" id="ISBN">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Publisher</span>
                            <input type="password" class="form-control" id="pub">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Author</span>
                            <input type="text" class="form-control" id="author">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Book Name</span>
                            <input type="text" class="form-control" id="bookname">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Category</span>
                            <select class="form-select cate">
                                <option selected>圖書</option>
                                <option>期刊</option>
                                <option>學位論文</option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Status</span>
                            <select class="form-select status">
                                <option selected value="2">新書</option>
                                <option value="0">借閱</option>
                                <option value="1">預約</option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Image Path</span>
                            <input type="text" class="form-control" id="img">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="changeBook">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="backend.php">System Backend</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div style="color:white"><?php echo $_SESSION['stdnum'] . " " . $_SESSION['username'] . " " ?></div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <button class="btn btn-success" onclick="window.location.href= 'homePage.php'">
                    <i class="bi bi-front"></i>
                    Frontend
                </button>
                <div class="m-2"></div>
                <button class="btn btn-secondary logout">
                    <i class="bi bi-people-fill"></i>
                    Logout
                </button>
                <script>
                    $(".logout").click(function() {
                        window.location.href = "apis/logout.php";
                    });
                </script>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">DB Table</div>
                            <a class="nav-link books" href="backend.php">
                                <div class="sb-nav-link-icon"><i class="bi bi-book"></i></div>
                                Books
                            </a>
                            <!-- 有空再補充 -->
                            <!-- <a class="nav-link borrowers" style="cursor: pointer;">
                                <div class="sb-nav-link-icon"><i class="bi bi-person-badge"></i></div>
                                Borrowers
                            </a> -->
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Backend Manager
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4 mb-3">Books</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Book Table
                            </div>
                            <div class="card-body">
                                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addBooks">
                                    新增
                                </button>
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editBooks">
                                    編輯
                                </button>
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteBooks">
                                    刪除
                                </button>
                                <div class="m-2"></div>
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="chkAll"></th>
                                            <th>Bkid</th>
                                            <th>ISBN</th>
                                            <th>Publisher</th>
                                            <th>Author</th>
                                            <th>Bookname</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Img</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th><input type="checkbox"></th>
                                            <th>Bkid</th>
                                            <th>ISBN</th>
                                            <th>Publisher</th>
                                            <th>Author</th>
                                            <th>Bookname</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Img</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php if (!empty($datas)) : ?>
                                            <!-- 資料 as key(下標) => row(資料的row) -->
                                            <?php foreach ($datas as $key => $book) : ?>
                                                <tr>
                                                    <td><input type="checkbox" id=<?php echo $book['bkid'] ?>></td>
                                                    <td><?php echo $book['bkid'] ?></td>
                                                    <td><?php echo $book['ISBN']; ?></td>
                                                    <td><?php echo $book['publisher']; ?></td>
                                                    <td><?php echo $book['author']; ?></td>
                                                    <td><?php echo $book['bookname']; ?></td>
                                                    <td><?php echo $book['category']; ?></td>
                                                    <td><?php echo $book['status']; ?></td>
                                                    <td><?php echo $book['img']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script>
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script src="js/backendBorrower.js"></script>
        <script src="js/dbIUD.js"></script>
    </body>

    </html>
<?php endif; ?>