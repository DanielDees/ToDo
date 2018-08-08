<?php 

namespace Core\Database;

use PDO;

/**
* The QueryBuilder handles any SQL queries with the database.
*/
class QueryBuilder
{
	protected $pdo;

	function __construct(PDO $pdo) 
	{
		$this->pdo = $pdo;
	}

	public function insert($table, $data) 
	{	
		try {
			$sql = sprintf(
				"INSERT INTO %s (%s) VALUES (%s)",
				$table, 
				implode(", ", array_keys($data)), 
				":" . implode(", :", array_keys($data))
			);

			$stmt = $this->pdo->prepare($sql);

			//Bind the parameters and execute
			$stmt->execute($data);

			return $this->pdo->lastInsertId();
		} 
		catch (Exception $e) {
			die($e->getMessage());
		}
	}

	//Delete single item from table
	public function delete($table, $id) 
	{
		try {
			$sql = sprintf(
				"DELETE FROM %s WHERE id=%s",
				$table, 
				$id
			);

			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();
		} 
		catch (Exception $e) {
			die($e->getMessage());
		}
	}

	//Accepts an associative array for the conditions
	//Returns a class array
	public function delete_where($table, $conditions) 
	{
		try {
			//Store values for query
			$where = "";

			//Get values into an array
			$bind_where = explode(" ",  ":" . implode(" :", array_keys($conditions)));

			foreach ($conditions as $key => $value) 
			{
				$where .= " AND " . $key . "=" . array_shift($bind_where) . "";
			}

			$sql = sprintf(
				"DELETE FROM {$table} WHERE %s",
				trim($where, " AND ")
			);

			//die(var_dump($sql));
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute($conditions);
		} 
		catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function update($table, $values, $conditions) 
	{
		try {
			//Store values for of query
			$set = "";
			$where = "";

			//Get values into an array
			$bind_set = explode(" ",  ":" . implode(" :", array_keys($values)));
			$bind_where = explode(" ",  ":" . implode(" :", array_keys($conditions)));

			foreach ($values as $key => $value) {
				$set .= ", " . $key . "=" . array_shift($bind_set) . "";
			}

			foreach ($conditions as $key => $value) {
				$where .= ", " . $key . "=" . array_shift($bind_where) . "";
			}

			$sql = sprintf(
				"UPDATE %s SET %s WHERE %s",
				$table, trim($set, ", "), trim($where, ", ")
			);

			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(
				array_merge($values, $conditions)
			);
		} 
		catch (Exception $e) {
			die($e->getMessage());
		}
	}

	//UPDATE: Returns a class for single result
	public function select($table, $id) 
	{
		try {
			$sql = sprintf(
				"SELECT * FROM {$table} WHERE id='%s'",
				$id
			);
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_CLASS)[0];
		} 
		catch (Exception $e) {
			die($e->getMessage());
		}
	}

	//Accepts an associative array for the conditions
	//Returns a class array
	public function where($table, $conditions, $order_by = null) 
	{
		try {
			//Store values for of query
			$where = "";

			//Get values into an array
			$bind_where = explode(" ",  ":" . implode(" :", array_keys($conditions)));

			foreach ($conditions as $key => $value) 
			{
				$where .= " AND " . $key . "=" . array_shift($bind_where) . "";
			}

			$sql = sprintf(
				"SELECT * FROM {$table} WHERE %s",
				trim($where, " AND ")
			);

			$test = "";

			if (isset($order_by)) 
			{
				$test = " ORDER BY ";

				foreach ($order_by as $column => $order) 
				{
					$test .= $column . " " . $order . ",";
				}

				$sql .= trim($test, ",");
			}

			//die(var_dump($sql));
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute($conditions);

			//die(var_dump($stmt->fetchAll(PDO::FETCH_CLASS)));
			return $stmt->fetchAll(PDO::FETCH_CLASS);
		} 
		catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function select_all($table) 
	{
		try {
			$sql = $this->pdo->prepare("SELECT * FROM {$table}");
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_CLASS);
		} 
		catch (Exception $e) {
			die($e->getMessage());
		}
	}
}

?>