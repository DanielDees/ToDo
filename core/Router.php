<?php  

namespace Core;

use Exception;

/**
* The Router class will handle URI requests and redirect
* any requests made to the proper page
*/
class Router
{
	protected $routes = [
		'GET' => [],
		'POST' => []
	];

	public static function load($file) 
	{
		//Create instance of this. (Syntax: new self or new static)
		$router = new static;

		require $file;

		return $router;
	}

	//Handle GET requests
	public function get($uri, $controller) 
	{
		$this->routes['GET'][$uri] = $controller;
	}

	//Handle POST requests
	public function post($uri, $controller) 
	{
		$this->routes['POST'][$uri] = $controller;
	}

	//Redirect to appropriate page based on the uri and request method given
	public function direct($uri, $method) 
	{		
		//var_dump($_SERVER['REQUEST_URI']);
		$uri_segments = explode('/', $uri);
		$uri_head = $uri_segments[0];
		
		if (array_key_exists($uri_head, $this->routes[$method])) 
		{
			$response =  $this->callMethod(
				...explode('@', $this->routes[$method][$uri_head])
			);

			//Check for string responses. Typically used by AJAX currently.
			if (is_string($response))
			{
				echo $response;

				return true;
			}

			//Page view
			if (is_view($response)) 
			{
				if (is_array($response['view_data'])) 
				{
					extract($response['view_data']);
				}

				require $response['view_page'];

				return true;
			}

			return $response;
		}


		throw new Exception("Could not find route for the uri: " . $uri, 1);
	}

	protected function callMethod($controller, $method) 
	{
		$controller = "ToDo\Controllers\\{$controller}";
		$controller = new $controller;

		if (! method_exists($controller, $method)) 
		{
			throw new Exception(
				"Cannot find {$method}"
			);
		}

		return $controller->$method();
	}
}


?>