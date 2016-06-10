<?php
namespace CommentSystem\Models;

use CommentSystem\Models\BaseModel;

class Comment extends BaseModel 
{
	protected $table = 'comments';
	protected $belongsTo = array(
		array('table' => 'users', 'model' => 'User', 'fk' => 'user_id')
	); 
}