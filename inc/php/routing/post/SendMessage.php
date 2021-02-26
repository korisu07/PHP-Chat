<?php declare(strict_types=1);

namespace Routing\Post;

require_once dirname(__FILE__) . '/../session/Update.php';
require_once dirname(__FILE__) . '/interface/PostMethod.php';

class SendMessage extends \Routing\Session\Update implements PostMethod
{
  // セッションをセットする
  public function setSession(int $time):void
  {
    $this->updateTimeStampSession($time);
  }

  // SQLに接続する
  public function connectSQL()
  {
  }

  // 表示したいログをSQLに登録する
  public function sendChatLog()
  {
    
 }
}