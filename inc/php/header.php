
  <?php include dirname(__FILE__) . '/connect/connect.php'; ?>

  <form action="/" method="post" class="chat_post">

    <?php 
    
    // 名前が登録されていない場合
    if(!isset($_COOKIE[session_name()])){
      echo '
      <div class="header_box">
        <label for="user_name">ユーザー名：</label>
        <input type="text" name="user_name" id="chat" maxlength="20">
      </div>

      <input type="submit" value="入室する">
      ';
    }
    // 名前が登録されている場合
    else{
      echo 
      '<div class="header_box">
        <label for="chat_message">メッセージ：</label>
        <input type="text" name="chat_message" id="chat" maxlength="200">
      </div>

      <input type="submit" value="発言する">
      ';
    }
    
    ?>
  </form>

  <div class="chat_user">

    <?php 

      try{
        // ログイン中のユーザーを表示
        $user_list = $pdo->prepare('SELECT login_user FROM login_user');
        $user_list->execute();
      } catch(PDOException $e){
        echo 'ユーザー 一覧の表示に失敗しました。';
      }

    ?>

    <span>入室中：</span>
    <?php while ($log_value = $user_list->fetch(PDO::FETCH_ASSOC)): ?>
      <span><?= text_escape($log_value['login_user']);?> さん ★ </span>
    <?php endwhile; ?>

    <?php
      if(isset($_COOKIE[session_name()])){
        session_start();
        echo '<p>' . htmlspecialchars($_SESSION['data']['name']) . '　さんとして入室中</p>' .
      
        '<form action="/" method="post">
          <input type="submit" name="chat_exit" id="chat_exit" value="退室する">
        </form>';
      }
  ?>
  

  </div>
</div>
