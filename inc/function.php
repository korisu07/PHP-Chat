
    <?php 

    include dirname(__FILE__) . '/../connect/connect.php';


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      
      if(is_null($_POST['user_name']) || $_POST['user_name'] === ''){
        die('ユーザー名を入力してください');
      }
      if(is_null($_POST['chat_message']) || $_POST['chat_message'] === ''){
        die('内容が入力されていません');
      }

      header('Location: /', 307);

      // else if($chat_logs['first massage'] != null){
      //   unset($chat_logs['first massage']);
      // }

      $user_name = null;
      $chat_message = null;

      $statement = $pdo->prepare('INSERT INTO chat_logs(user_name, message) VALUES(:user_name, :chat_message)');

      $user_name = $_POST['user_name'];
      $chat_message = $_POST['chat_message'];

      $statement->bindValue(':user_name', $user_name, PDO::PARAM_STR);
      $statement->bindValue(':chat_message', $chat_message, PDO::PARAM_STR);

      $statement->execute();

      exit;
    }

    ?>