<?php declare(strict_types=1);

namespace Routing\Post;

require_once dirname(__FILE__) . '/interface/PostMethod.php';
require_once dirname(__FILE__) . '/../session/Update.php';

class ExitChat extends \Routing\Session\Update implements PostMethod
{
  // ユーザー名
  private string $userName;


  // ログアウト処理の際、セッションをリセットさせる
  public function resetSession(int $time):void
  {
    $_SESSION['data']['name'] = '';
    $_SESSION['data']['random_id'] = '';
    $_SESSION['data']['time_stamp'] = $time;
  } //end func setSession.

  
  // 表示したいログをSQLに登録する
  public function sendChatLog(string $str, $pdo):void
  {
    // ユーザー名
    $this->userName = $str;

    // 退室の処理をする
    // SQLに接続し、退室のログを表示する。
    try{
      $statement = $pdo->prepare('INSERT INTO chat_logs(`user_name`, `message`) VALUES(:system_name, :log_message)');

      // ログに登録するメッセージを設定
      $message = $this->userName . ' さんが退室しました。';
  
      // SQLに内容を埋め込み
      $statement->bindValue(':system_name', 'system', \PDO::PARAM_STR);
      $statement->bindValue(':log_message', $message, \PDO::PARAM_STR);

      // 値の受け渡しを実行
      $statement->execute();
      // SQLへの接続を終了
      unset( $statement );
      
      // エラーメッセージをリセット
      $this->setErrorMessage('');
      // セッションをリセットし、タイムスタンプを更新
      $this->resetSession( $_SERVER['REQUEST_TIME'] );

    } catch (PDOException $e){
      // エラーを受け取った場合、エラーメッセージをセッション内に登録
      $this->setErrorMessage('エラー！チャットから退室できませんでした。しばらく経ってからお試しください。');
    } //end try~catch.
      

  } //end func sendChatLog.
} //end class ExitChat.