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
				'<i class="fas fa-archive fa-fw"></i> Archive' => '/archive',
				'<i class="fas fa-book fa-fw"></i> Categories' => '/categories',
			];
		}
		
		if ($_SESSION['account_type'] == "Admin") 
		{
			$links['Admin-Controls'] = [ 
				'<i class="fas fa-archive fa-fw"></i> Archive' => '/archive',
				'<i class="fas fa-book fa-fw"></i> Categories' => '/categories',
				'<i class="fas fa-user fa-fw"></i> Users' => '/admin-panel',
			];
		}

		//Public
		$links['<i class="fas fa-user-circle fa-fw"></i> Account'] = [
			'<i class="fas fa-cog fa-fw"></i> Account Details' => '/account', 
			'<i class="fas fa-sign-out-alt fa-fw"></i> Logout' => '/logout',
		];
	}

	if (!$_SESSION['logged_in'] && $page_title != 'Login') {
		$links['<i class="fas fa-sign-in-alt"></i> Login'] = '/login';
	}

	$navbar_attributes = "navbar navbar-expand-sm bg-secondary navbar-dark sticky-top";

	Navbar::display($links, $navbar_attributes);
?>