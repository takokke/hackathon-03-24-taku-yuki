<?php
class SessionsController {
    public function new() {
	session_start();
        // SESSION[user_id]に値入っていればログインしたとみなす
        if(isset($_SESSION['user_id'])) {
	    echo "ログインしています";
	} else {
            require('./views/sessions/new.php');
        }
    }

    public function create() {
        session_start();
        //MySQLに接続
        $mysqli = new mysqli($_ENV['HOST'], 'root', $_ENV['PASSWORD'], $_ENV['DATABASE'], $_ENV['PORT']);
        if($mysqli->connect_error){
          echo $mysqli->connect_error;
          exit();
        } else {
          $mysqli->set_charset('utf8');
        }
        if(isset($_SESSION['user_id'])) {
          // SESSION[user_id]に値入っていればログインしたとみなす
          header('Location: http://52.197.59.72');
          // exit();
        } else {
          if (!empty($_POST["email"]) && !empty($_POST["password"])) {
               // $_POST["email"]も$_POST["passwprd"]も入力されている
              // 値を受け取る
              $email = htmlspecialchars($_POST["email"], ENT_QUOTES, "UTF-8");
              $password = htmlspecialchars($_POST["password"], ENT_QUOTES, "UTF-8");
              // パスワードをハッシュ化
              $password_hash = hash("sha256", $password);
      
              $stmt = $mysqli->prepare("SELECT * FROM trx_users WHERE `email`=?;");
              $stmt->bind_param('s', $email);
              $stmt->execute();
              
              $stmt->bind_result($id, $email, $db_password);
              while ($stmt->fetch()) {
		      if ($db_password == $password_hash) {
                      	$_SESSION['user_email'] = $email;
                      	$_SESSION['user_id'] = $id;
                      	$stmt->close();
		      	$mysqli->close();
			if (headers_sent()) {
				die("リダイレクトに失敗しました。このリンクをクリックしてください: <a href='/pokemon'>トップへ</a>");
			} else {
				header('Location: http://52.197.59.72');
				exit();
			};
		      } else {
                      	$stmt->close();
		      	$mysqli->close();
		      	if (headers_sent()) {
				die("パスワードが違います。： <a href='/sign_in'>ログイン画面へ</a>");
		     	 } else {
				header('Location: http://52.197.59.72/sign_in');
		      		exit();
		      	};
                      };
              };
          }
        }
        $mysqli->close();
        echo "<a href='/sign_in'>ログイン失敗</a>";
    }

    public function destroy() {
        session_start();
        if (isset($_POST["sign_out"])) {
            if(isset($_SESSION['user_id'])) {
                $_SESSION = array();
		session_destroy();
		if (headers_sent()) {
			die("リダイレクトに失敗しました。: <a href='/sign_in'>ログイン画面へ</a>");
		}else{
			header('Location: http://52.197.59.72/sign_in');
			exit();
		}
            } else {
                echo "<a href='/sign_in'>ログインしていません</a>";
            }
        }
    }
}
