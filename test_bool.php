<?php declare(strict_types=1);

// NGワード判定のテストを行います。
require_once dirname(__FILE__) . '/inc/php/routing/trait/CheckWord.php';

use RoutingTrait\CheckWord;

$test_words = [
  '花子' => true,
  '太郎' => true,
  'http:' => false,
  'HTTP:' => false,
  'H T T P:' => false,
  'HTTP太郎' => true,
  '.com' => false,
  'ｱﾎ' => false
];

$result = array();

foreach ($test_words as $key => $value) {
  // NGワードかどうかを判定
  $checkWord = new CheckWord($key, $ng_words);
  // 判定結果
  // trueならセーフ、falseならアウト
  $bool = $checkWord->checkBool();

  // 想定した判定結果と実際の判定結果を比較し、一致していればOKとする
  if( $value === $bool ){
    // testがOKな場合
    // テスト結果を出力
    echo '<p>「', $key, '」のテスト結果：<br>
    ★OK! 正しくワードがチェックされました！<br>
    判定結果は：' , var_dump($bool) , 'です。</p><HR>';
  } else {
    // testがNGな場合
    // テスト結果を出力
    echo '<p>「', $key, '」のテスト結果：<br>
    ■NG... ワードのチェックに失敗しました…。<br>
    判定結果は：' , var_dump($bool) , 'です。</p><HR>';
  } //end if test.
} //end foreach, CheckWord.

///////////////////////////////////////////////////////////////////////