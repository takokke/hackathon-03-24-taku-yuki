<?php
$mysqli = new mysqli('database-1.cvqe24uooolq.ap-northeast-1.rds.amazonaws.com','root','OkaTaku0415','test','3306');
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
?>

