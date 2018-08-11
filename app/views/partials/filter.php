<?php 
	use ToDo\Models\Filter;

	use Core\App;
	
	//echo "<pre>" , var_dump($_SESSION) , "</pre>";

	//The naming convention is what allows the filter partial to work.
	$statuses_options = ['' => 'All Statuses'];
	$priorities_options = ['' => 'All Priorities'];
	$categories_options = ['' => 'All Categories'];
	$groups_options = ['' => 'All Groups'];

	$filter_tables = [
		'statuses' => 'status_id', 
		'priorities' => 'priority_id', 
		'categories' => 'category_id',
		'groups' => 'group_id',
	];

	//Create each filter
	foreach ($filter_tables as $table => $column) 
	{
		foreach (App::get('database')->select_all($table) as $option) 
		{	
			${$table . '_options'}[$option->id] = $option->title;
		}
	}
		
	//Output each filter
	echo "<div class='row justify-content-center'>";

	foreach ($filter_tables as $table => $column) {
		Filter::display(${$table . '_options'}, $column, 2);
	}

	echo "</div>";
?>