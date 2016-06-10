<?php
namespace CommentSystem;

class BaseView 
{
	protected $variables = array();
	protected $controller;
	protected $action;
	
	public function __construct($controller, $action) 
	{
		$this->controller = $controller;
		$this->action = $action;
	}
	
	public function set($name,$value) 
	{
		$this->variables[$name] = $value;
	}
	
	public function render() 
	{
		extract($this->variables);
		$view_file = BASE_PATH . 'CommentSystem/Views/' . $this->controller . '/' . $this->action . '.php';
		if (file_exists($view_file)) {
			require_once $view_file;
		}
	}
}