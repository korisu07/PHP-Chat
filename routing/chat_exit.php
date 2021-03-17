<?php declare(strict_types=1);
header('Location: /');

require_once dirname(__FILE__) . '/../inc/php/routing/post/ExitChat.php';

use Routing\Post\ExitChat;

///////////////////////////////////////////////////////

// ユーザー名
$userName = $_SESSION['data']['name'];

///////////////////////////////////////////////////////

// 前回の通信リクエストから1秒経過しているかを判定
$boolReload = $checkReload->JudgeRepeatedHits( $_SERVER['REQUEST_TIME'], '+5 second' );

// ログアウト処理
$exitChat = new ExitChat( $boolReload );
$exitChat->sendChatLog( $userName, $pdo );

///////////////////////////////////////////////////////