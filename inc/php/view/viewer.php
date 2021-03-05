<?php declare(strict_types=1);

require_once dirname(__FILE__) . '/../connect/connect.php';

class Viewer{

  //ログの配列
  protected array $logs;

  // construnct
  public function __construct( array $logs )
  {
    $this->logs = $logs;
  } //end func __construct.

  // HTMLタグをエスケープする
  private function htmlEscape( string $log_str ): string
  {
    return htmlspecialchars(strval($log_str), ENT_QUOTES | ENT_HTML5, 'UTF-8');
  } //end func htmlEscape.

  // logを表示する
  public function logSheet(): void
  {
    echo '<ul>';
    echo '<li>', $this->htmlEscape( $this->logs['user_name'] ), ' さんの発言：</li>';
    echo '<li>', $this->htmlEscape( $this->logs['message'] ), '</li>';
    echo '<li>', $this->htmlEscape( $this->logs['date'] ), '</li>';
    echo '</ul>';
  } //end func logSheet.

} //end class Viewer.