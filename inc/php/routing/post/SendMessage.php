<?php declare(strict_types=1);

namespace Routing\Post;

require_once dirname(__FILE__) . '/../session/Update.php';
require_once dirname(__FILE__) . '/interface/PostMethod.php';

class SendMessage extends \Routing\Session\Update implements PostMethod
{
  // メッセージの内容
  private string $messege;

  // NGワードチェックの結果
  // class CheckWordから判定結果を受け渡す
  // falseであればNGワードが入っている
  private $checkBool;

  public function __construct($bool, int $time){
    $this->checkBool = $bool;
    $this->timestamp = $time;
  } //end __construct.

  // セッションをセットする
  public function setSession(string $str = null):void
  {
    $this->updateTimeStampSession($this->timestamp);
  } //end func setSession.

  // 表示したいログをSQLに登録する
  public function sendChatLog(string $str, $pdo):void
  {
    // メッセージ
    $this->messege = $str;

    if( $this->checkBool === true ) { // チェックがOKの場合

      // SQLに接続
      try {
        $statement = $pdo->prepare('INSERT INTO chat_logs(`user_name`, `message`) VALUES(:user_name, :chat_message)');

        $user_name = (string) $_SESSION['data']['name'];
  
        $statement->bindValue(':user_name', $user_name, \PDO::PARAM_STR);
        $statement->bindValue(':chat_message', $this->messege, \PDO::PARAM_STR);
  
        $statement->execute();
      } catch (PDOException $e) {
        // エラーを受け取った場合、エラーメッセージをセッション内に登録
        $this->setErrorMessage('エラー！発言できませんでした。しばらく経ってからお試しください。');
      } //end try~catch.

    } else if( $this->checkBool === null ) { // なにかしらのエラーで、ワードがうまく判定されなかった場合

      // なにかしらのエラーで、かつエラーメッセージが入っていない場合
      if( isset($_SESSION['data']['error_message']) && $_SESSION['data']['error_message'] === ''){
        $this->setErrorMessage('エラー！発言できませんでした。しばらく経ってからお試しください。');
      } //end if, Error occurred and error messsage is empty.

      return;

    } //end if SQL.

  } //end func sendChatLog.
} //end class SendMessage.