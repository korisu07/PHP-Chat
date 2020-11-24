  <?php 
    header("Content-type: text/html; charset=utf-8");

    include dirname(__FILE__) . '/connect/connect.php';

    // チャットログを表示
    try{
      $access_process = $pdo->prepare('SELECT * FROM chat_logs ORDER BY id DESC LIMIT 20');
      $access_process->execute();

    } catch(PDOException $e){
      echo 'チャットログの表示に失敗しました。';
    }

    // ログをページ上に表示するための関数
    function log_view($log_value){
      return htmlspecialchars(strval($log_value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    // チャットが送信された時の処理

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      // 名前が登録されていない場合
      if( !isset($_COOKIE[session_name()]) ){
        // 未入力の場合
        if(is_null($_POST['user_name']) || $_POST['user_name'] === ''){
          echo 'ユーザー名を入力してください';
          return false;
        }//名前が入力された場合
        else if($_POST['user_name']){
          session_start();

          $login_user = null;
          $random_id = null;
    
          $statement = $pdo->prepare('INSERT INTO login_user(`login_user`, `random_id`) VALUES(:login_user, :random_id)');
    
          $login_user = (string)$_POST['user_name'];
          $random_id = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);
    
          $statement->bindValue(':login_user', $login_user, PDO::PARAM_STR);
          $statement->bindValue(':random_id', $random_id, PDO::PARAM_STR);
    
          $statement->execute();

          $_SESSION['data'] = [
            'name' => $login_user,
            'random_id' => $random_id
          ];

          header('Location: /', 307);

          exit;
        }
      }
      
      // 名前が登録されている場合
      else if(isset($_COOKIE[session_name()])){

        // 退出ボタンを押した場合
        if($_POST['chat_exit']){
          session_start();

          $delete_id = null;

          $statement = $pdo->prepare('DELETE FROM `login_user` WHERE `random_id` = :random_id');

          $delete_id = $_SESSION['data']['random_id'];

          $statement->bindValue(':random_id', $delete_id, PDO::PARAM_STR);
          $statement->execute();

          setcookie(session_name(), '', time() - 36000);
          session_destroy();

          header('Location: /', 307);
        }// ここまで - 退出ボタンを押した場合
        // 発言内容がなにも入っていない場合
        else if(is_null($_POST['chat_message']) || $_POST['chat_message'] === ''){
          echo '内容が入力されていません';
          return false;
        }// 発言された場合
        else{
          session_start();
          header('Location: /', 307);
  
          $user_name = null;
          $chat_message = null;
    
          $statement = $pdo->prepare('INSERT INTO chat_logs(`user_name`, `message`) VALUES(:user_name, :chat_message)');
    
          $user_name = (string)$_SESSION['data']['name'];
          $chat_message = (string)$_POST['chat_message'];
    
          $statement->bindValue(':user_name', $user_name, PDO::PARAM_STR);
          $statement->bindValue(':chat_message', $chat_message, PDO::PARAM_STR);
    
          $statement->execute();
    
          unset($statement);
          exit;
        } //else
      } // ここまで - 名前が登録されている場合
    }//ここまで - チャットが送信された時の処理


    // ページ離脱時にログアウト処理をする
    if( isset($_COOKIE[session_name()]) ){
      if($_SERVER['HTTP_HOST'] !== 'localhost.chat.test'){

        $delete_id = null;

        $statement = $pdo->prepare('DELETE FROM `login_user` WHERE `random_id` = :random_id');

        $delete_id = (string) $_SESSION['data']['random_id'];

        $statement->bindValue(':random_id', $delete_id, PDO::PARAM_STR);
        $statement->execute();

        setcookie(session_name(), '', time() - 36000);
        session_destroy();
      }
    }

    ?>