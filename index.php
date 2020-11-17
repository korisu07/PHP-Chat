<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>チャットツール</title>

  <link rel="stylesheet" href="inc/css/style.min.css">
</head>
<body>
  <header>
    <div class="container">

      <form action="/" method="post">
        <div class="header_box">
          <label for="user_name">ユーザー名：</label>
          <input type="text" name="user_name" id="chat">
        </div>

        <div class="header_box">
          <label for="chat_message">メッセージ：</label>
          <input type="text" name="chat_message" id="chat">
        </div>

        <button>発言する</button>
      </form>

    </div>
  </header>
  
  <article>
    <div class="container">

      <?php require_once dirname(__FILE__) . '/inc/php/function.php' ?>
      
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
</body>
</html>