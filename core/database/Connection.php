<?php  

namespace Core\Database;

use PDO;

/**
* The Connection Class handles database connections
*/
class Connection
{
	public static function make($config) {
		try {
			return new PDO(
				$config['connection'] . ";dbname=" .
				$config['database'],
				$config['username'],
				$config['password'],
				$config['options']
			);
		} 
		catch (PDOException $e) {
			die($e->getMessage());
		}
	}
}

?>