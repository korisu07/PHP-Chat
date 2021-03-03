<?php declare(strict_types=1);

namespace Routing\Session;

require_once dirname(__FILE__) . '/Update.php';

class FirstSession extends Update{
  // 初回アクセス時のセッションを設定
  public function setFirstSession():void
  {
    $this->timestamp = date('Y-m-d G:i:s', $_SERVER['REQUEST_TIME']);

    // セッションの初期設定
    $this->firstSession = [
      'name' => '',
      'random_id' => '',
      'time_stamp' => $this->timestamp,
      'error_message' => ''
    ];

    $_SESSION['data'] = $this->firstSession;
  } //end func setFirstSession.
}