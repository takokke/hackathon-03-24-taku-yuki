<?php
class PokemonController {
	public function show() {
		$this->authenticate_admin_user();
		
        	//MySQLに接続
        	$mysqli = new mysqli($_ENV['HOST'], 'root', $_ENV['PASSWORD'], $_ENV['DATABASE'], $_ENV['PORT']);
        	if($mysqli->connect_error){
          		echo $mysqli->connect_error;
          		exit();
        	} else {
          		$mysqli->set_charset('utf8');	
		};
        	$stmt = "SELECT cut_date FROM trx_cut_dates WHERE `user_id` = ? ORDER  BY created_at DESC LIMIT 1";
		$stmt->bind_param("i", $_SESSION['user_id']);
		$stmt->execute();
		$stmt->bind_result($cut_date);
		require("../views/Pokemon/show.php")
        	$stmt->close();
		$mysqli->close();
	}

	public function update(){
                $mysqli = new mysqli($_ENV['HOST'], 'root', $_ENV['PASSWORD'], $_ENV['DATABASE'], $_ENV['PORT']);
                if($mysqli->connect_error){
                        echo $mysqli->connect_error;
                        exit();
                } else {
                        $mysqli->set_charset('utf8');
                };
                $stmt = "INSERT INTO trx_cut_dates(`cut_date`, `user_id`) VALUES(?, ?)";
                $stmt->bind_param("si", $_POST['cutdate'],$_SESSION['user_id']);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
		header('Location: http://52.197.59.72/pokemon');
	}

    	// プライベートメソッド
   	private function authenticate_admin_user() {
        	session_start();
        	if(!isset($_SESSION['user_id'])) {
            		header('Location: http://52.197.59.72/sign_in');
        	}
    	}

}

