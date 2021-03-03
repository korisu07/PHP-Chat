<?php declare(strict_types=1);

namespace Routing\Post;

require_once dirname(__FILE__) . '/interface/PostMethod.php';
require_once dirname(__FILE__) . '/../session/Update.php';

class LoginChat extends \Routing\Session\Update implements PostMethod
{
  // ユーザー名
  private string $userName;
  
  // NGワードチェックの結果
  // class CheckWordから判定結果を受け渡す
  // falseであればNGワードが入っている
  // nullのままの場合は、なにかしらの原因で判定に失敗している
  private $checkBool;

  // __construct
  public function __construct($bool, int $time){
    $this->checkBool = $bool;
    $this->timestamp = $time;
  } //end __construct.

  // セッションをセットする
  public function setSession(string $str):void
  {
    // 名前をセッションに登録する
    $this->setLoginSession($str, $this->timestamp);
  } //end func setSession.

  // 表示したいログをSQLに登録する
  public function sendChatLog(string $str, $pdo):void
  {
    // ユーザー名
    $this->userName = $str;
    
    if( $this->checkBool === true ) { // チェックがOKの場合

      // SQLに接続
      try{
        $statement = $pdo->prepare('INSERT INTO chat_logs(`user_name`, `message`) VALUES(:system_name, :log_message)');

        // ログに登録するメッセージを設定
        $log_message = $this->userName . 'さんが入室しました。';
  
        // SQLに内容を埋め込み
        $statement->bindValue(':system_name', 'system', \PDO::PARAM_STR);
        $statement->bindValue(':log_message', $log_message, \PDO::PARAM_STR);
    
        // 値の受け渡しを実行
        $statement->execute();

        // エラーメッセージをリセット
        $this->setErrorMessage('');
  
        // セッションを更新する
        $this->setSession( $this->userName );

        unset( $statement );

      } catch (PDOException $e){
        // エラーを受け取った場合、エラーメッセージをセッション内に登録
        $this->setErrorMessage('エラー！チャットに入室できませんでした。しばらく経ってからお試しください。');
      } //end try~catch.

    } else if( $this->checkBool === null ) { // なにかしらのエラーで、ワードがうまく判定されなかった場合

      // なにかしらのエラーで、かつエラーメッセージが入っていない場合
      if( isset($_SESSION['data']['error_message']) && $_SESSION['data']['error_message'] === ''){
        $this->setErrorMessage('エラー！チャットに入室できませんでした。しばらく経ってからお試しください。');
      } //end if, Error occurred and error messsage is empty.

      return;

    } //end if SQL.
  } //end func sendChatLog.

}//end class LoginChat.