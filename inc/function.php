
    <?php 
    $chat_logs = [
      'first massage' => 'ここにチャットログが表示されます。'
    ];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      
      if(is_null($_POST['chat']) || $_POST['chat'] === ''){
        die('内容が入力されていません');
      }
      else if($chat_logs['first massage'] != null){
        unset($chat_logs['first massage']);
      }

      $lineNumber = count($chat_logs);
      $lineNumber =+ 1;
      $chat_logs[$lineNumber] = $_POST['chat'];

      unset($lineNumber);
    }
    
    var_dump($chat_logs);

    foreach ($chat_logs as $log) {
      echo '<p>'.$log.'</p>';
      unset($log);
    }

    ?>