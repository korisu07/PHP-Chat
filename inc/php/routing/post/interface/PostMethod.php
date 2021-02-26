<?php declare(strict_types=1);

namespace Routing\Post;

require_once dirname(__FILE__) . '/../../../connect/connect.php';

// POSTリクエストを行うクラスのインターフェース（最低限、実装するべき機能）
interface PostMethod{
  // セッションをセットする
  public function setSession(string $name, int $time);

  // SQLに接続する
  public function connectSQL();

  // 表示したいログをSQLに登録する
  public function sendChatLog(string $str);
}