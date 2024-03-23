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

$route = [
    [
        'method' => 'GET',
        'url'=> '/sign_up',
        'controller_action'=> 'RegistrationsController#new',
    ],
    [
        'method' => 'POST',
        'url'=> '/sign_up',
        'controller_action'=> 'RegistrationsController#create',
    ],
    [
        'method' => 'GET',
        'url'=> '/sign_in',
        'controller_action'=> 'SessionsController#new',
    ],
    [
        'method' => 'POST',
        'url'=> '/sign_in',
        'controller_action'=> 'SessionsController#create',
    ],
    [
        'method' => 'GET',
        'url'=> '/user',
        'controller_action'=> 'SessionsController#show',
    ],
    [
        'method' => 'POST',
        'url'=> '/sign_out',
        'controller_action'=> 'SessionsController#destroy',
    ],
    [
        'method' => 'GET',
        'url'=> '/hairs',
        'controller_action'=> 'HairsController#index',
    ],
    [
        'method' => 'GET',
        'url'=> '/hairs/new',
        'controller_action'=> 'HairsController#new',
    ],
    [
        'method' => 'POST',
        'url'=> '/hairs/create',
        'controller_action'=> 'HairsController#create',
    ],
    [
        'method' => 'GET',
        'url'=> '/hairs/edit',
        'controller_action'=> 'HairsController#edit',
    ],
    [
        'method' => 'POST',
        'url'=> '/hairs/update',
	'controller_action'=> 'HairsController#update',
    ]
];
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// ルートの検索
$matched_route = null;
foreach ($route as $route_item) {
    if ($route_item['method'] === $request_method && $route_item['url'] === $request_uri) {
        $matched_route = $route_item;
        break;
    }
}


// マッチしたルートがあるかどうかを確認し、対応するファイルを含めるか404エラーを返す
if ($matched_route !== null) {

    $controllerAction = $matched_route['controller_action'];
    list($controller, $action) = explode('#', $controllerAction);
    // ファイルを呼び出す
    include_once("./controllers/".$controller.".php");
    // コントローラのインスタンスを生成
    $controllerInstance = new $controller();
    // アクションを呼び出す
    $controllerInstance->$action();
} else {
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
}

