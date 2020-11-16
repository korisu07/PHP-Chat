<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>チャットツール</title>
</head>
<body>
  <article>
    <form action="/" method="post">
      <label for="user_name">ユーザー名：</label>
      <input type="text" name="user_name" id="chat">

      <label for="chat_message">メッセージ：</label>
      <input type="text" name="chat_message" id="chat">
      <button>送信</button>
    </form>

    <?php require_once dirname(__FILE__) . '/inc/function.php' ?>
    

  </article>
</body>
</html>