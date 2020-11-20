
  <?php include dirname(__FILE__) . '/connect/connect.php'; ?>

  <form action="/" method="post" class="chat_post">

    <?php if(!isset($_COOKIE['Your_name'])){
      echo '
      <div class="header_box">
        <label for="user_name">ユーザー名：</label>
        <input type="text" name="user_name" id="chat" maxlength="20">
      </div>

      <input type="submit" value="入室する">
      ';
    }
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
        function user_list($log_value){
          return htmlspecialchars(strval($log_value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
      try{
        // ログイン中のユーザーを表示
        $user_list = $pdo->prepare('SELECT login_user FROM login_user');
        $user_list->execute();
      } catch(PDOException $e){
        echo 'ユーザー 一覧の表示に失敗しました。';
      }

      // ログをページ上に表示するための関数
      function view($log_value){
        return htmlspecialchars(strval($log_value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
      }
    ?>

    <span>入室中：</span>
    <?php while ($log_value = $user_list->fetch(PDO::FETCH_ASSOC)): ?>
      <span><?= view($log_value['login_user']); ?>　さん</span>
    <?php endwhile; ?>

    <?php 
      if(isset($_COOKIE['Your_name'])){
        echo '<p>' . htmlspecialchars($_COOKIE['Your_name']) . '　さんとして入室中</p>' .
      
        '<form action="/" method="post">
          <input type="submit" name="chat_exit" id="chat_exit" value="退室する">
        </form>';
      }
  ?>
  

  </div>
</div>
