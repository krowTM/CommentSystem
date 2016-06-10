<?php
namespace CommentSystem;

use CommentSystem\SessionManager;
use CommentSystem\Database;

class App 
{
	private $default = array(
		'model' => 'Comment',
		'controller' => 'Comments',
		'action' => 'index'
	);
	
	public function __construct() 
	{
		$this->init();
	}
	
	public function run() 
	{
		if (isset($_POST['model'])) {
			$model = $_POST['model'];
		}
		else {
			$model = $this->default['model'];
		}
		
		if (isset($_POST['controller'])) {
			$controller = $_POST['controller'];
		}
		else {
			$controller = $this->default['controller'];
		}
		
		if (isset($_POST['action'])) {
			$action = $_POST['action'];
		}
		else {
			$action = $this->default['action'];
		}
		
		$controllerName = 'CommentSystem\Controllers\\' . $controller . 'Controller';
		$dispatcher = new $controllerName($model, $controller, $action);
		
		if (method_exists($dispatcher, $action)) {
			call_user_func_array(array($dispatcher, $action), array());
		}
		else {
			header("HTTP/1.0 404 Not Found");
		}
	}
	
	public function setup() 
	{
		$dbConn = Database::getInstance();
		$sql = file_get_contents(BASE_PATH . 'db.sql');
		$query = $dbConn->prepare($sql);		
		$query->execute();
	}
	
	private function init() 
	{
		SessionManager::start();
	}
}