<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>チャットツール</title>
</head>
<body>
  <article>
    <form action="index.php" method="post">
      <input type="text" name="chat" id="chat">
      <button>送信</button>
    </form>

    <?php echo $_POST['chat'] ?>
  </article>
</body>
</html>