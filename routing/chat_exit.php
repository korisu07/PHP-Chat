<?php
  header('Location: /', 307);

  include dirname(__FILE__) . '/../inc/php/connect/connect.php';

// 退出ボタンを押した場合
  if( isset($_POST['chat_exit']) ){

    $logout_time_tmp = $_SESSION['data']['time_stamp'];
    $logout_time_tmp = strtotime('+5 second', $logout_time_tmp);

    $logout_req_time = $_SERVER['REQUEST_TIME'];

    // 連投対策
    if($logout_req_time < $logout_time_tmp){
      echo '<p>少し待ってから、退室してください。</p>';
      return false;
      exit;
    }

    $delete_id = null;

    // $statement = $pdo->prepare('DELETE FROM `login_user` WHERE `random_id` = :random_id');

    // $delete_id = $_SESSION['data']['random_id'];

    // $statement->bindValue(':random_id', $delete_id, PDO::PARAM_STR);
    // $statement->execute();

    $_SESSION = [];

    setcookie(session_name(), '', time() - 36000);
    session_destroy();

    exit;
    }// ここまで - 退出ボタンを押した場合

  ?>