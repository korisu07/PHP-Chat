<?php
  header('Location: /', 307);
  session_start();
  
  require_once dirname(__FILE__) . '/../inc/php/function.php';

  include dirname(__FILE__) . '/../inc/php/connect/connect.php';
  include dirname(__FILE__) . '/../inc/php/connect/ng_word.php';

  // 未入力の場合
  if(is_null($_POST['user_name']) || $_POST['user_name'] === ''){
    $_SESSION['data']['error_message'] = 'ユーザー名を入力してください';
    return false;
    exit;
  }else{
  
  //名前が入力された場合

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
        // 含まれている場合は処理を停止
        $_SESSION['data']['error_message'] = '禁止ワードが含まれています。';
        return false;
        exit;
      }
    }

    $login_user = null;
    $random_id = null;

    $login_user = (string) $_POST['user_name'];
    $random_id = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);

    $statement = $pdo->prepare('INSERT INTO chat_logs(`user_name`, `message`) VALUES(:system_name, :log_message)');

    $log_message = null;
    $log_message = $login_user . 'さんが入室しました。';

    $statement->bindValue(':system_name', 'system', PDO::PARAM_STR);
    $statement->bindValue(':log_message', $log_message, PDO::PARAM_STR);

    $statement->execute();


    $_SESSION['data']['name'] = $login_user;
    $_SESSION['data']['random_id'] = $random_id;
    $_SESSION['data']['time_stamp'] = $_SERVER['REQUEST_TIME'];
    $_SESSION['data']['error_message'] = '';
    
    exit;
  }
