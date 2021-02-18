<?php declare(strict_types=1);

class Viewer{

  //ログの配列
  protected array $logs = [];

  // construnct
  public function __construct( array $logs )
  {
    $this->logs = $logs;
  } //end func __construct

  // HTMLタグをエスケープする
  private function htmlEscape( string $log_str ): string
  {
    return htmlspecialchars(strval($log_str), ENT_QUOTES | ENT_HTML5, 'UTF-8');
  }

  // logを表示する
  public function logSheet(): void
  {
    $log_array = $this->logs;
    for ($i = 0; $i < count( $log_array, COUNT_RECURSIVE); $i++)
    {
      echo '<ul>';
      echo '<li>', $this->htmlEscape( $log_array['user_name'] ), 'さんの発言：</li>';
      echo '<li>', $this->htmlEscape( $log_array['message'] ), '</li>';
      echo '<li>', $this->htmlEscape( $log_array['date'] ), '</li>';
      echo '</ul>';
    } //end for.
  } //end func logSheet

} //end class Viewer.