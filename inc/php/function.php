<?php 
  // ログ等をエスケープしてページ上に表示するための関数
  function text_escape($text_value){
    return htmlspecialchars(strval($text_value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
  }

  if(isset($_SESSION['data'])){

    $reload_time_stamp = $_SERVER['REQUEST_TIME'];

    $session_pattern_A = [
      'name' => $_SESSION['data']['name'],
      'random_id' => $_SESSION['data']['random_id'],
      'time_stamp' => $_SESSION['data']['time_stamp'],
      'error_message' => '',
      'reload_time_stamp' => $reload_time_stamp,
      'reload_count' => 0
    ];
  
      $session_pattern_B = [
        'name' => '',
        'random_id' => '',
        'time_stamp' => '',
        'error_message' => '',
        'reload_time_stamp' => $reload_time_stamp,
        'reload_count' => 0
      ];
  }

?>