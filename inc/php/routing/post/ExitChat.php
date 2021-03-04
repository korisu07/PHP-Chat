<?php declare(strict_types=1);

namespace Routing\Post;

require_once dirname(__FILE__) . '/interface/PostMethod.php';
require_once dirname(__FILE__) . '/../session/Update.php';

class ExitChat extends \Routing\Session\Update implements PostMethod
{
  // ユーザー名
  private string $userName;

  // 連投判定
  // 判定用クラスから判定結果を受け渡す
  // falseであればNGワードが入っている
  // nullのままの場合は、なにかしらの原因で判定に失敗している
  private $checkBool;

  // __construct
  public function __construct( $boolReload ){
    // 判定結果を格納
    $this->checkBool = $boolReload;
  } //end __construct.

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

    // 判定がOKの場合、退室の処理をする
    if ( $this->checkBool === true ){
      // SQLに接続
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
      
    } else if( $this->checkBool === null ) { // なにかしらのエラーで、ワードがうまく判定されなかった場合

      // なにかしらのエラーで、かつエラーメッセージが入っていない場合
      if( isset($_SESSION['data']['error_message']) && $_SESSION['data']['error_message'] === ''){
        $this->setErrorMessage('エラー！発言できませんでした。しばらく経ってからお試しください。');
      } //end if, Error occurred and error messsage is empty.

      return;

    } //end if SQL.

  } //end func sendChatLog.
} //end class ExitChat.