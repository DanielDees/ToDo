<?php 

namespace ToDo\Models;

/**
* The TableBuilder Class will dynamically create tables for displaying
* data for the end user.
*/
class TableBuilder {
	
	//$data is an associative array that gets passed.
	//The first item in the array is the header.
	public function build($data, $attributes) {
		
		echo "<table class='" . $attributes . "'>";

			echo "<thead>" . 
					"<tr>" . 
						"<th>" . current(array_keys($data)) . "</th>" . 
						"<th>" . array_shift($data) . "</th>" . 
					"</tr>" .
				"</thead>";

			echo "<tbody>";
				foreach ($data as $key => $value) {
					echo "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
				};
			echo "</tbody>";

		echo "</table>";
	}
}


?>