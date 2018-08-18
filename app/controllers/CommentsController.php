<?php  

namespace ToDo\Controllers;

use Core\App;

use ToDo\Models\Button;
use ToDo\Models\Comment;

/**
* The CommentsController handles creation, modification, and deletion of comments
*/
class CommentsController
{
	//Determine which comment action to perform
	public function query_comment() 
	{
		if (isset($_POST['submit-comment']) && $_POST['content']) 
		{
			return CommentsController::submit();
		}
		if (isset($_POST['update-form'])) 
		{
			return CommentsController::update_form();
		}
		if (isset($_POST['update-comment'])) 
		{
			return CommentsController::update();
		}
		if (isset($_POST['delete-comment'])) {
			return Comment::delete(); 
		}

		//Debug
		// return json_encode([
		// 		'comment' => 'CommentsController can\'t figure out what just happened!'
		// 	]);
	}

	public function get_all() 
	{
		$filters = [
			'task_id' => $_GET['task_id'] 
		];

		$comments = Comment::get($filters);
		
		$comment_html = Comment::display_all($comments);
	
		return json_encode([ 
			'comments' => $comment_html
		]);
	}

	public function submit() 
	{
		if (!isset($_SESSION)) 
		{ 
			session_start(); 
		}

		$response = '';

		$comment_data = [
			'author_id' => $_SESSION['user_id'],
			'task_id' => $_POST['task_id'],
			'content' => $_POST['content']
		];

		$comment = Comment::submit($comment_data);

		$response .= "<div id='comment-" . $comment->id . "-container'>";

		$response .= Comment::display($comment);

		$response .= static::get_comment_buttons($comment);

		$response .= '</div>';

		return json_encode([
			'comment' => $response
		]);
	}

	public function update_form()
	{
		$comment = App::get('database')->select('task_comments', $_POST['id']);

		$response = Comment::form(	'update', 
									$comment->id, 
									$comment->content);

		return json_encode([
			'update-form' => $response
		]);
	}

	public function update()
	{
		$id = Comment::update();

		$comment = App::get('database')->select('task_comments', $id);

		$response = Comment::display($comment);

		$response .= static::get_comment_buttons($comment);

		return json_encode([
			'comment' => $response
		]);
	}

	public function get_comment_buttons($comment) 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		if (!$_SESSION['logged_in']) {
			return false;
		}

		$result = '';

		if ($_SESSION['user_id'] == $comment->author_id) 
		{
			$comment_buttons['Edit'] = Button::edit('comment');
			$comment_buttons['Delete'] = Button::delete('comment');
		}

		else if ($_SESSION['account_type'] == 'Admin') 
		{
			$comment_buttons['Delete'] = Button::delete('comment');
		}

		if (isset($comment_buttons)) {

			foreach ($comment_buttons as &$button) {
				$button['data-id'] = $comment->id;
			}

			$result .= "<div class='row justify-content-center'>";
			$result .= Button::create_group($comment_buttons);
			$result .= "</div>";
		}

		return $result;
	}

}

?>