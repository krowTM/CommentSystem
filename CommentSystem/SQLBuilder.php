<?php
namespace CommentSystem;

use PDO;
use CommentSystem\Database;

class SQLBuilder 
{	
	protected $dbConn;
	protected $describe;
	
	public function __construct()
	{
		$this->dbConn = Database::getInstance();
	}
	
	public function create($insert) 
	{
		$fields = array_keys($insert);
		$values = array_values($insert);
		foreach ($fields as $i => $field) {
			$fields[$i] = '`' . $field . '`';
		}
		foreach ($values as $i => $value) {
			$values[$i] = $this->dbConn->quote($value, PDO::PARAM_STR);
		}
		
		$sql = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $values) . ')';
		
		$query = $this->dbConn->prepare($sql);
		$query->execute();
		
		return $this->dbConn->lastInsertId();
	}
	
	public function all() 
	{
		$sql = 'SELECT ';
		$sql_fields = array();
		foreach ($this->describe as $field) {
			$sql_fields[] = '`' . $this->model . '`.`' . $field . '`';
		}		
		
		if (isset($this->belongsTo)) {
			// id field is ambiguous
			$belongsToSQL = array();
			foreach ($this->belongsTo as $belongsTo) { 
				$belongsToSQL[] = '`' . $belongsTo['model'] . '`.`id` AS `' . strtolower($belongsTo['model']) . 'Id`,
						`' . $belongsTo['model'] . '`.*';
			}
			$belongsToSQL[] = '`' . $this->model . '`.`id` AS `' . strtolower($this->model) . 'Id`,
					`' . $this->model . '`.*';
			$sql .= implode(', ', $belongsToSQL);
		}	
		else {
			$sql .= '*';
		}
		
		$sql .= ' FROM ' . $this->table . ' AS `' . $this->model . '`';
		
		if (isset($this->belongsTo)) {
			foreach ($this->belongsTo as $belongsTo) {
				$sql .= ' LEFT JOIN ' . $belongsTo['table'] . ' AS `' . $belongsTo['model'] . '`
					ON `' . $belongsTo['model'] . '`.`id` = `' . $this->model . '`.`' . $belongsTo['fk'] . '`';
			}
		}
		
		$query = $this->dbConn->prepare($sql);
		$query->execute();
		
		$all = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $all;
	}	
	
	public function findOne($id)
	{
		$sql = 'SELECT ';
		$sql_fields = array();
		foreach ($this->describe as $field) {
			$sql_fields[] = '`' . $this->model . '`.`' . $field . '`';
		}
		$sql .= implode(',', $sql_fields);
		$sql .= ' FROM ' . $this->table . ' AS `' . $this->model . '`';
		
		$sql .= ' WHERE `' . $this->model . '`.`id` = ' . (int)$id;
		
		$query = $this->dbConn->prepare($sql);
		$query->execute();
	
		$all = $query->fetch(PDO::FETCH_ASSOC);
	
		return $all;
	}
	
	// field => val
	public function findAllByField($search)
	{
		$sql = 'SELECT ';
		$sql_fields = array();
		foreach ($this->describe as $field) {
			$sql_fields[] = '`' . $this->model . '`.`' . $field . '`';
		}

		if (isset($this->belongsTo)) {
			// id field is ambiguous
			$belongsToSQL = array();
			foreach ($this->belongsTo as $belongsTo) { 
				$belongsToSQL[] = '`' . $belongsTo['model'] . '`.`id` AS `' . strtolower($belongsTo['model']) . 'Id`,
						`' . $belongsTo['model'] . '`.*';
			}
			$belongsToSQL[] = '`' . $this->model . '`.`id` AS `' . strtolower($this->model) . 'Id`,
					`' . $this->model . '`.*';
			$sql .= implode(', ', $belongsToSQL);
		}
		else {
			$sql .= '*';
		}
		
		$sql .= ' FROM ' . $this->table . ' AS `' . $this->model . '`';
		
		if (isset($this->belongsTo)) {
			foreach ($this->belongsTo as $belongsTo) {
				$sql .= ' LEFT JOIN ' . $belongsTo['table'] . ' AS `' . $belongsTo['model'] . '`
					ON `' . $belongsTo['model'] . '`.`id` = `' . $this->model . '`.`' . $belongsTo['fk'] . '`';
			}
		}
	
		$sql .= ' WHERE `' . $this->model . '`.`' . $search['field'] . '` = :value';
	
		$query = $this->dbConn->prepare($sql);
		$query->bindParam(':value', $search['value']);
		$query->execute();
	
		$all = $query->fetchAll(PDO::FETCH_ASSOC);
	
		return $all;
	}
	
	// field => val
	public function findOneByField($search)
	{
		$sql = 'SELECT ';
		$sql_fields = array();
		foreach ($this->describe as $field) {
			$sql_fields[] = '`' . $this->model . '`.`' . $field . '`';
		}
		$sql .= implode(',', $sql_fields);
		$sql .= ' FROM ' . $this->table . ' AS `' . $this->model . '`';
	
		$sql .= ' WHERE `' . $this->model . '`.`' . $search['field'] . '` = :value';
	
		$query = $this->dbConn->prepare($sql);
		$query->bindParam(':value', $search['value']);
		$query->execute();
	
		$all = $query->fetch(PDO::FETCH_ASSOC);
	
		return $all;
	}
	
	protected function describe()
	{
		$sql = "DESCRIBE " . $this->table;
		$query = $this->dbConn->prepare($sql);
		$query->execute();
		$this->describe = $query->fetchAll(PDO::FETCH_COLUMN);
		
		foreach ($this->describe as $field) {
			$this->$field = null;
		}
	}
}