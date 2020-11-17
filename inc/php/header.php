
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
      if(isset($_COOKIE['Your_name'])){
        echo '<p>' . $_COOKIE['Your_name'] . '　さんとして入室中</p>' .
      
        '<form action="/" method="post">
          <input type="submit" name="chat_exit" id="chat_exit" value="退室する">
        </form>';
      }
  ?>
  

  </div>
</div>
