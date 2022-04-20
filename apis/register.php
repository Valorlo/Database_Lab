<?php
    require_once '../db.php';

    // 註冊資料
    $stdnum = $_POST["std"];
    $pwd = $_POST["pwd"];
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $id = $_POST["id"];
    $email = $_POST["email"];
    // 尋找帳號密碼
    $sql = "INSERT INTO borrower
    (stdnum, name, phonenum, id, type, email, password)
    VALUES
    ('$stdnum', '$name', '$phone', '$id', '0', '$email', MD5('$pwd'))
    ";

    // insert into return true or false
    $result = $connect->query($sql);

    // 如果成功
    if ($result) {
        echo true;
    } else {
        echo false;
    }
?>