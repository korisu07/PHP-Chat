<?php
  require_once dirname(__FILE__) . '/../inc/php/function.php';

  include dirname(__FILE__) . '/../inc/php/connect/connect.php';
  include dirname(__FILE__) . '/../inc/php/connect/ng_word.php';

  header('Location: /', 307);
  session_start();
  

    // 発言内容がなにも入っていない場合
    if(is_null($_POST['chat_message']) || $_POST['chat_message'] === ''){
      $_SESSION['data']['error_message'] = '内容が入力されていません。';
      return false;
      exit;
    }// 発言が入力されていた場合
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
        // 含まれている場合は処理を停止
        $_SESSION['data']['error_message'] = '禁止ワードが含まれています。';
        return false;
        exit;
      }
    }

    // POSTメソッドが連投されていないかのチェック
    $time_tmp = $_SESSION['data']['time_stamp'];
    $time_tmp = strtotime('+10 second', $time_tmp);

    $now_timestamp = $_SERVER['REQUEST_TIME'];

    // 連投対策
    if($now_timestamp < $time_tmp){
      $_SESSION['data']['error_message'] = '少し待ってから投稿してください。';
      return false;
      exit;
    }else{

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

      $_SESSION['data']['error_message'] = '';
      $_SESSION['data']['time_stamp'] = $time_stamp;

      exit;
    }// ここまで - 連投対策
  }
?>