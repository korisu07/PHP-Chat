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
      $_SESSION['data'] = [
        'name' => '',
        'random_id' => '',
        'time_stamp' => '',
        'error_message' => '少し待ってから、退室してください。',
        'reload_time_stamp' => $_SESSION['data']['reload_time_stamp'],
        'reload_count' => $_SESSION['data']['reload_count']
      ];
      exit;
    }

    $delete_id = null;

    // $statement = $pdo->prepare('DELETE FROM `login_user` WHERE `random_id` = :random_id');

    // $delete_id = $_SESSION['data']['random_id'];

    // $statement->bindValue(':random_id', $delete_id, PDO::PARAM_STR);
    // $statement->execute();

    $_SESSION['data'] = [
      'name' => '',
      'random_id' => '',
      'time_stamp' => '',
      'error_message' => '',
      'reload_time_stamp' => $_SESSION['data']['reload_time_stamp'],
      'reload_count' => $_SESSION['data']['reload_count']
    ];

    exit;
    }// ここまで - 退出ボタンを押した場合

  ?>