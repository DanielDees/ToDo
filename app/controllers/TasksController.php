<?php  

namespace ToDo\Controllers;

use ToDo\Controllers\PagesController;
use ToDo\Models\Task;
use Core\App;

/**
* The TasksController handles any requests made
* that require queries to be performed on tasks
*/
class TasksController
{
	//Determine which task action to perform
	public function query_task() 
	{
		if (!isset($_SESSION)) 
		{ 
			session_start(); 
		}

		if (isset($_POST['submit-task'])) {
			TasksController::submit_task();
			return true;
		}
		if (isset($_POST['update-task'])) {
			TasksController::update_task();
			return true;
		}
		if (isset($_POST['update-task-view'])) {
			PagesController::update_task();
			return true;
		}
		if (isset($_POST['archive'])) {
			return Task::archive();
		}

		//Admin Controls
		if (isset($_SESSION['logged_in']) && $_SESSION['account_type'] == 'Admin') 
		{
			if (isset($_POST['delete'])) {
				return Task::delete(); 
			}
		}

		redirect('error_404');
	}

	public function submit_task() 
	{
		if (!isset($_SESSION)) 
		{ 
			session_start(); 
		}

		$author = App::get('database')->select('users', $_SESSION['user_id']);

		Task::submit($author);

		redirect('tasks');
	}
	public function update_task()
	{
		Task::update();

		redirect('tasks');
	}
}

?>