<?php declare(strict_types=1);
header('Location: /');

require_once dirname(__FILE__) . '/../inc/php/routing/trait/CheckWord.php';
require_once dirname(__FILE__) . '/../inc/php/routing/post/SendMessage.php';

use RoutingTrait\CheckWord;
use Routing\Post\SendMessage;

///////////////////////////////////////////////////////

// ユーザー名
$userName = $_SESSION['data']['name'];
// ユーザーが発言したい内容
$messege = $_POST['chat_message'];

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
  $boolWord = $checkWord->checkBool();
}

///////////////////////////////////////////////////////

// 前回の通信リクエストから1秒経過しているかを判定
$boolReload = $checkReload->JudgeRepeatedHits( $_SERVER['REQUEST_TIME'], '+10 second' );

// NGワードの判定とリクエストの判定を受け渡して、インスタンス化
$sendMessage = new SendMessage( $boolWord, $boolReload );
// 送信したいメッセージを登録
$sendMessage->sendChatLog( $messege, $pdo );

// 連投されていた場合
if( $boolReload === false && $_SESSION['data']['error_message'] === '' ) {
  // セッションにエラーメッセージをセット
  $checkReload->setErrorMessage('連投はできません。少々お待ち下さい。');
}

///////////////////////////////////////////////////////