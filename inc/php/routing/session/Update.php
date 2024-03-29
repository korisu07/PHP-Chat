<?php declare(strict_types=1);

namespace Routing\Session;

require_once dirname(__FILE__) . '/Main.php';

// ログイン時のセッション更新と、タイムスタンプ更新の処理を行うクラス
abstract class Update extends Main{

  // 入室するときにセッションにユーザー名をセットする
  protected function setLoginSession(string $name):void
  {
    // ランダムIDが必要になった場合、ここに関数を設定
    $random_id = '';

    $this->customSession = [
      'name' => $name,
      'random_id' => $random_id,
      'time_stamp' => $_SESSION['data']['time_stamp'],
      'error_message' => $_SESSION['data']['error_message'],
      'first_action' => 'false'
    ];

    // セッションを更新
    $_SESSION['data'] = $this->customSession;
  } //end func loginSessionRouting.

  // タイムスタンプの記録のみを更新する関数
  protected function updateTimeStampSession(int $time):void
  {
    // 時刻を登録
    $this->timestamp = $time;
    // セッションにタイムスタンプを登録
    $_SESSION['data']['time_stamp'] = $this->timestamp;
    $_SESSION['data']['first_action'] = 'false';
    
  } //end func setTimeStampSession.
} //end abstract class Update.