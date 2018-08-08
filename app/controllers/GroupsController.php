<?php  

namespace ToDo\Controllers;

use Core\App;

use ToDo\Models\Button;
use ToDo\Models\Group;
use ToDo\Models\Account;

/**
* The GroupsController handles creation, modification, and deletion of user groups
*/
class GroupsController
{
	//Determine which Group action to perform
	public function query_group() 
	{
		if (!isset($_SESSION)) 
		{ 
			session_start(); 
		}

		if (isset($_POST['submit-group']) && $_POST['title']) 
		{
			return GroupsController::submit();
		}
		if (isset($_POST['update-form'])) 
		{
			return GroupsController::update_form();
		}
		if (isset($_POST['update-group'])) 
		{
			return GroupsController::update();
		}
		if (isset($_POST['leave-group'])) 
		{
			GroupsController::leave();
		}
		if (isset($_POST['join-group'])) 
		{
			return GroupsController::join();
		}

		//Admin Controls
		if (isset($_SESSION['logged_in']) && $_SESSION['account_type'] == 'Admin') 
		{
			if (isset($_POST['delete-group'])) {
				return Group::delete(); 
			}
		}

		return json_encode([
				'groups' => $_POST
			]);
	}

	public function get_all() 
	{
		$groups = Group::get_all();
		
		$group_html = Group::display_all($groups);
	
		return json_encode([ 
			'groups' => $group_html
		]);
	}

	public function submit() 
	{
		$title = [
			'title' => $_POST['title']
		];

		$group = Group::submit($title);

		$response .= "<div id='group-" . $group->id . "-container'>";

		$response .= Group::display($group);

		$response .= static::get_group_buttons($group);

		$response .= '</div>';

		return json_encode([
			'group' => $response
		]);
	}

	public function update()
	{
		$id = Group::update();

		$group = App::get('database')->select('groups', $id);

		$response = Group::display($group);

		$response .= static::get_group_buttons($group);

		return json_encode([
			'group' => $response
		]);
	}

	public function get_group_buttons($group) 
	{
		$result = '';

		$group_buttons['Edit'] = Button::edit('group');
		$group_buttons['Delete'] = Button::delete('group');
			
		foreach ($group_buttons as &$button) {
			$button['data-id'] = $group->id;
		}

		$result .= "<div class='row justify-content-center'>";
		$result .= Button::create_group($group_buttons);
		$result .= "</div>";

		return $result;
	}

	public function update_form()
	{
		$group = App::get('database')->select('groups', $_POST['id']);

		$response = Group::form(	'update', 
									$group->id, 
									$group->title);

		return json_encode([
			'update-form' => $response
		]);
	}

	public function leave() 
	{
		$user_id = $_SESSION['user_id'];

		Group::remove_user($user_id);
	}

	public function join() 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		$user_id = $_SESSION['user_id'];

		Group::add_user($user_id);

		$user = App::get('database')->select('users', $user_id);

		$attributes = ['username', 'email'];

		return json_encode([
			'user' => Account::display($user, $attributes)
		]);
	}
}

?>