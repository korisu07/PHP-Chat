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
      if($chat_log['first massage'] != null){
        unset($chat_log['first massage']);
      }
      $i = 0;
      $chat_log = array_merge($chat_log, array($i => $_POST['chat']) );
      $i =+ 1;
    }
    
    var_dump($chat_log);

    foreach ($chat_log as $key => $value) {
      echo '<p>'.$value.'</p>';
    }
    ?>
  </article>
</body>
</html>