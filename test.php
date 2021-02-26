<?php 

require_once dirname(__FILE__) . '/inc/php/routing/post/LoginChat.php';
require_once dirname(__FILE__) . '/inc/php/routing/trait/CheckWord.php';

use Routing\Post\LoginChat;
use RoutingTrait\CheckWord;

$userName = 'user_name01';

$checkWord = new CheckWord();
$bool = $checkWord->checkBool($userName, $ng_words, 'system');

echo '$userNameの判定結果は', var_dump( $bool ), 'です。';

// $loginChat = new LoginChat( $bool );
// $loginChat->setSession('user01', $_SERVER['REQUEST_TIME']);

// $loginChat->sendChatLog('user01');