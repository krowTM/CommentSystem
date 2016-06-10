<?php
namespace CommentSystem;

class SpamFunctions 
{
	public static function generateQandA()
	{
		$spam_num1 = rand(5, 9);
		$spam_num2 = rand(0, 4);
		$operations = ['+', '-', '*'];
		$spam_operation = $operations[rand(0, 2)];
		$spam_question = $spam_num1 . ' ' . $spam_operation . ' ' . $spam_num2;
		eval('$t = ' . $spam_num1 . ' ' . $spam_operation . ' ' . $spam_num2 . ';');
		$spam_answer = $t; 
		
		return ['question' => $spam_question, 'answer' => $spam_answer];
	}
}