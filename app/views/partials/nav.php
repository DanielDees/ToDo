<?php 
	use ToDo\Models\Navbar; 

	//Public
	$links = [
		'<i class="fas fa-home"></i> Home' => '/home',
	];

	if ($_SESSION['logged_in']) {

		//All users
		$links['Tasks'] = '/tasks';
		$links['Groups'] = '/groups';
		$links['Submit New Task'] = '/submit-task-view';

		if ($_SESSION['account_type'] == "Editor") 
		{
			$links['Editor-Controls'] = [ 
				'Archive' => '/archive',
				'Categories' => '/categories',
			];
		}
		
		if ($_SESSION['account_type'] == "Admin") 
		{
			$links['Admin-Controls'] = [ 
				'Archive' => '/archive',
				'Categories' => '/categories',
				'Users' => '/admin-panel',
			];
		}

		$links['<i class="fas fa-sign-out-alt"></i> Logout'] = '/logout';
		$login_symbol = 'user-circle';
	}

	if (!$_SESSION['logged_in'] && $page_title != 'Login') {
		$links['<i class="fas fa-sign-in-alt"></i> Login'] = '/login';
	}

	$navbar_attributes = "navbar navbar-expand-sm bg-secondary navbar-dark sticky-top";

	Navbar::display($links, $navbar_attributes);
?>