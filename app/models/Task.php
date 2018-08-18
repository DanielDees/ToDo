<?php  

namespace ToDo\Models;

use Core\App;

use ToDo\Models\Button;

use DateTime;

use Carbon\Carbon;

/**
* The Task class handles all task creation, modification, and output.
*/
class Task
{
	//Accepts an associative array
	public static function get($filters, $order_by = null)
	{
		return App::get('database')->where('tasks', $filters, $order_by);
	}

	public static function get_deadline($attribute) 
	{
		$msg = "";
		
		$now = Carbon::now();
		$deadline = date2utc($attribute);
		$deadline_display = date_format(new DateTime($attribute), "l, M d, Y \a\\t g:i A");

		if ($deadline < $now) 
		{
			$msg .= "The task deadline has passed!";
		}
		else if ($deadline > $now) 
		{
			$time = $now->diff($deadline);
			$msg .= "Deadline: " . $deadline_display . "<br>";
			$msg .= "Time Remaining: ";

			if ($time->y > 0) { $msg .= $time->y . "Y "; }
			if ($time->m > 0) { $msg .= $time->m . "M "; }
			if ($time->d > 0) { $msg .= $time->d . "D "; }
			if ($time->h >= 0) { $msg .= $time->h . "h "; }
			if ($time->i >= 0) { $msg .= $time->i . "m "; }
			if ($time->s >= 0) { $msg .= $time->s . "s"; }
		}

		return $msg;
	}

	public static function get_priority($id) 
	{
		$priority = App::get('database')->select('priorities', $id);

		return "Priority: " . $priority->title;
	}

	public static function get_status($id) 
	{
		$status = App::get('database')->select('statuses', $id);

		return "Status: " . $status->title;
	}

	public static function get_category($id) 
	{
		$category = App::get('database')->select('categories', $id);

		return "Category: " . $category->title;
	}

	public static function get_group($id) 
	{
		$group = App::get('database')->select('groups', $id);

		return "Group: " . $group->title;
	}

	public static function get_date($date) 
	{
		return "Created: " . date_format(new DateTime($date), "l, M d, Y \a\\t g:i A");
	}

	//$attributes is an array where each value is a property of ecah task that is displayed
	public static function display_all($tasks, $attributes) 
	{
		$result = '';

		if (!$tasks) {
			$result .= "<br><h3>No Tasks found!</h3><br>";
		}

		foreach ($tasks as $task) 
		{
			$result .= "<div id='task-" . $task->id . "-container'>";

			$result .= static::display($task, $attributes);
	
			$result .= "</div>";
		}

		return $result;
	}

	//$attributes is an array where each value is a property that is displayed
	public static function display($task, $attributes) 
	{
		$style = App::get('database')->select('statuses', $task->status_id)->style;

		$result = '<br><ul class="list-group">';
		$result .= '<div class="row justify-content-center">';

		foreach($task as $key => $value) {
			if (in_array($key, $attributes) && $value !== null) {

				$result .= "<li class='col-sm-8 text-center list-group-item list-group-item-" . $style;

				$result .= "' data-id='" . $task->id . "'>";

				if ($key == 'status_id') {
					$result .= static::get_status($value);
				}
				else if ($key == 'priority_id') {
					$result .= static::get_priority($value);
				}
				else if ($key == 'category_id') {
					$result .= static::get_category($value);
				}
				else if ($key == 'group_id') {
					$result .= static::get_group($value);
				}
				else if ($key == 'date') {
					$result .= static::get_date($task->$key);
				}
				else if ($key == 'deadline') {
					$result .= static::get_deadline($task->$key);
				}
				else {
					$result .= nl2br(htmlentities($value));
				}

				$result .= "</li>";
			}
		}

		$result .= "</div>";
		$result .= "</ul>";

		return $result;
	}

	public static function delete()
	{
		App::get('database')->delete('tasks', $_POST['id']);

		$task = [
			'task_id' => $_POST['id']
		];

		App::get('database')->delete_where('task_comments', $task);

		return $_POST['id'];
	}

	public static function submit($author) 
	{
		$deadline = date2utc($_POST['deadline'])->toDateTimeString();

		foreach ($_POST as $key => $value) 
		{
			if ($value !== '') 
			{
				$task[$key] = $value;
			}	
		}

		$task['author_id'] = $author->id;
		$task['deadline'] = $deadline;

		App::get('database')->insert('tasks', $task);
	}

	public static function update() 
	{
		$condition = [
			'id' => $_POST['update-task']
		];

		unset($_POST['update-task']);

		foreach ($_POST as $key => $value) 
		{
			if ($value !== '') 
			{
				$values[$key] = $value;
			}	
		}

		App::get('database')->update('tasks', $values, $condition);
	}

	public static function archive() 
	{
		$task = App::get('database')->select('tasks', $_POST['id']);

		$values = [
			'archived' => (int) !$task->archived,
		];

		//CURRENT_TIMESTAMP format
		if (!$task->archived) 
		{
			$values['archive_date'] = date('Y-m-d G:i:s');
		}

		$condition = [
			'id' => $task->id
		];

		App::get('database')->update('tasks', $values, $condition);

		return $_POST['id'];
	}
}

?>