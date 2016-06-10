<input type="text" name="name" id="name-input"><label for="name-input">Name</label><br />
<input type="text" name="email" id="email-input"><label for="email-input">Email</label><br />
<textarea name="email" id="message-input"></textarea><label for="message-input">Message</label><br />
<?php echo $spam_question;?> = <input type="text" name="spam_answer" id="spam-answer-input" size="2"> ? Spam Check<br />
<input type="submit" value="Comment" onclick="saveComment();">