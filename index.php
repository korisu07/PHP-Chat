<?php 
header("Content-type: text/html; charset=utf-8");
session_start();
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>チャットツール</title>

  <link rel="stylesheet" href="./inc/css/style.min.css">
</head>
<body>

  <?php 

    require_once dirname(__FILE__) . '/inc/php/function.php';

    include dirname(__FILE__) . '/inc/php/connect/disconnect_routing.php';
    include dirname(__FILE__) . '/inc/php/routing.php';
  ?>

  <header>
    
  <?php 
    if(isset($_SESSION['data']['error_message']) && $_SESSION['data']['error_message'] != ''){
      echo '<div class="error_message"><div class="container">' , 
      $_SESSION['data']['error_message'] ,
      '</div></div>';
    }  
  ?>

    <div class="container">

      <?php include dirname(__FILE__) . '/inc/php/header.php'; ?>
      
    </div>
  </header>
  
  <article>
    <div class="container">
      
      <div class="chat_logs_view">
        <?php while ($log_value = $access_process->fetch(PDO::FETCH_ASSOC)): ?>
        <ul>
          <li><?= text_escape($log_value['user_name']) . ' さんの発言：'; ?></li>
          <li><?= text_escape($log_value['message']); ?></li>
          <li><?= text_escape($log_value['date']); ?></li>
        </ul>
        <?php endwhile; ?>
      </div>

    </div>

  </article>

  <footer>
    <div class="container">
      chat.app 2020 
    </div>
  </footer>
</body>
</html>