<?php declare(strict_types=1);

namespace RoutingTrait;

require_once dirname(__FILE__) . '/../../connect/ng_word.php';

// NGワードが含まれていないかをチェックする定形機能
class CheckWord{

  public function checkBool(string $str, array $ngWords, string $addWord = null):bool
  {
    if( isset($addWord) ){
      array_unshift($ngWords, $addWord);
    }
    
    // チェックの結果。引っかからなければtrueを返す
    $result = true;

    foreach ($ngWords as $ngWordsStr) {
      // 対象文字列にキーワードが含まれるか
      if (mb_strpos($str, $ngWordsStr) !== FALSE) {
        $result = false;
      } //end if.
    } //end foreach.

    // 結果を返す
    return $result;

  } //end func checkWord.

}//end trait.