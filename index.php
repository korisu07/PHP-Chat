<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>チャットツール</title>

  <link rel="stylesheet" href="inc/css/style.min.css">
</head>
<body>

<?php require_once dirname(__FILE__) . '/inc/php/function.php' ?>

  <header>
    <div class="container">

      <?php include dirname(__FILE__) . '/inc/php/header.php' ?>
      
    </div>
  </header>
  
  <article>
    <div class="container">
      
      <div class="chat_logs_view">
        <?php while ($log_value = $access_process->fetch(PDO::FETCH_ASSOC)): ?>
        <ul>
          <li><?= escape($log_value['user_name']); ?></li>
          <li><?= escape($log_value['message']); ?></li>
          <li><?= escape($log_value['date']); ?></li>
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