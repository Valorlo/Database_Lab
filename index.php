<?php
	$host = "localhost";
	$user = "root";
	$passwd = "root";
	$database = 'library_system';
	$connect = new mysqli($host, $user, $passwd, $database);
	if ($connect->connect_error){
		die("連線資料庫失敗: " . $connect->connect_error);
	}else{
		echo "連線資料庫成功";
	}
?>