<?php
namespace CommentSystem;

class SessionManager 
{
	public static function start()
	{
		session_start();
	}
	
	public static function set($name, $value) 
	{
		$_SESSION[$name] = $value;
	}

	public static function get($name)
	{
		return $_SESSION[$name];
	}
}