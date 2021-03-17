<?php declare(strict_types=1);
header('Location: /');

require_once dirname(__FILE__) . '/../inc/php/routing/trait/CheckWord.php';
require_once dirname(__FILE__) . '/../inc/php/routing/post/LoginChat.php';

use RoutingTrait\CheckWord;
use Routing\Post\LoginChat;

///////////////////////////////////////////////////////

// ユーザー名
$userName = $_POST['user_name'];

///////////////////////////////////////////////////////

// NGワードが含まれていないかをチェック
$checkWord = new CheckWord($userName, $ng_words, 'system');
// 返り値がtrueなら投稿可能
$boolWord = $checkWord->checkBool();

///////////////////////////////////////////////////////

// 前回の通信リクエストから1秒経過しているかを判定
$boolReload = $checkReload->JudgeRepeatedHits( $_SERVER['REQUEST_TIME'], '+10 second' );

// NGワードの判定とリクエストの判定を受け渡して、インスタンス化
$loginChat = new LoginChat( $boolWord, $boolReload );
// 送信したいメッセージを登録
$loginChat->sendChatLog( $userName, $pdo );

// 連投されていた場合
if( $boolReload === false && $_SESSION['data']['error_message'] === '' ) {
  // セッションにエラーメッセージをセット
  $checkReload->setErrorMessage('連投はできません。少々お待ち下さい。');
}


///////////////////////////////////////////////////////