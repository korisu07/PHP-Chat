<?php declare(strict_types=1);

require_once dirname(__FILE__) . '/inc/php/routing/session/firstSession.php';
require_once dirname(__FILE__) . '/inc/php/routing/post/LoginChat.php';
require_once dirname(__FILE__) . '/inc/php/routing/trait/CheckWord.php';

use Routing\Post\LoginChat;
use Routing\Session\FirstSession;
use RoutingTrait\CheckWord;

// セッションが設定されていない場合に、初期のセッションを設定
if( is_null($_SESSION['data']) ){
  $firstSession = new FirstSession();
  $firstSession->setFirstSession();
} //end if,set $_SESSION['data'].

///////////////////////////////////////////////////////

// 名前登録のテスト用
// 本来は、ここに$_POST['user_name']の値が入る
$userName = '';

///////////////////////////////////////////////////////

// NGワードが含まれていないかをチェック
$checkWord = new CheckWord($userName, $ng_words, 'system');

// 返り値がtrueなら投稿可能
$bool = $checkWord->checkBool();

// ログイン処理
$loginChat = new LoginChat( $bool, $_SERVER['REQUEST_TIME']);
// ユーザー名をセッションにセット
$loginChat->setSession( $userName );
// SQLへの送信
$loginChat->sendChatLog($userName, $pdo);

// $userNameの判定チェック
echo '$userNameの判定結果は';
if( $bool ){
  echo '「登録可能」';
} else if ( !$bool ) {
  echo '「登録不可」';
}
echo 'です。';

// エラーメッセージが設定されている場合、表示する
if( isset($_SESSION['data']['error_message']) && $_SESSION['data']['error_message'] !== '' ){
  echo $_SESSION['data']['error_message'];
}

// 名前が設定されている場合、表示する
if( isset($_SESSION['data']['name']) ){
  echo '名前は：', htmlspecialchars($_SESSION['data']['name']), 'です。';
}