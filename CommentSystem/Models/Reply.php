<?php
namespace CommentSystem\Models;

use CommentSystem\Models\BaseModel;

class Reply extends BaseModel 
{
	protected $table = 'replies';
	protected $belongsTo = array(
		array('table' => 'users', 'model' => 'User', 'fk' => 'user_id'),
		array('table' => 'comments', 'model' => 'Comment', 'fk' => 'comment_id')
	); 
}