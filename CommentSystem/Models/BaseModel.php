<?php
namespace CommentSystem\Models;

use CommentSystem\SQLBuilder;
use ReflectionClass;

abstract class BaseModel extends SQLBuilder 
{
	protected $model;
	protected $table;
	
	public function __construct()
	{
		parent::__construct();
		$reflect = new ReflectionClass($this);
		$this->model = $reflect->getShortName();
		$this->describe();
	}

}