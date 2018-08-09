<?php  

//Eror pages
$router->get('error_404', 'PagesController@error_404');
//END Eror pages

//PagesController
$router->get('', 'PagesController@home');
$router->get('home', 'PagesController@home');
$router->get('tasks', 'PagesController@tasks');
$router->get('groups', 'PagesController@groups');
$router->get('account', 'PagesController@account');
$router->get('archive', 'PagesController@archive');
$router->get('categories', 'PagesController@categories');
$router->get('admin-panel', 'PagesController@admin_panel');

$router->get('login', 'PagesController@login');
$router->get('logout', 'PagesController@logout');
$router->get('create-account', 'PagesController@create_account');
$router->get('update-account', 'PagesController@update_user');

$router->get('submit-task-view', 'PagesController@submit_task');
$router->get('update-task-view', 'PagesController@update_task');

$router->get('view-task-view', 'PagesController@view_task');
$router->get('view-group-view', 'PagesController@view_group');

$router->post('user-login', 'PagesController@user_login');

$router->post('get_filtered', 'PagesController@get_filtered');
//END PagesController

//TasksController
$router->post('query-task', 'TasksController@query_task');
//END TasksController

//UsersController
$router->post('query-user', 'UsersController@query_user');
//END UsersController

//CommentsController
$router->get('get-comments', 'CommentsController@get_all');

$router->post('query-comment', 'CommentsController@query_comment');
//END CommentsController

//CategoriesController
$router->get('get-categories', 'CategoriesController@get_all');

$router->post('query-category', 'CategoriesController@query_category');
//END CategoriesController

//GroupsController
$router->get('get-groups', 'GroupsController@get_all');

$router->post('query-group', 'GroupsController@query_group');
//END GroupsController

?>