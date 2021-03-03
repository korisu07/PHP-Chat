<?php declare(strict_types=1);

require_once dirname(__FILE__) . '/inc/php/routing/session/firstSession.php';
require_once dirname(__FILE__) . '/inc/php/routing/trait/CheckWord.php';
require_once dirname(__FILE__) . '/inc/php/routing/post/SendMessage.php';

use Routing\Session\FirstSession;
use RoutingTrait\CheckWord;
use Routing\Post\SendMessage;

// セッションが設定されていない場合に、初期のセッションを設定
if( is_null($_SESSION['data']) ){
  $firstSession = new FirstSession();
  $firstSession->setFirstSession();
} //end if,set $_SESSION['data'].

///////////////////////////////////////////////////////

// テスト用
// 本来は、ここに$_POST['user_name']の値が入る
// $_SESSION['data']['name'] = 'test_user';
$userName = $_SESSION['data']['name'];
// 本来は、ここに$_POST['chat_message']の値が入る
$messege = 'message test is OK.';


///////////////////////////////////////////////////////

// ユーザー名の再チェック
// NGワードが含まれていないかをチェック
$checkWord = new CheckWord($userName, $ng_words, 'system');
// 返り値がtrueなら投稿可能
$bool = $checkWord->checkBool();

///////////////////////////////////////////////////////

// ユーザー名がOKならメッセージの判定へ
if( $bool ){
  // NGワードが含まれていないかをチェック
  $checkWord = new CheckWord($messege, $ng_words);
  // 返り値がtrueなら投稿可能
  $bool = $checkWord->checkBool();
}

$sendMessage = new SendMessage( $bool, $_SERVER['REQUEST_TIME'] );
// セッションのタイムスタンプを更新
$sendMessage->setSession();
// SQLにメッセージを送信
$sendMessage->sendChatLog( $messege, $pdo );

// $messageの判定チェック
echo '$messageの判定結果は';
if( $bool ){
  echo '「登録可能」';
} else if ( !$bool ) {
  echo '「登録不可」';
}
echo 'です。<br>';

// エラーメッセージが設定されている場合、表示する
if( isset($_SESSION['data']['error_message']) && $_SESSION['data']['error_message'] !== '' ){
  echo $_SESSION['data']['error_message'];
}

// 名前が設定されている場合、表示する
if( $bool && isset($_SESSION['data']['name']) ){
  echo '名前は「', htmlspecialchars($_SESSION['data']['name']), '」です。';
}

// 名前が設定されている場合、表示する
if( $bool && isset($messege) ){
  echo 'メッセージは「', htmlspecialchars($messege), '」です。';
}
