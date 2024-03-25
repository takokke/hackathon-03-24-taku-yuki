<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>髪の毛チェックアプリ</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
        <script>
            document.addEventListener('DOMContentLoaded', () => {
            
            // ナビゲーションバーガー（navbar-burgerクラスを持つすべての要素）を取得します。
            const $navbarBurgers = document.querySelectorAll('.navbar-burger');
            
            // ナビゲーションバーガーがあるかどうかを確認します。
            if ($navbarBurgers.length > 0) {
            
                // すべてのナビゲーションバーガーをループします。
                $navbarBurgers.forEach( el => {
            
                // ナビゲーションバーガーにクリックイベントを追加します。
                el.addEventListener('click', () => {
            
                    // ナビゲーションバーガーのdata-target属性の値を取得します。
                    const target = el.dataset.target;
                    // メニュー（data-target属性の値をIDとして持つ要素）を取得します。
                    const $target = document.getElementById(target);
            
                    // ナビゲーションバーガーでis-activeクラスを切り替えます。
                    el.classList.toggle('is-active');
                    // メニューでis-activeクラスを切り替えます。
                    $target.classList.toggle('is-active');
            
                });
                });
            }
            });
        </script>
    </head>
    <body>
        <header>
            <nav class="navbar is-light" role="navigation" aria-label="main navigation">
                <div class="navbar-brand">
                    <a class="navbar-item " href="/">
                        <img src="/views/layouts/cutdate-min.svg">
                    </a>
                    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="targetMenu">
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </a>
                </div>
                <div id="targetMenu" class="navbar-menu">
                    <div class="navbar-start">
                        <a class="navbar-item" href="/">
                            <span class="icon-text has-text-link">
                                <span class="icon">
                                    <i class="fas fa-home"></i>
                                </span>
                                <span>ホーム</span>
                            </span>
                        </a>
                        <a class=" navbar-item" href="sign_up">
                            <span class="icon-text has-text-success">
                                <span class="icon">
                                    <i class="fas fa-home"></i>
                                </span>
                                <span>新規登録</span>
                            </span>
                        </a>
                    </div>
		    <div class="navbar-end">
			<?php if (!isset($_SESSION['user_id'])) {?>
                        <div class="navbar-item">
                            <a class="button is-primary is-outlined" href="sign_in">
                                <span class="icon">
                                    <i class="fas fa-sign-in-alt"></i>
                                </span>
                                <span>ログイン</span>
                            </a>
			</div>
			<?php } else { ?>
                        <div class="navbar-item">
                            <form action="/sign_out" method="post">
                                <button class="button is-danger is-outlined" type="submit" name="sign_out" value="send">
                                    <span class="icon">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </span>
                                    <span>ログアウト</span>
                                </button>
                            </form>
			</div>
			<?php } ?>    
                    </div>
                </div>
            </nav>
 	</header>
	<main class="my-6 py-6 mx-3" >
    	<div>
        	<?php
        	$today=new DateTime();
        	$strtoday=$today->format("Y-m-d");
        	if(!empty($cut_date)){
			$cutdate=new DateTime($cut_date);
			$diff=$cutdate->diff($today);
			$diff=$diff->days;
        	}else{
			echo "変数が空";
		}
       		if(isset($diff)){
            		if($diff<7){
                		$randpokenumber=array(350,700,730,282);
                		$key=array_rand($randpokenumber,1);
                		$pokenumber=$randpokenumber[$key];
            		}elseif($diff<14){
                		$randpokenumber=array(350,700);
                		$key=array_rand($randpokenumber,1);
                		$pokenumber=$randpokenumber[$key];
            		}elseif($diff>14){
                		$randpokenumber=array(88,110,109);
                		$key=array_rand($randpokenumber,1);
				$pokenumber=$randpokenumber[$key];
            		}
            	$urlname = "https://pokeapi.co/api/v2/pokemon-species/{$pokenumber}";
            	$urlimage="https://pokeapi.co/api/v2/pokemon/{$pokenumber}";

            	// jsonファイルを読みとる前の処理
            	function pokemonapiurljson($url){
                	$ch = curl_init(); // はじめ
                	//オプション
                	curl_setopt($ch, CURLOPT_URL, $url); 
                	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                	$file = curl_exec($ch);
                	curl_close($ch); //終了
			$file = json_decode($file);
                	return $file;
            	}
            	// ポケモンの日本語名が入ったjsonファイルを読み取る処理
            	function pokemonname($file){
                	$pokemonname=$file->names[0]->name;
                	return $pokemonname;
            	}
            	function pokemonimg($file){
                	$official_artwork="official-artwork";
                	$pokemonimage=$file->sprites->other->$official_artwork->front_default;
                	return $pokemonimage;
            	}
		$name=pokemonname(pokemonapiurljson($urlname));
		$image=pokemonimg(pokemonapiurljson($urlimage));
            	$number=1;
        }
        ?>
        <style>
            /* img{
                width: 30%;
                height: auto;
            } */
            .pokeimg img{
                width: 50%;
            }
        </style>

        <div class="box">

            <div class="box">
                <p class="title">現在の経過日数</p>
                <p class="is-size-3"><?php if(isset($diff)){echo "{$diff}日";}else{echo "";}?></p>
            </div>

            <div class="box">
                <form class="form" action="/pokemon" method="post" >
                    <p class="title">散髪日更新フォーム</p>
                    <div class="field mr-6">
                        <label class="label">日付</label>
                        <p class="control">
                            <input class="input is-info" type="date" name="cutdate" value="<?echo($strtoday);?>" max="<?echo($strtoday);?>"/>
                        </p>
                    </div>
                    <input type="submit" class="button is-primary" value="更新"/>
                </form>
            </div>
            
            <div class="box">
                <?php if(isset($diff)){ ?>
                    <p class="title">あなたの経過日数に応じたポケモンは…</p>
                    <div class="has-text-centered">
		    <img src="<?= $image?>" alt="ポケモンの画像">
                    </div>
                    <p class="title has-text-centered"><?= $name?>です</p>
                <?php } ?>
                <?php if(!isset($diff)){ ?>
                    <p class="title is-centered">散髪日を更新してみよう！</p>
                <?php }?>
            </div>
        </div>
    </div>
</main>
</html>
