<?php 
  // ログ等をエスケープしてページ上に表示するための関数
  function text_escape($text_value){
    return htmlspecialchars(strval($text_value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
  }

  $reload_time_stamp = $_SERVER['REQUEST_TIME'];

?>