<?php declare(strict_types=1);

namespace Routing\Post;

require_once dirname(__FILE__) . '/../session/Update.php';
require_once dirname(__FILE__) . '/interface/PostMethod.php';

class SendMessage extends \Routing\Session\Update implements PostMethod
{
  public function __construct(int $time){
    $this->timestamp = $time;
  }

  // セッションをセットする
  public function setSession(string $str = null):void
  {
    $this->updateTimeStampSession($this->time);
  }

  // 表示したいログをSQLに登録する
  public function sendChatLog(string $str):void
  {

  }
}