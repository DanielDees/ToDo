<?php  

namespace ToDo\Controllers;

use Core\App;

use ToDo\Models\Account;
use ToDo\Models\Button;
use ToDo\Models\Category;
use ToDo\Models\Comment;
use ToDo\Models\Filter;
use ToDo\Models\Group;
use ToDo\Models\Task;

/**
* The PagesController redirects to the apropriate 
* view within the website and provides the page
* with any necessary data for customization.
*/
class PagesController
{
	public function home() 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		$page_title = "Home";

		$table_attributes = "table table-striped table-sm table-bordered text-center";

		$table_data = [
			"Language" => "Proficiency",
			"PHP" => "Good",
			"JavaScript" => "Good",
			"HTML5" => "Good", 
			"VBA" => "Average",
			"MySQL" => "Passable",
			"CSS" => "Passable",
			"C++" => "Passable",
			"C#" => "Passable"
		];

		$data = compact('page_title', 
						'table_attributes', 
						'table_data');

		return view('index', $data);
	}

	public function error_404() 
	{
		$page_title = "Error 404!";

		$data = compact('page_title');

		return view('error_404', $data);
	}

	public function admin_panel() 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		if (!isset($_SESSION['logged_in']) || $_SESSION['account_type'] != 'Admin')
		{		
			redirect('home');
		}

		$page_title = 'Admin Panel';

		$users = App::get('database')->select_all('users');

		$data = compact('page_title', 
						'buttons',
						'users');

		return view('admin-panel', $data);
	}

	public function login() 
	{
		$page_title = 'Login';

		$data = compact('page_title');

		return view('login', $data);
	}

	public function logout() 
	{
		Account::logout();

		redirect('home');
	}

	public function user_login() 
	{
		$user_info = [
			'username' => $_POST['username'],
			'email' => $_POST['email']
		];

		$user = App::get('database')->where('users', $user_info)[0];

		//No account / invalid password
		if ($user == null || !password_verify($_POST['password'], $user->password)) {
			redirect('login');
			return false;
		}

		//The SESSION could just have the user set as a variable and accessed as what it is; a class. $_SESSION['user'] = $user;
		session_start();
		$_SESSION['logged_in'] = true;
		$_SESSION['user_id'] = $user->id;
		$_SESSION['username'] = $user->username;

		$role = App::get('database')->select('roles', $user->role_id);
		$_SESSION['account_type'] = $role->title;

		redirect('home');
		return true;
	}

	//Create new account page
	public function create_account() {

		$page_title = 'Create Account';

		$data = compact('page_title');

		return view('create-account', $data);
	}

	public function update_user() 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		if (!isset($_SESSION['logged_in']) || $_SESSION['account_type'] != 'Admin')
		{		
			redirect('home');
		}

		$user = App::get('database')->select('users', $_GET['id']);
		
		$page_title = 'Account Settings';

		$roles = [];

		$user_roles = App::get('database')->select_all('roles');

		foreach ($user_roles as $role) {
			if ($role->id != '3' /* Admin */) {
				array_push($roles, $role);
			}
		}

		$data = compact('user', 'page_title', 'roles');

		return view('update-account', $data);
	}

	public function archive() 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		if (!isset($_SESSION['logged_in']) || $_SESSION['account_type'] == 'User')
		{		
			redirect('home');
		}
	
		$page_title = 'Archive';

		$data = compact('page_title');

		return view('archive', $data);
	}

	public function categories() 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		if (!isset($_SESSION['logged_in']) || $_SESSION['account_type'] == 'User')
		{		
			redirect('home');
		}

		$page_title = 'Categories';

		$categories = Category::get_all();

		$data = compact('page_title', 'categories');

		return view('categories', $data);
	}

	public function groups() 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		if (!isset($_SESSION['logged_in']) || $_SESSION['account_type'] == 'User')
		{
			redirect('home');
		}

		$page_title = 'Groups';

		$groups = Group::get_all();

		$data = compact('page_title', 'groups');

		return view('groups', $data);
	}

	public function get_filtered() 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		Filter::set();

		$order = [
			'archive_date' => 'DESC',
			'title' => 'ASC'
		];

		$tasks = Task::get($_SESSION['filter'], $order);

		$task_html = Task::display_all($tasks, ['title']);

		$page_head = 'Tasks';

		if ($_SESSION['filter']['archived']) 
		{
			$page_head = "Archived Tasks";
		}

		return json_encode([ 
			'tasks' => $task_html,
			'page_head' => $page_head,
			'debug' => $_SESSION['filter']
		]);
	}

	public function tasks()
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		if (!isset($_SESSION['logged_in']))
		{		
			redirect('home');
		}

		$page_title = 'Tasks';

		$data = compact('page_title');

		return view('tasks', $data);
	}

	public function submit_task() 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		if (!isset($_SESSION['logged_in']))
		{		
			return $this->home();
		}

		$task_categories = [];
		$task_priorities = [];
		$task_statuses = [];

		$task_attributes = ['categories', 'priorities', 'statuses'];

		foreach ($task_attributes as $attribute) 
		{
			$options = App::get('database')->select_all($attribute);

			foreach ($options as $option) 
			{
				array_push(${'task_' . $attribute}, $option);
			}			
		}

		$page_title = 'Submit Task';

		$data = compact('page_title', 
						'task_categories', 
						'task_priorities', 
						'task_statuses');

		return view('submit-task', $data);	
	}

	public function submit_comment() 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		if (isset($_SESSION['logged_in'])) 
		{	
			$data = [
				'page_title' => 'Add Comment'
			];

			return view('submit-comment', $data);
		}

		return $this->home();
	}

	public function update_task() 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		if (!isset($_SESSION['logged_in']))
		{		
			return $this->home();
		}

		$task = App::get('database')->select('tasks', $_GET['id']);
		
		$page_title = 'Edit Task';

		$task_categories = [];
		$task_priorities = [];
		$task_statuses = [];

		$task_attributes = ['categories', 'priorities', 'statuses'];

		foreach ($task_attributes as $attribute) 
		{
			$options = App::get('database')->select_all($attribute);

			foreach ($options as $option) 
			{
				array_push(${'task_' . $attribute}, $option);
			}			
		}

		$data = compact('task', 
						'page_title', 
						'task_statuses', 
						'task_categories', 
						'task_priorities');

		return view('update-task', $data);
	}

	public function view_task() 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		$task_buttons = [];

		$task = App::get('database')->select('tasks', $_GET['id']);

		$comments = Comment::get(['task_id' => $task->id]);

		if ($_SESSION['user_id'] == $task->author_id && $_SESSION['account_type'] == 'User') 
		{
			$task_buttons['Edit'] = Button::edit('task');
			$task_buttons['Delete'] = Button::archive('task');
		}
		else if (isset($_SESSION['logged_in'])) 
		{
			$task_buttons = Button::get_usable($_SESSION['account_type'], $_GET['archived'], $task);
		}
		
		$page_title = 'View Task';

		$task_attributes = ['content', 'status_id', 'priority_id', 'category_id', 'date', 'deadline'];

		$data = compact('task', 
						'comments',
						'page_title',
						'task_buttons',
						'task_attributes');

		return view('view-task', $data);
	}

	public function view_group() 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		$group_buttons = [];

		$group = App::get('database')->select('groups', $_GET['id']);

		$group_data = App::get('database')->where('group_users', ['group_id' => $_GET['id']]);

		if ($_SESSION['account_type'] != 'User') 
		{
			$group_buttons['Edit'] = Button::edit('group');
			$group_buttons['Delete'] = Button::delete('group');
		}
		
		$page_title = 'View Group';

		$data = compact('group', 
						'comments',
						'page_title',
						'group_data',
						'group_buttons');

		return view('view-group', $data);
	}
}

?>