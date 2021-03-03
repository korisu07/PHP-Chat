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
$bool = $checkWord->checkBool();

///////////////////////////////////////////////////////

// ログイン処理
$loginChat = new LoginChat( $bool, $_SERVER['REQUEST_TIME'] );
// ユーザー名をセッションにセット
$loginChat->setSession( $userName );

// ここに連打判定の処理を追加
$accessBool = null;

// SQLへの送信
$loginChat->sendChatLog( $userName, $pdo );

///////////////////////////////////////////////////////