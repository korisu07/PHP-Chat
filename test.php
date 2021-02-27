<?php declare(strict_types=1);

require_once dirname(__FILE__) . '/inc/php/routing/session/firstSession.php';
require_once dirname(__FILE__) . '/inc/php/routing/post/LoginChat.php';
require_once dirname(__FILE__) . '/inc/php/routing/trait/CheckWord.php';

use Routing\Post\LoginChat;
use Routing\Session\FirstSession;
use RoutingTrait\CheckWord;

if( is_null($_SESSION['data']) ){
  $firstSession = new FirstSession();
  $firstSession->setFirstSession();
} //end if.

$_SESSION['data']['name'] = ' ';

$userName = $_SESSION['data']['name'];

$checkWord = new CheckWord($userName, $ng_words, 'system');
// セッションが設定されていない場合に、初期のセッションを設定

$bool = $checkWord->checkBool();

$loginChat = new LoginChat( $bool, $_SERVER['REQUEST_TIME']);
$loginChat->setSession($userName);

$loginChat->sendChatLog($userName, $pdo);

echo '$userNameの判定結果は';
if( $bool ){
  echo '「登録可能」';
} else if ( !$bool ) {
  echo '「登録不可」';
}
echo 'です。';

if( isset($_SESSION['data']['error_message']) && $_SESSION['data']['error_message'] !== '' ){
  echo $_SESSION['data']['error_message'];
}

if( isset($_SESSION['data']['name']) ){
  echo '名前は：', htmlspecialchars($_SESSION['data']['name']), 'です。';
}