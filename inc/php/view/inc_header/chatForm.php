<form action="./routing/user_message_routing.php" method="post" class="chat_post" id="chat_message">
  <div class="header_box">
    <label for="chat_message">メッセージ：</label>
    <input type="text" name="chat_message" id="chat" maxlength="200" form="chat_message">
  </div>

  <input type="submit" value="発言する" for="chat_message" form="chat_message">
</form>