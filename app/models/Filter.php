<?php  

namespace ToDo\Models;

use ToDo\Models\Task;
use ToDo\Models\Button;

/**
* The Filter class will handle the setting a filter on a list, and getting the results from it.
*/
class Filter
{
	public static function set() 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		if (!isset($_POST['filter'])) 
		{
			return false;
		}

		//Update SESSION with new filters. Retain old filters as well.
		foreach ($_POST['filter'] as $key => $value) 
		{
			$_SESSION['filter'][$key] = $value;

			if ($value === '') 
			{
				unset($_SESSION['filter'][$key]);		
			}	
		}

		return json_encode([
			'debug' => $_SESSION['filter']
		]);
	}

	public static function display($options, $filter_name = 'status_id', $size = '2') 
	{
		echo "<select class='form-control col-sm-". $size . "' id='filter_" . $filter_name . "'>";

		foreach ($options as $value => $text) { 	

			$selected = '';

			if ($_SESSION['filter'][$filter_name] == $value) {
				$selected = ' selected';
			}

			echo "<option value='" . $value ."'" . $selected . ">" . $text . "</option>";
		}

		echo "</select>";
	}
}

?>