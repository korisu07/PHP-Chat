<?php declare(strict_types=1);

namespace accessRouting\postMethod;

require_once dirname(__FILE__) . '/../setSession/setSession.php';
require_once dirname(__FILE__) . '/../interface/postMethod.php';


class sendMessage extends setSession implements postMethod
{
  // セッションをセットする
  public function setSession(){
    
  }

  // SQLに接続する
  public function connectSQL(){

  }

  // 表示したいログをSQLに登録する
  public function sendChatLog(){

 }
}