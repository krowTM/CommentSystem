<?php use CommentSystem\TextFunctions;
foreach ($comments as $comment) { ?>
<div class="comment-div" onmouseover="showReplyLink(<?php echo $comment['commentId']; ?>);" onmouseout="hideReplyLink(<?php echo $comment['commentId']; ?>);">
	<span class="name"><?php echo $comment['name']; ?></span> 
	(<span class="email"><?php echo $comment['email']; ?></span>) - 
	<span class="created"><?php echo $comment['created']; ?></span><br />
	<span class="message"><?php echo TextFunctions::convertURLToHref($comment['message']); ?></span>
	<span class="reply-span" id="reply-span-<?php echo $comment['commentId']; ?>"><a href="javascript:showReplyForm(<?php echo $comment['commentId']; ?>);">Reply</a></span>
	
	<?php if (!empty($comment['replies'])) { ?>
	<div class="replies-div">
		<?php foreach ($comment['replies'] as $reply) { ?>
		<div class="reply-div">
			<span class="name"><?php echo $reply['name']; ?></span> 
			(<span class="email"><?php echo $reply['email']; ?></span>)
			<span class="created"><?php echo $reply['created']; ?></span><br />
			<span class="message"><?php echo TextFunctions::convertURLToHref($reply['message']); ?></span>
		</div>		
		<?php } ?>	
	</div>
	<?php } ?>
	
	<div class="new-reply" id="new-reply-<?php echo $comment['commentId']; ?>"></div>
</div>
<?php } ?>