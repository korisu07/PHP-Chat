<?php declare(strict_types=1);

namespace Routing\Session;

require_once dirname(__FILE__) . '/Main.php';

// ログイン時のセッション更新と、タイムスタンプ更新の処理を行うクラス
abstract class Update extends Routing\Session\Main{

  // 入室するときにセッションにユーザー名をセットする
  public function setLoginSession(string $name, int $time):void
  {
    $this->timeStamp = date('Y-m-d G:i:s', $time);

    // ランダムIDが必要になった場合、ここに関数を設定
    $random_id = '';

    $this->customSession = [
      'name' => $name,
      'random_id' => $random_id,
      'time_stamp' => $this->timeStamp,
      'error_message' => ''
    ];

    $_SESSION['data'] = $this->customSession;
  } //end func loginSessionRouting.

  // タイムスタンプの記録のみを更新する関数
  public function updateTimeStampSession(int $time):void
  {
    $this->timeStamp = date('Y-m-d G:i:s', $time);

    $this->customSession = [
      'name' => $this->customSession['name'],
      'random_id' => $this->customSession['random_id'],
      'time_stamp' => $this->timeStamp,
      'error_message' => ''
    ];

    $_SESSION['data'] = $this->customSession;
  } //end func setTimeStampSession.

}