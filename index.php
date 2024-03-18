<?php

// 自動で読み込み
require './vendor/autoload.php';

// .envを使用する
Dotenv\Dotenv::createImmutable(__DIR__)->load();

$host = $_ENV['HOST'];
$password = $_ENV['PASSWORD'];
$database = $_ENV['DATABASE'];
$port = $_ENV['PORT'];

$mysqli = new mysqli($host,'root',$password,$database,$port);
//接続状況の確認
if($mysqli->connect_error){
	echo $mysqli->connect_error;
	exit();
}else{
	$mysqli->set_charset("utf8");
        echo 'データベース接続成功'; 
}
// 切断
$mysqli->close();

