<?php 
    header("Content-type: text/html; charset=utf-8");

    include dirname(__FILE__) . '/connect/connect.php';

    include dirname(__FILE__) . '/connect/ng_word.php';

    // チャットログを表示
    try{
      $access_process = $pdo->prepare('SELECT * FROM chat_logs ORDER BY id DESC LIMIT 20');
      $access_process->execute();

    } catch(PDOException $e){
      echo '<p>チャットログの表示に失敗しました。</p>';
    }

    // POSTメソッドが送信された時の処理

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      session_start();

      // 名前が登録されていない場合
      if( !isset($_COOKIE[session_name()]) && isset($_POST['user_name'])){

        // 未入力の場合
        if(is_null($_POST['user_name']) || $_POST['user_name'] === ''){
          echo '<p>ユーザー名を入力してください</p>';
          return false;
        }
        
        //名前が入力された場合
        else {

          // NGワードチェック
          $name_str = $_POST['user_name'];

          // 大文字を小文字に変換
          $name_str = mb_strtolower($name_str, 'UTF-8');
          // 数字を半角に、半角カタカナは全角に変換
          $name_str = mb_convert_kana($name_str, 'KVas', 'UTF-8');
          // スペース、句読点などを削除
          $target_sentence = preg_replace('/\s|、|。/', '', $name_str);

          foreach ($ng_words as $ngWordsVal) {
            // 対象文字列にキーワードが含まれるか
            if (mb_strpos($target_sentence, $ngWordsVal) !== FALSE) {
              // 含まれている場合は処理を停止...
              echo '<p>禁止ワードが含まれています。</p>';
              return false;
              break;
            }
          }

          $login_user = null;
          $random_id = null;
    
          // $statement = $pdo->prepare('INSERT INTO login_user(`login_user`, `random_id`) VALUES(:login_user, :random_id)');
    
          $login_user = (string)$_POST['user_name'];
          $random_id = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);
    
          // $statement->bindValue(':login_user', $login_user, PDO::PARAM_STR);
          // $statement->bindValue(':random_id', $random_id, PDO::PARAM_STR);
    
          // $statement->execute();


          $_SESSION['data'] = [
            'name' => $login_user,
            'random_id' => $random_id,
            'time_stamp' => ''
          ];

          header('Location: '. $_SERVER['PHP_SELF'] . '/../', 307);
          exit;
        }
      } // ここまで 名前が登録されていない場合
      

      // 名前が登録されている場合
      if(isset($_COOKIE[session_name()])){

        // 退出ボタンを押した場合
        if( isset($_POST['chat_exit']) ){

          $logout_time_tmp = $_SESSION['data']['time_stamp'];
          $logout_time_tmp = strtotime('+5 second', $logout_time_tmp);
        
          $logout_req_time = $_SERVER['REQUEST_TIME'];

          // 連投対策
          if($logout_req_time < $logout_time_tmp){
            echo '<p>少し待ってから、退室してください。</p>';
            return false;
          }

          $delete_id = null;

          $statement = $pdo->prepare('DELETE FROM `login_user` WHERE `random_id` = :random_id');

          $delete_id = $_SESSION['data']['random_id'];

          $statement->bindValue(':random_id', $delete_id, PDO::PARAM_STR);
          $statement->execute();

          $_SESSION = [];

          setcookie(session_name(), '', time() - 36000);
          session_destroy();

          header('Location: '. $_SERVER['PHP_SELF'] . '/../', 307);
          exit;
        }// ここまで - 退出ボタンを押した場合
        // 発言内容がなにも入っていない場合
        else if(is_null($_POST['chat_message']) || $_POST['chat_message'] === ''){
          echo '<p>内容が入力されていません</p>';
          return false;
        }// 発言された場合
        else{

          // NGワードチェック
          $message_str = $_POST['chat_message'];

          // 大文字を小文字に変換
          $message_str = mb_strtolower($message_str, 'UTF-8');
          // 数字を半角に、半角カタカナは全角に変換
          $message_str = mb_convert_kana($message_str, 'KVas', 'UTF-8');

          // スペース、句読点などを削除
          $target_sentence = preg_replace('/\s|、|。/', '', $message_str);

          foreach ($ng_words as $ngWordsVal) {
            // 対象文字列にキーワードが含まれるか
            if (mb_strpos($target_sentence, $ngWordsVal) !== FALSE) {
              // 含まれている場合は処理を停止...
              echo '<p>禁止ワードが含まれています</p>';
              return false;
              break;
            }
          }

          // POSTメソッドが連投されていないかのチェック
          $time_tmp = $_SESSION['data']['time_stamp'];
          $time_tmp = strtotime('+10 second', $time_tmp);
        
          $now_timestamp = $_SERVER['REQUEST_TIME'];

          // 連投対策
          if($now_timestamp < $time_tmp){
            echo '<p>連投はできません。少し待ってからお試しください。</p>';
            return false;
          }else{
            header('Location: '. $_SERVER['PHP_SELF'] . '/../', 307);
  
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

            header('Location: '. $_SERVER['PHP_SELF'] . '/../', 307);
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