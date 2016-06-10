<?php
namespace CommentSystem;

use PDO;

class Database 
{
	private static $instance = null;

    private function __construct() 
    {    	
    }

    private function __clone() 
    {    	
    }

    public static function getInstance() {
      if (null === self::$instance) {
        self::$instance = new PDO(
        	'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, 
        	DB_USERNAME, 
        	DB_PASSWORD,        		
        	array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
        );
      }
      
      return self::$instance;
    }
	
}