<?php  

namespace ToDo\Models;

use Core\App;

/**
* The Category class handles all task category creation, modification, and output.
*/
class Category
{
	private const DISPLAY_ATTRIBUTES = ['title'];

	//Accepts an associative array
	public static function get($filters)
	{
		return App::get('database')->where('categories', $filters);
	}

	public static function get_all() {
		return App::get('database')->select_all('categories');
	}

	public static function display_all($categories) {

		if (!$categories) {
			$result .= "<div id='no-categories-warning'><br><h3>No Categories yet...</h3><br></div>";
		}

		foreach ($categories as $category) 
		{
			$result .= "<div id='category-" . $category->id . "-container'>";

			$result .= static::display($category);
	
			$result .= "</div>";
		}

		return $result;
	}

	public static function display($category) 
	{
		$result = '';
		$result .= '<br><ul class="list-group">';
		
		foreach($category as $key => $value) {
			if (in_array($key, static::DISPLAY_ATTRIBUTES)) {

				$result .= '<div class="row justify-content-center">';

				$result .= "<li class='col-sm-6 text-center list-group-item list-group-item-info";

				$result .= "' data-id='" . $category->id . "'>";

				$result .= nl2br(htmlentities($value));

				$result .= "</li>";

				$result .= "</div>";
			}
		}
		
		$result .= "</ul>";

		return $result;
	}

	public static function form($type, $id = null, $title = '') {

		$form = '<br><div class="row justify-content-center">';
		
		$form .= '<input type="text" 
						class="form-control col-sm-4"
						id="'. $type . '-category-title" 
						maxlength="20" 
						placeholder="Title..."
						value="' . $title . '" 
						required>';

		$form .= '<br></div>';

		$form .= '<div class="row justify-content-center">';

		$form .= '<button id="' . $type . '-category" class="btn btn-primary bg-success col-sm-2" data-id="' . $id . '"><span class="fas fa-plus-circle"></span> Submit</button>';
		
		$form .= '</div>';

		return $form;
	}

	public static function delete()
	{
		App::get('database')->delete('categories', $_POST['id']);

		return $_POST['id'];
	}

	public static function submit($category) 
	{
		$id = App::get('database')->insert('categories', $category);

		return App::get('database')->select('categories', $id);
	}

	public static function update() 
	{
		$condition = [
			'id' => $_POST['id']
		];

		$values = [
			'title' => $_POST['title']
		];

		App::get('database')->update('categories', $values, $condition);

		return $_POST['id'];
	}
}

?>