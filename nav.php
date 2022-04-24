<?php
// 載入db.php來連結資料庫
require_once 'db.php';
?>

<!-- Navigation-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="/homePage.php">AI Lab Library</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <?php if (isset($_SESSION["type"])) : ?>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="bookslip.php">借書單</a></li>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="reservation.php">預約單</a></li>
                    <?php endif;?>
                </ul>
                <!-- 如果沒有session表示還沒登入 -->
                <?php if (!isset($_SESSION["type"])) : ?>
                    <div class="d-flex">
                        <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <i class="bi bi-people-fill"></i>
                            Login
                        </button>
                    </div>
                    <div class="m-1"></div>
                    <div class="d-flex">
                        <button class="btn btn-outline-primary mr-2" data-bs-toggle="modal" data-bs-target="#register">
                            <i class="bi bi-vector-pen"></i>
                            Sign Up
                        </button>
                    </div>
                <!-- 登入後確認身分組，1為管理員 -->
                <?php else:?>
                    <div class="m-2"><?php echo $_SESSION['stdnum'] . " " . $_SESSION['username'] . " " ?></div>
                    <?php if ($_SESSION["type"] == 1) : ?>
                        <div class="d-flex">
                            <button class="btn btn-outline-success mr-2" onclick="window.location.href= 'backend.php'   ">
                            <i class="bi bi-back"></i>
                                Backend
                            </button>
                        </div>
                    <?php endif; ?>
                    <div class="m-1"></div>
                    <div class="d-flex">
                        <button class="btn btn-outline-dark mr-2 logout">
                            <i class="bi bi-people-fill"></i>
                            Logout
                        </button>
                        <script>
                            $(".logout").click(function(){
                                window.location.href = "apis/logout.php";
                            });
                        </script>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </nav>