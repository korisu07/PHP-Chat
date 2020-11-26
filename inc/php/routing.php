<?php 
    header("Content-type: text/html; charset=utf-8");

    include dirname(__FILE__) . '/connect/connect.php';

    // チャットログを表示
    try{
      $access_process = $pdo->prepare('SELECT * FROM chat_logs ORDER BY id DESC LIMIT 20');
      $access_process->execute();

    } catch(PDOException $e){
      echo 'チャットログの表示に失敗しました。';
    }

    // POSTメソッドが送信された時の処理

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      // 名前が登録されていない場合
      if( !isset($_COOKIE[session_name()]) && isset($_POST['user_name'])){

        // 未入力の場合
        if(is_null($_POST['user_name']) || $_POST['user_name'] === ''){
          echo 'ユーザー名を入力してください';
          return false;
        }
        
        //名前が入力された場合
        else {
          session_start();

          $login_time_tmp = $_SESSION['data']['time_stamp'];
          $login_time_tmp = strtotime('+30 second', $login_time_tmp);
        
          $now_time = $_SERVER['REQUEST_TIME'];

          // 連投対策
          if($now_time < $login_time_tmp){
            echo '連投はできません。少し待ってからお試しください。';
            return false;
          }else{
          $login_user = null;
          $random_id = null;
    
          $statement = $pdo->prepare('INSERT INTO login_user(`login_user`, `random_id`) VALUES(:login_user, :random_id)');
    
          $login_user = (string)$_POST['user_name'];
          $random_id = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);
    
          $statement->bindValue(':login_user', $login_user, PDO::PARAM_STR);
          $statement->bindValue(':random_id', $random_id, PDO::PARAM_STR);
    
          $statement->execute();

          $time_stamp = $_SERVER['REQUEST_TIME'];

          $_SESSION['data'] = [
            'name' => $login_user,
            'random_id' => $random_id,
            'time_stamp' => $time_stamp
          ];
          header('Location: /', 307);

          exit;
          }
        }
      } // ここまで 名前が登録されていない場合
      

      // 名前が登録されている場合
      if(isset($_COOKIE[session_name()])){

        // 退出ボタンを押した場合
        if( isset($_POST['chat_exit']) ){
          session_start();

          $delete_id = null;

          $statement = $pdo->prepare('DELETE FROM `login_user` WHERE `random_id` = :random_id');

          $delete_id = $_SESSION['data']['random_id'];

          $statement->bindValue(':random_id', $delete_id, PDO::PARAM_STR);
          $statement->execute();

          $_SESSION = [];

          setcookie(session_name(), '', time() - 36000);
          session_destroy();

          header('Location: /', 307);

          exit;
        }// ここまで - 退出ボタンを押した場合
        // 発言内容がなにも入っていない場合
        else if(is_null($_POST['chat_message']) || $_POST['chat_message'] === ''){
          echo '内容が入力されていません';
          return false;
        }// 発言された場合
        else{
          session_start();

          $time_tmp = $_SESSION['data']['time_stamp'];
          $time_tmp = strtotime('+30 second', $time_tmp);
        
          $now_timestamp = $_SERVER['REQUEST_TIME'];

          // 連投対策
          if($now_timestamp < $time_tmp){
            echo '連投はできません。少し待ってからお試しください。';
            return false;
          }else{
            header('Location: /', 307);
  
            $user_name = null;
            $chat_message = null;
      
            $statement = $pdo->prepare('INSERT INTO chat_logs(`user_name`, `message`) VALUES(:user_name, :chat_message)');
      
            $user_name = (string)$_SESSION['data']['name'];
            $chat_message = (string)$_POST['chat_message'];
      
            $statement->bindValue(':user_name', $user_name, PDO::PARAM_STR);
            $statement->bindValue(':chat_message', $chat_message, PDO::PARAM_STR);
      
            $statement->execute();
      
            unset($statement);

            $time_stamp = $_SERVER['REQUEST_TIME'];

            $_SESSION['data'] = [
              'name' => $_SESSION['data']['name'],
              'random_id' => $_SESSION['data']['random_id'],
              'time_stamp' => $time_stamp
            ];

            exit;
          }// ここまで - 連投対策

        }
      } // ここまで - 名前が登録されている場合
    }//ここまで - POSTメソッドが送信された時の処理


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