<?php 
header("Content-type: text/html; charset=utf-8");

require_once dirname(__FILE__) . '/inc/php/view/viewer.php';
require_once dirname(__FILE__) . '/inc/php/view/header.php';

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
  <header>
  <?php 
    // エラーメッセージが設定されている場合、表示する
    if(isset($_SESSION['data']['error_message']) && $_SESSION['data']['error_message'] != ''){
      // エラーメッセージを表示
      echo '<div class="error_message"><div class="container">' , 
      $_SESSION['data']['error_message'] ,
      '</div></div>';
    } //end if, Error message.
  ?><!-- PHP -->

  <div class="container">
    <?php // header内のテキストボックスを表示
      $header = new header();
      $header->loadTextarea();
    ?><!-- PHP -->
  </div>
  </header>
  
  <article>
    <div class="container">
      <div class="chat_logs_view">
      <?php 
        // チャットログを表示
        try{
          // SQLへ接続
          $access_process = $pdo->prepare('SELECT * FROM chat_logs ORDER BY id DESC LIMIT 20');
          // 接続処理を実行
          $access_process->execute();
        } catch(PDOException $e){
          // 接続に失敗した場合
          echo '<p>チャットログの表示に失敗しました。</p>';
        } //end try~catch.

        // SQLのログを読み込み
        while( $sql_log_data = $access_process->fetch(PDO::FETCH_ASSOC) ){
          $viewer = new Viewer( $sql_log_data );
          $viewer->logSheet();
        }//end while.
      ?><!-- PHP -->
      </div> <!-- /.chat_logs_view -->
    </div> <!-- /.container -->
  </article>

  <footer>
    <div class="container">
      chat.app 2020 - <?= date('Y') ?>.
    </div> <!-- /.container -->
  </footer>
</body>
</html>