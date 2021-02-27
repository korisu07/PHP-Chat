<?php declare(strict_types=1);

namespace RoutingTrait;

require_once dirname(__FILE__) . '/../session/Main.php';
require_once dirname(__FILE__) . '/../../connect/ng_word.php';

// NGワードが含まれていないかをチェックする定形機能
class CheckWord extends \Routing\Session\Main
{
  // 判定する文字列
  private string $str;

  // 空欄かどうかをチェックする
  // true であれば、入力されている
  private bool $boolNotEmpty;

  // NGワードが格納された配列
  private array $ngWords;

  // __construct
  public function __construct(string $str, array $ngWords,string $addNGWord = null)
  {
    $this->str = $str;
    $this->ngWords = $ngWords;

    // 追加のNGワードがある場合、NGワード配列に登録
    if( isset( $addNGWord ) && $addNGWord !== null ){
      array_unshift($this->ngWords, $addNGWord);
    }

    // インスタンス化したタイミングで、空文字でないかをチェック
    $this->checkNotEmpty($this->str);
  }//end __construct.
  
  // 入力された文字列がスペースのみではないかをチェックする
  private function checkNotEmpty(string $str): void
  {
    // チェック用に、名前から半角・全角スペース、$nbsp;を削除する
    $removedSpace = str_replace( ' ', '', $str);
    $removedSpace = str_replace( '　', '', $removedSpace);
    $removedSpace = str_replace( '&nbsp;', '', $removedSpace);

    // 入力されていて、かつスペースのみではない場合
    if( isset( $removedSpace ) && $removedSpace !== '' )
    {
      $this->boolNotEmpty = true;
    }
    else { // 空欄か、スペースのみの文字列である場合
      $this->boolNotEmpty = false;
    }
  } //end func checkNotEmpty.


  // NGワードが含まれていないことをチェックする
  public function checkBool()
  {
    // チェックの結果。引っかからなければtrueを返す
    // 判定がうまくいかなかった場合、nullを返す
    $result = null;
    
    // 内容が入力されている場合、NGワードがないかを判定する
    if( $this->boolNotEmpty ){

      foreach ($this->ngWords as $ngWordsStr) {
        // 対象文字列にキーワードが含まれるか
        if (mb_strpos($this->str, $ngWordsStr) !== FALSE) {
          $result = false;
          $this->setErrorMessage('エラー！禁止ワードが含まれています。');
        } //end if NGワードあり判定
      } //end foreach ワードチェック処理

      // $resultにfalseが格納されていなければ、trueを格納させる
      if( $result !== false ){
        $result = true;
      } // end if NGワードなし判定
    //////////////////////////////////////////////////////////////
    } else { // 内容が入力されていない場合
      $result = null;
      $this->setErrorMessage('内容が入力されていません。また、スペースのみの入力はできません。');
    }

    // 結果を返す
    return $result;

  } //end func checkBool.


}//end trait.