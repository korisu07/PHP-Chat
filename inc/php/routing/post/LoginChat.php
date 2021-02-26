<?php declare(strict_types=1);

namespace Routing\Post;

require_once dirname(__FILE__) . '/interface/PostMethod.php';
require_once dirname(__FILE__) . '/../session/Update.php';

class LoginChat extends \Routing\Session\Update implements PostMethod
{
  // ユーザー名
  private string $userName;

  // NGワードチェックの結果
  // falseであればNGワードが入っている
  private bool $checkBool;

  public function __construct(bool $bool){
    $this->checkBool = $bool;
  }

  // セッションをセットする
  public function setSession(string $name, int $time)
  {
    $this->setLoginSession($name, $time);
  }

  // SQLに接続する
  public function connectSQL(): void
  {
    // SQLに接続する処理
    try{
      // SQLに接続
      $pdo = new PDO($connect_db, $connect_user, $connect_pass);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

      // トップページに移動
      header('Location: /', 307);

    } catch (PDOException $e){
      echo '接続に失敗しました。しばらく経ってからお試しください。' , '<br>';
      return;
    } //end try ~ catch.

  }

  // 表示したいログをSQLに登録する
  public function sendChatLog(string $str)
  {
    // チェックがNGの場合
    if( $this->checkBool === false){
      $this->setErrorMessage('禁止ワードが含まれています。');
    } else { // チェックがOKの場合
      $this->connectSQL();
      echo 'OK';
    } //end if.

  }

}