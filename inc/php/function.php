
    <?php 

    include dirname(__FILE__) . '/connect/connect.php';

    // チャットログを表示
    try{
      $access_process = $pdo->prepare('SELECT * FROM chat_logs ORDER BY id DESC LIMIT 20');
      $access_process->execute();

    } catch(PDOException $e){
      echo 'チャットログの表示に失敗しました。';
    }

    function escape($escape_value){
      return htmlspecialchars(strval($escape_value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    function login_function($login_value) {
      $login_user = null;
      $password = null;

      $statement = $pdo->prepare('INSERT INTO login_user(login_user, password) VALUES(:login_user, :password)');

      $login_user = $login_value;
      $password = 'test';

      $statement->bindValue(':login_user', $login_user, PDO::PARAM_STR);
      $statement->bindValue(':password', $password, PDO::PARAM_STR);

      $statement->execute();
  }

    // チャットが送信された時の処理

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      // 名前が登録されていない場合
      if(!isset($_COOKIE['Your_name'])){
        // 未入力の場合
        if(is_null($_POST['user_name']) || $_POST['user_name'] === ''){
          echo 'ユーザー名を入力してください';
          return false;
        }//名前が入力された場合
        else if($_POST['user_name']){
          header('Location: /', 307);
          setcookie('Your_name', $_POST['user_name'], time()+3600);
          login_function($_POST['user_name']);
        }
      }
      
      // 名前が登録されている場合
      else if(isset($_COOKIE['Your_name'])){

        // 退出ボタンを押した場合
        if($_POST['chat_exit']){
          header('Location: /', 307);
          setcookie('Your_name', '', time() - 3600);
          echo 'チャットを退出しました。';
        }
        // 発言内容がなにも入っていない場合
        else if(is_null($_POST['chat_message']) || $_POST['chat_message'] === ''){
          echo '内容が入力されていません';
          return false;
        }// 発言された場合
        else{
          header('Location: /', 307);
  
          $user_name = null;
          $chat_message = null;
    
          $statement = $pdo->prepare('INSERT INTO chat_logs(user_name, message) VALUES(:user_name, :chat_message)');
    
          $user_name = $_COOKIE['Your_name'];
          $chat_message = $_POST['chat_message'];
    
          $statement->bindValue(':user_name', $user_name, PDO::PARAM_STR);
          $statement->bindValue(':chat_message', $chat_message, PDO::PARAM_STR);
    
          $statement->execute();
    
          unset($statement);
          exit;
        }
      }
    }

    ?>