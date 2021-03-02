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

    require_once dirname(__FILE__) . '/inc/php/connect/disconnect_routing.php';
    require_once dirname(__FILE__) . '/inc/php/view/viewer.php';

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
      <?php require_once dirname(__FILE__) . '/inc/php/connect/connect.php'; ?>

      <?php require_once dirname(__FILE__) . '/inc/php/view/header.php';
        $userName = (string) $_SESSION['data']['name'];
        $header = new header( $userName );
        $header->loadTextarea();
      ?>

      
    </div>
  </header>
  
  <article>
    <div class="container">
      
      <div class="chat_logs_view">

      <?php 
        // チャットログを表示
        try{
          $access_process = $pdo->prepare('SELECT * FROM chat_logs ORDER BY id DESC LIMIT 20');
          $access_process->execute();

        } catch(PDOException $e){
          echo '<p>チャットログの表示に失敗しました。</p>';
        }

        while( $sql_log_data = $access_process->fetch(PDO::FETCH_ASSOC) ){
          $viewer = new Viewer( $sql_log_data );
          $viewer->logSheet();
        }
      ?>
      </div> <!-- /.chat_logs_view -->

    </div>
  </article>

  <footer>
    <div class="container">
      chat.app 2020 
    </div>
  </footer>
</body>
</html>