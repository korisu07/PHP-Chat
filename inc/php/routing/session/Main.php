<?php declare(strict_types=1);

namespace Routing\Session;

// セッションの初期設定と基本機能を実装するクラス
abstract class Main{
  
  // タイムスタンプ
  protected string $timeStamp;

  // 初期設定されるセッション
  private array $firstSession;

  // 後から更新されるセッション
  protected array $customSession;

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
  public function setErrorMessage(string $message):void
  {
    $_SESSION['data']['error_message'] = $message;
  } //end func errorMessage.

  abstract function setLoginSession();

  abstract function updateTimeStampSession();

}