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
  $bool = $checkWord->checkBool();
}

///////////////////////////////////////////////////////

// 判定後の結果とリクエスト時間を受け渡してインスタンス化
$sendMessage = new SendMessage( $bool, $_SERVER['REQUEST_TIME'] );
// セッションのタイムスタンプを更新
$sendMessage->setSession();

// ここに連打判定の処理を追加
$accessBool = null;

// SQLにメッセージを送信
$sendMessage->sendChatLog( $messege, $pdo );

///////////////////////////////////////////////////////