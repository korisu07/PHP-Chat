<?php 

class header {

  // ログインフォーム
  private string $loginForm;

  // 入室しているときに表示される発言フォーム
  private string $chatForm;

  // ログアウトフォーム
  // ユーザー自身の名前もここで表示される
  private string $logoutForm;

  // ログイン中のユーザー名
  private string $setUserName;

  // 入室者一覧
  private string $userList;

  // ユーザー名が設定されているかをチェック
  // trueなら設定されている状態。初期状態はfalse
  private bool $checkSetUserName = false;

  // construnct
  public function __construct( $userName = null ){

    // ユーザー名が設定されているとき
    if( isset( $userName ) && $userName !== '' ){

      $this->checkSetUserName = true;
      $this->setUserName = $userName;

    } else { // ユーザー名が設定されていないとき 

      $this->checkSetUserName = false;

    } // end if userName.

    // ログインするためのフォーム
    // パスはこのファイルから数えたフルパス
    $this->loginForm = dirname(__FILE__) . '\inc_header\loginForm.php';

    // チャットで発言するためのフォーム
    $this->chatForm = dirname(__FILE__) . '\inc_header\chatForm.php';

    // session内にユーザー名が設定されているときに設定
    if( $this->checkSetUserName ){

      // ログアウトフォームをセット
      $this->logoutForm = 
      
      // 入室中であるときに表示されるユーザー名
      '<p>' . htmlspecialchars( $this->setUserName ) . '　さんとして入室中</p>' . 

      // ログアウトフォーム
      '<form action="./routing/chat_exit.php" method="post">
        <input type="submit" name="chat_exit" id="chat_exit" value="退室する">
      </form>';

    } // end if set ssession,view username.

  } // end __construct.

  public function loadTextarea():void
  {
    // ログイン中の場合に表示
    if( $this->checkSetUserName ){

      include $this->chatForm;

      echo '<div class="chat_user">';
      echo $this->logoutForm;
      // ここに入室者一覧の処理
      // echo $this->userList
      echo '</div>';

    } else { // 入室していないときに表示

      include $this->loginForm;

    } // end if echoForm.
  } // end func loadTextarea.

} // end class header.