<?php
namespace CommentSystem\Controllers;

use CommentSystem\BaseView;

abstract class BaseController 
{
	protected $model;
	protected $controller;
	protected $action;
	protected $view;
	
	public function __construct($model, $controller, $action) 
	{
		$model_name = 'CommentSystem\Models\\' . $model;
		$this->model = new $model_name;
		$this->controller = $controller;
		$this->action = $action;
		$this->view = new BaseView($controller, $action);
	}
	
	public function set($name, $value) 
	{
		$this->view->set($name, $value);
	}
	
	public function __destruct() 
	{
		$this->view->render();
	}
}