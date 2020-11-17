
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


    // チャットが表示された時の処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      
      if(is_null($_POST['user_name']) || $_POST['user_name'] === ''){
        die('ユーザー名を入力してください');
      }
      if(is_null($_POST['chat_message']) || $_POST['chat_message'] === ''){
        die('内容が入力されていません');
      }

      header('Location: /', 307);

      $user_name = null;
      $chat_message = null;

      $statement = $pdo->prepare('INSERT INTO chat_logs(user_name, message) VALUES(:user_name, :chat_message)');

      $user_name = $_POST['user_name'];
      $chat_message = $_POST['chat_message'];

      $statement->bindValue(':user_name', $user_name, PDO::PARAM_STR);
      $statement->bindValue(':chat_message', $chat_message, PDO::PARAM_STR);

      $statement->execute();

      unset($statement);
      exit;
    }

    ?>