<?php 
	use ToDo\Models\Filter;

	use Core\App;
	
	//echo "<pre>" , var_dump($_SESSION) , "</pre>";

	$status_options = ['' => 'All Statuses'];
	$priority_options = ['' => 'All Priorities'];
	$category_options = ['' => 'All Categories'];

	$filter_tables = [
		'statuses' => 'status_id', 
		'priorities' => 'priority_id', 
		'categories' => 'category_id'
	];

	// foreach ($filter_tables as $table => $column) 
	// {
	// 	echo "<div class='row justify-content-center'>";

	// 	foreach (App::get('database')->select_all($table) as $option) 
	// 	{	
	// 		${$table . '_options'}[$option->id] = $option->title;

	// 		Filter::display(${$table . '_options'}, $column, 2); 
	// 	}

	// 	echo "</div>";
	// }

	foreach (App::get('database')->select_all('statuses') as $option) 
	{	
		$status_options[$option->id] = $option->title;
	}

	foreach (App::get('database')->select_all('priorities') as $option) 
	{	
		$priority_options[$option->id] = $option->title;
	}

	foreach (App::get('database')->select_all('categories') as $option) 
	{	
		$category_options[$option->id] = $option->title;
	}

	echo "<div class='row justify-content-center'>";

	Filter::display($status_options, 'status_id', 2); 
	Filter::display($priority_options, 'priority_id', 2);
	Filter::display($category_options, 'category_id', 2);

	echo "</div>";

?>