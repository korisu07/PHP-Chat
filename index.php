<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>チャットツール</title>
</head>
<body>
  <article>
    <form action="/" method="post">
      <input type="text" name="chat" id="chat">
      <button>送信</button>
    </form>

    <?php 
    $chat_log = [
      'first massage' => 'ここにチャットログが表示されます。'
    ];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      
      if(is_null($_POST['chat']) || $_POST['chat'] === ''){
        echo '内容が入力されていません';
        return false;
      }
      else if($chat_log['first massage'] != null){
        unset($chat_log['first massage']);
      }
      
      $lineNumber = count($chat_log);
      $lineNumber =+ 1;
      $chat_log[$lineNumber] = $_POST['chat'];
    }
    
    var_dump($chat_log);

    foreach ($chat_log as $key => $value) {
      echo '<p>'.$value.'</p>';
    }
    ?>
  </article>
</body>
</html>