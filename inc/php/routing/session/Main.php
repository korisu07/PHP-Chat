<?php declare(strict_types=1);

namespace Routing\Session;

// セッションをスタート
session_start();

// セッションの初期設定と基本機能を実装するクラス
abstract class Main{
  
  // タイムスタンプ
  protected int $timestamp;

  // 初期設定されるセッション
  private array $firstSession;

  // 後から更新されるセッション
  protected array $customSession;

  // エラーメッセージをセッション内に設定
  public function setErrorMessage(string $message):void
  {
    $_SESSION['data']['error_message'] = $message;
    
  } //end func errorMessage.

}