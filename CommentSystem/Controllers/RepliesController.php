<?php
namespace CommentSystem\Controllers;

use CommentSystem\Controllers\BaseController;
use CommentSystem\Models\User;
use CommentSystem\SpamFunctions;
use CommentSystem\SessionManager;

class RepliesController extends BaseController
{	
	public function add()
	{
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
		$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
		$comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
		$spam_answer = filter_input(INPUT_POST, 'spam_answer', FILTER_SANITIZE_NUMBER_INT);
	
		$user = new User();
		$users = $user->findOneByField(array('field' => 'email', 'value' => $email));
		$user_id = 0;
		if (!empty($users)) {
			$user_id = $users['id'];
		}
	
		if ($email && $name && $user_id != 0 && $spam_answer == SessionManager::get('spam_answer_reply')) {
			$this->model->create(['user_id' => $user_id, 'message' => $message, 'comment_id' => $comment_id]);
		}
		elseif ($email && $name && $user_id == 0 && $spam_answer == SessionManager::get('spam_answer_reply')) {
			$user_id = $user->create(['email' => $email, 'name' => $name]);
			$this->model->create(['user_id' => $user_id, 'message' => $message, 'comment_id' => $comment_id]);
		}
		else {
			//error
		}
	}
	
	public function load_reply_form() 
	{
		$comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
		
		$spamQandA = SpamFunctions::generateQandA();
		$this->set('spam_question_reply', $spamQandA['question']);
		SessionManager::set('spam_answer_reply', $spamQandA['answer']);
		
		$this->set('comment_id', $comment_id);
	}
}