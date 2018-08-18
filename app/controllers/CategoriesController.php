<?php  

namespace ToDo\Controllers;

use Core\App;

use ToDo\Models\Button;
use ToDo\Models\Category;

/**
* The CategorysController handles creation, modification, and deletion of Categorys
*/
class CategoriesController
{
	//Determine which Category action to perform
	public function query_category() 
	{
		if (!isset($_SESSION)) 
		{ 
			session_start(); 
		}

		if (isset($_POST['submit-category']) && $_POST['title']) 
		{
			return CategoriesController::submit();
		}
		if (isset($_POST['update-form'])) 
		{
			return CategoriesController::update_form();
		}
		if (isset($_POST['update-category'])) 
		{
			return CategoriesController::update();
		}

		//Admin Controls
		if (isset($_SESSION['logged_in']) && $_SESSION['account_type'] == 'Admin') 
		{
			if (isset($_POST['delete-category'])) {
				return Category::delete(); 
			}
		}

		return json_encode([
				'categories' => $_POST
			]);
	}

	public static function get_all() 
	{
		$categories = Category::get_all();
		
		$category_html = Category::display_all($categories);
	
		return json_encode([ 
			'categories' => $category_html
		]);
	}

	public static function submit() 
	{
		$title = [
			'title' => $_POST['title']
		];

		$category = Category::submit($title);

		$response = '';

		$response .= "<div id='category-" . $category->id . "-container'>";

		$response .= Category::display($category);

		$response .= static::get_category_buttons($category);

		$response .= '</div>';

		return json_encode([
			'category' => $response
		]);
	}

	public static function update()
	{
		$id = Category::update();

		$category = App::get('database')->select('categories', $id);

		$response = Category::display($category);

		$response .= static::get_category_buttons($category);

		return json_encode([
			'category' => $response
		]);
	}

	public static function get_category_buttons($category) 
	{
		$result = '';

		$category_buttons['Edit'] = Button::edit('category');
		$category_buttons['Delete'] = Button::delete('category');
			
		foreach ($category_buttons as &$button) {
			$button['data-id'] = $category->id;
		}

		$result .= "<div class='row justify-content-center'>";
		$result .= Button::create_group($category_buttons);
		$result .= "</div>";

		return $result;
	}

	public static function update_form()
	{
		$category = App::get('database')->select('categories', $_POST['id']);

		$response = Category::form(	'update', 
									$category->id, 
									$category->title);

		return json_encode([
			'update-form' => $response
		]);
	}
}

?>