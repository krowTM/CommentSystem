<?php
namespace CommentSystem\Controllers;

use CommentSystem\Controllers\BaseController;
use CommentSystem\Models\User;
use CommentSystem\Models\Reply;
use CommentSystem\SpamFunctions;
use CommentSystem\SessionManager;

class CommentsController extends BaseController
{
	public function index()
	{			
	}
	
	public function load_ajax_comments()
	{
		$comments = $this->model->all();
		foreach ($comments as $i => $comment) {
			$reply = new Reply;
			$comments[$i]['replies'] = $reply->findAllByField(['field' => 'comment_id', 'value' => $comment['commentId']]);
		}
		$this->set('comments', $comments);
	}
	
	public function load_comment_form() 
	{
		$spamQandA = SpamFunctions::generateQandA();
		$this->set('spam_question', $spamQandA['question']);
		SessionManager::set('spam_answer', $spamQandA['answer']);
	}
	
	public function add() 
	{
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
		$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
		$spam_answer = filter_input(INPUT_POST, 'spam_answer', FILTER_SANITIZE_NUMBER_INT);
		
		$user = new User();
		$user_check = $user->findOneByField(['field' => 'email', 'value' => $email]);
		$user_id = 0;
		if (!empty($user_check)) {
			$user_id = $user_check['id'];
		}
		
		if ($email && $name && $user_id != 0 && $spam_answer == SessionManager::get('spam_answer')) {
			$this->model->create(['user_id' => $user_id, 'message' => $message]);
		}
		elseif ($email && $name && $user_id == 0 && $spam_answer == SessionManager::get('spam_answer')) {
			$user_id = $user->create(['email' => $email, 'name' => $name]);
			$this->model->create(['user_id' => $user_id, 'message' => $message]);
		}
		else {
			//error
		}
	}
}