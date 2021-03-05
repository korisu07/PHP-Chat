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
  public function __construct(){

    // ユーザー名が設定されているとき
    if( isset( $_SESSION['data']['name'] ) && $_SESSION['data']['name'] !== '' ){

      $this->checkSetUserName = true;
      $this->setUserName = $_SESSION['data']['name'];

    } else { // ユーザー名が設定されていないとき 

      $this->checkSetUserName = false;

    } // end if userName.

    //////////////////////////////////////////////////////////////

    // ログインするためのフォーム
    $this->loginForm = '

    <form action="./routing/user_name_routing.php" method="post" class="chat_post" id="user_name">
      <div class="header_box">
        <label for="user_name">ユーザー名：</label>
        <input type="text" name="user_name" id="chat" maxlength="20" form="user_name">
      </div>

      <input type="submit" value="入室する" for="user_name" form="user_name">
    </form>';

    //////////////////////////////////////////////////////////////

    // チャットで発言するためのフォーム
    $this->chatForm = '

    <form action="./routing/user_message_routing.php" method="post" class="chat_post" id="chat_message">
      <div class="header_box">
        <label for="chat_message">メッセージ：</label>
        <input type="text" name="chat_message" id="chat" maxlength="200" form="chat_message">
      </div>

      <input type="submit" value="発言する" for="chat_message" form="chat_message">
    </form>';
    
    //////////////////////////////////////////////////////////////

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

      echo $this->chatForm;

      echo '<div class="chat_user">';
      echo $this->logoutForm;
      // ここに入室者一覧の処理
      // echo $this->userList
      echo '</div>';

    } else { // 入室していないときに表示

      echo $this->loginForm;

    } // end if echoForm.
  } // end func loadTextarea.

} // end class header.