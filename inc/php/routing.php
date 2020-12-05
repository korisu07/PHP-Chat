<?php 
    include dirname(__FILE__) . '/connect/connect.php';
    
    // チャットログを表示
    try{
      $access_process = $pdo->prepare('SELECT * FROM chat_logs ORDER BY id DESC LIMIT 20');
      $access_process->execute();

    } catch(PDOException $e){
      echo '<p>チャットログの表示に失敗しました。</p>';
    }


    // 簡易的に、ページ離脱時にログアウト処理をする
    if( isset($_COOKIE[session_name()]) ){
      if($_SERVER['HTTP_HOST'] !== 'localhost.chat.test'){

        $delete_id = null;

        $statement = $pdo->prepare('DELETE FROM `login_user` WHERE `random_id` = :random_id');

        $delete_id = (string) $_SESSION['data']['random_id'];

        $statement->bindValue(':random_id', $delete_id, PDO::PARAM_STR);
        $statement->execute();

        $_SESSION = [];

        setcookie(session_name(), '', time() - 36000);
        session_destroy();

        exit;
      }
    }

    ?>