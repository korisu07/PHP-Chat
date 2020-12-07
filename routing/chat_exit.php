<?php
  header('Location: /', 307);
  session_start();

  require_once dirname(__FILE__) . '/../inc/php/function.php';

  include dirname(__FILE__) . '/../inc/php/connect/connect.php';

// 退出ボタンを押した場合
  if( isset($_POST['chat_exit']) ){

    $logout_time_tmp = $_SESSION['data']['time_stamp'];
    $logout_time_tmp = strtotime('+5 second', $logout_time_tmp);

    $logout_req_time = $_SERVER['REQUEST_TIME'];

    // 連投対策
    if($logout_req_time < $logout_time_tmp){
      $_SESSION['data']['error_message'] = '少し待ってから、退室してください。';
      return false;
      exit;
    }else{

      $logout_user = null;
      $logout_user = $_SESSION['data']['name'];

      $statement = $pdo->prepare('INSERT INTO chat_logs(`user_name`, `message`) VALUES(:system_name, :log_message)');


      $log_message = null;
      $log_message = $logout_user . 'さんが退室しました。';
  
      $statement->bindValue(':system_name', 'system', PDO::PARAM_STR);
      $statement->bindValue(':log_message', $log_message, PDO::PARAM_STR);

      $statement->execute();
      
      $_SESSION['data'] = [
        'name' => '',
        'random_id' => '',
        'time_stamp' => '',
        'error_message' => '',
        'reload_time_stamp' => $_SESSION['data']['reload_time_stamp'],
        'reload_count' => $_SESSION['data']['reload_count']
      ];


      exit;
    }

    }// ここまで - 退出ボタンを押した場合

  ?>