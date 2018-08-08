<?php  

namespace ToDo\Models;

use Core\App;
use DateTime;

/**
* The Comment class handles all task comment creation, modification, and output.
*/
class Comment
{
	private const DISPLAY_ATTRIBUTES = ['author_id', 'content', 'date'];

	//Accepts an associative array
	public function get($filters)
	{
		return App::get('database')->where('task_comments', $filters);
	}

	public function get_task($task_id)
	{
		return App::get('database')->where('tasks', ['id' => $task_id])[0]->title;
	}

	public function get_author($author_id)
	{
		return App::get('database')->where('users', ['id' => $author_id])[0]->username;
	}

	public function get_date($date) 
	{
		$msg = date_format(new DateTime($date), "l, M d, Y \a\\t g:i A");

		return $msg;
	}

	public function display_all($comments) {

		if (!$comments) {
			$result .= "<div id='no-comments-warning'><br><h3>No comments yet...</h3><br></div>";
		}

		foreach ($comments as $comment) 
		{
			$result .= "<div id='comment-" . $comment->id . "-container'>";

			$result .= static::display($comment);
	
			$result .= "</div>";
		}

		return $result;
	}

	public function display($comment) 
	{
		$result = '';
		$result .= '<br><ul class="list-group">';
		
		foreach($comment as $key => $value) {
			if (in_array($key, static::DISPLAY_ATTRIBUTES)) {

				$result .= '<div class="row justify-content-center">';

				$result .= "<li class='col-sm-6 text-center list-group-item list-group-item-info";

				$result .= "' data-id='" . $comment->id . "'>";

				if ($key == 'author_id') {
					$result .= Comment::get_author($value);
				}
				else if ($key == 'task_id') {
					$result .= Comment::get_task($value);
				}
				else if ($key == 'date') {
					$result .= Comment::get_date($value);
				}
				else {
					$result .= nl2br(htmlentities($value));
				}

				$result .= "</li>";

				$result .= "</div>";
			}
		}

		$result .= "</ul>";

		return $result;
	}

	public function delete()
	{
		App::get('database')->delete('task_comments', $_POST['id']);

		return $_POST['id'];
	}

	public function submit($comment) 
	{
		$id = App::get('database')->insert('task_comments', $comment);

		return App::get('database')->select('task_comments', $id);
	}

	public function form($type, $id, $content = '') {

		$form = '<br><div class="row justify-content-center">';

		$form .= '<textarea id="' . $type . '-comment-content" 
							class="form-control col-sm-4"
							rows="4"
							placeholder="Content..."
							required>' . $content . '</textarea>';

		$form .= '<br></div>';

		$form .= '<div class="row justify-content-center">';

		$form .= '<button id="' . $type . '-comment" class="btn btn-primary bg-success col-sm-1" data-id="' . $id . '"><span class="fas fa-comment-dots"></span> Submit</button>';

		$form .= '</div>';

		return $form;
	}

	public function update() 
	{
		$condition = [
			'id' => $_POST['id']
		];

		$values = [
			'content' => $_POST['content']
		];

		App::get('database')->update('task_comments', $values, $condition);

		return $_POST['id'];
	}
}

?>