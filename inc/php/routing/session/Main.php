<?php declare(strict_types=1);

namespace Routing\Session;

abstract class Main{
  
  private string $timeStamp;

  private array $firstSession;

  private array $customSession;

  // __construct
  public function __construct(int $time){ // インスタンス化するときに $_SERVER['REQUEST_TIME']を指定する
    $this->setFirstSession( $time );
  } //end __construct.

  // 初回アクセス時のセッションを設定
  // インスタンス化したタイミングで発動
  private function setFirstSession(int $time):void
  {
    $this->timeStamp = date('Y-m-d G:i:s', $time);

    // セッションの初期設定
    $this->firstSession = [
      'name' => '',
      'random_id' => '',
      'time_stamp' => $this->timeStamp,
      'error_message' => ''
    ];

    $_SESSION['data'] = $this->firstSession;
  } //end func setFirstSession.

  // エラーメッセージをセッション内に設定
  public function errorMessage(string $message):void
  {
    $_SESSION['data']['error_message'] = $message;
  } //end func errorMessage.

  // 入室するときにセッションにユーザー名をセットする
  public function loginSessionRouting(string $name, int $time):void
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
  public function setTimeStampSession(int $time):void
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