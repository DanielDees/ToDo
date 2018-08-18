<?php  

namespace Core;

/**
* The App class is an Dependency Injection Container
*/
class App
{
	protected static $registry = [];

	//Bind a file to a given key for access
	public static function bind($key, $value) 
	{
		static::$registry[$key] = $value;
	}

	//Grab file from registry
	public static function get($key) 
	{
		try {
			return static::$registry[$key];
		} 
		catch (Exception $e) {
			throw new Exception("No $key is bound to the container!");
		}
	}
}

?>