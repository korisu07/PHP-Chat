<?php
  header('Location: /', 307);

  include dirname(__FILE__) . '/../connect/connect.php';
  include dirname(__FILE__) . '/../connect/ng_word.php';

  // 未入力の場合
  if(is_null($_POST['user_name']) || $_POST['user_name'] === ''){
    echo '<p>ユーザー名を入力してください</p>';
    return false;
    exit;
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

    $login_user = (string) $_POST['user_name'];
    $random_id = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);

    // $statement->bindValue(':login_user', $login_user, PDO::PARAM_STR);
    // $statement->bindValue(':random_id', $random_id, PDO::PARAM_STR);

    // $statement->execute();


    $_SESSION['data'] = [
      'name' => $login_user,
      'random_id' => $random_id,
      'time_stamp' => '',
      'error_message' => ''

    ];


    exit;
}
?>