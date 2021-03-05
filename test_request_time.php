<?php declare(strict_types=1);


require_once dirname(__FILE__) . '/inc/php/routing/post/SendMessage.php';

// 連投チェックのテストを行います。
// 読み込んでいる親元のファイルで、チェック用のクラスはインスタンス化済み

// 前回のアクセス時をセッション内に設定
$_SESSION['data']['time_stamp'] = strtotime('2021-03-05 13:25:00');

// リクエスト時間を2種類用意
// 5秒以内と、5秒経過後の時刻を用意
$test_request_time = [
  strtotime('2021-03-05 13:25:05') => false,
  strtotime('2021-03-05 13:25:10') => true,
  strtotime('2021-03-05 13:25:15') => true,
];

foreach ($test_request_time as $key_r => $value_r) {
  // 前回のアクセス時から、10秒以上経過しているかのチェックを行います
  $bool_Reload = $checkReload->JudgeRepeatedHits($key_r, '+10 second');

  if( $bool_Reload === $value_r ){
    // testがOKな場合
    // テスト結果を出力
    echo '<p>「', date('Y-m-d G:i:s', $key_r), '」のリクエスト時間のテスト結果：<br>
    ★OK! 正しく判定されました！<br>
    判定結果は：' , var_dump($bool_Reload) , 'です。</p><HR>';
  } else {
    // testがNGな場合
    // テスト結果を出力
    echo '<p>「', date('Y-m-d G:i:s', $key_r), '」のリクエスト時間のテスト結果：<br>
    ■NG... 判定に失敗しました…。<br>
    判定結果は：' , var_dump($bool_Reload) , 'です。</p><HR>';
  } //end if test.
}

///////////////////////////////////////////////////////////////////////