<?php declare(strict_types=1);

namespace Routing\Post;

require_once dirname(__FILE__) . '/../setSession/Main.php';
require_once dirname(__FILE__) . '/interface/PostMethod.php';


class LoginChat extends session\Main implements PostMethod
{
  // セッションをセットする
  public function setSession()
  {
    
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