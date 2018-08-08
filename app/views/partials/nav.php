<?php 
	use ToDo\Models\Navbar; 

	//Default links available to all users
	$links = [
		'<i class="fas fa-home"></i> Home' => '/home',
		'Tasks' => '/tasks'
	];

	$login_symbol = 'sign-in-alt';

	if (!$_SESSION['logged_in'] && $page_title != 'Login') {
		$links['<i class="fas fa-sign-in-alt"></i> Login'] = '/login';
	}

	if ($_SESSION['logged_in']) {

		if ($_SESSION['account_type'] == "User") {
			$links['Submit New Task'] = '/submit-task-view';
		}

		if ($_SESSION['account_type'] == "Editor") {
			$links['Submit New Task'] = '/submit-task-view';

			$links['Editor-Controls'] = [ 
				'Archive' => '/archive',
				'Categories' => '/categories',
				'Groups' => '/groups',
			];
		}
		
		if ($_SESSION['account_type'] == "Admin") {
			$links['Submit New Task'] = '/submit-task-view';
	
			$links['Admin-Controls'] = [ 
				'Archive' => '/archive',
				'Categories' => '/categories',
				'Groups' => '/groups',
				'Users' => '/admin-panel',
			];
		}

		$links['<i class="fas fa-sign-out-alt"></i> Logout'] = '/logout';
		$login_symbol = 'user-circle';
	}

	$navbar_attributes = "navbar navbar-expand-sm bg-secondary navbar-dark sticky-top";

	Navbar::display($links, $navbar_attributes);
?>