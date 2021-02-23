<?php 
    require_once dirname(__FILE__) . '/connect/connect.php';
    
    // チャットログを表示
    try{
      $access_process = $pdo->prepare('SELECT * FROM chat_logs ORDER BY id DESC LIMIT 20');
      $access_process->execute();

    } catch(PDOException $e){
      echo '<p>チャットログの表示に失敗しました。</p>';
    }
