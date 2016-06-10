<input type="text" name="name" id="name-input-<?php echo $comment_id; ?>"><label for="name-input">Name</label><br />
<input type="text" name="email" id="email-input-<?php echo $comment_id; ?>"><label for="email-input">Email</label><br />
<textarea name="email" id="message-input-<?php echo $comment_id; ?>"></textarea><label for="message-input">Message</label><br />
<?php echo $spam_question_reply; ?> = <input type="text" name="spam_answer" id="spam-answer-input-<?php echo $comment_id; ?>" size="2"> ? Spam Check<br />
<input type="submit" value="Reply" onclick="saveReply(<?php echo $comment_id; ?>);">
<span class="close-reply-span" id="close-reply-span-<?php echo $comment_id; ?>"><a href="javascript:closeReplyForm(<?php echo $comment_id; ?>);">Close</a></span>