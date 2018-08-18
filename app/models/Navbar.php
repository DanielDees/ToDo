<?php 

namespace ToDo\Models;

/**
* The NavBar Class will dynamically create a navbar for displaying
* the proper links for the end user based on their login privileges.
*/
class Navbar {
	
	/*	
	 *	$data is an associative array that gets passed in the format:
 	 *	'link name' => 'destination.view.php'
 	 *
 	 * 	All links are shown in the same order as they are in the links array.
 	*/
	public static function display($links, $attributes) {

		//Default grey navbar
		if (!$attributes) {
			$attributes = "navbar navbar-expand-sm bg-secondary navbar-dark sticky-top";
		}

		echo "<nav class='" . $attributes . "'>";
		echo "<ul class='navbar-nav'>";

		//Output each nav link
		foreach ($links as $link_text => $destination) 
		{
			if (is_array($links[$link_text])) 
			{
				NavBar::dropdown($link_text, $links[$link_text]);
				continue;
			}

			echo "<li class='nav-item'>" .
					"<a class='nav-link' href='" . $destination . "'>" . $link_text . "</a>" .
				"</li>";
		};

		echo "</ul>";
		echo "</nav>";
	}

	public static function dropdown($title, $links) 
	{
		echo "<li class='nav-item dropdown'>";
		echo "<a class='nav-link dropdown-toggle' 
				data-toggle='dropdown' 
				href='#'>" . $title . " <span class='caret'></span></a>";

		echo "<div class='dropdown-menu'>";

		//Output each dropdown link
		foreach ($links as $link_text => $destination) 
		{
			echo "<a class='dropdown-item' href='" . $destination . "'>" . $link_text . "</a>";
		};

		echo "</div>";

		echo "</li>";
	}
}

?>