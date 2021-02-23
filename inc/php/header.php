<?php 

class header {

  // 入室していないときに表示するログインフォーム
  private string $loginForm;

  // 入室しているときに表示される発言フォーム
  private string $chatForm;

  // 入室しているときに表示されるユーザー自身の名前
  private string $showUserName;

  // ログイン中のユーザー名
  private string $setUserName;

  // 入室者一覧
  private string $userList;

  // ユーザー名が設定されているかをチェック
  // trueなら設定されている状態。初期状態はfalse
  private bool $checkSetUserName = false;

  // construnct
  public function __construct( $userName = null ){

    // ユーザー名が設定されていないとき
    if( is_null( $userName ) || $userName === '' ){

      $this->checkSetUserName = false;

    } else { // ユーザー名が設定されているとき 

      $this->checkSetUserName = true;
      $this->setUserName = $userName;

    } // end if userName.

    // ログインするためのフォーム
    $this->loginForm = '
      <form action="./routing/user_name_routing.php" method="post" class="chat_post">
      <div class="header_box">
        <label for="user_name">ユーザー名：</label>
        <input type="text" name="user_name" id="chat" maxlength="20">
      </div>

      <input type="submit" value="入室する">
      </form>
    ';

    // チャットで発言するためのフォーム
    $this->chatForm = '
      <form action="./routing/user_message_routing.php" method="post" class="chat_post">
      <div class="header_box">
        <label for="chat_message">メッセージ：</label>
        <input type="text" name="chat_message" id="chat" maxlength="200">
      </div>

      <input type="submit" value="発言する">
      </form>
    ';

    if( $this->checkSetUserName ){
      // 入室中であるときに表示されるユーザー名
      $this->showUserName = '

        <p>' . htmlspecialchars( $this->setUserName ) . '　さんとして入室中</p>' .
          
        '<form action="./routing/chat_exit.php" method="post">
          <input type="submit" name="chat_exit" id="chat_exit" value="退室する">
        </form>
      </div>';
    } // end if userList.

  }

  public function loadTextarea():void
  {
    // ログイン中の場合に表示
    if( $this->checkSetUserName ){

      echo $this->chatForm;

      echo '<div class="chat_user">';
      echo $this->showUserName;
      // ここに入室者一覧の処理
      // echo $this->userList
      echo '</div>';

    } else { // ログアウト時に表示

      echo $this->loginForm;

    } // end if echoForm.

  } // end func loadTextarea.

} // end class header.