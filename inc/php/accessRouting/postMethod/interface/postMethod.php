<?php declare(strict_types=1);

// POSTリクエストを行うクラスの抽象メソッド
interface postMethod{
  // セッションをセットする
  public function setSession();

  // SQLに接続する
  public function connectSQL();

  // 表示したいログをSQLに登録する
  public function sendChatLog();
}