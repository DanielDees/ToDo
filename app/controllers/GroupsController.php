<?php  

namespace ToDo\Controllers;

use Core\App;

use ToDo\Models\Account;
use ToDo\Models\Button;
use ToDo\Models\Group;

/**
* The GroupsController handles creation, modification, and deletion of user groups
*/
class GroupsController
{
	//Determine which Group action to perform
	public static function query_group() 
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
		if (isset($_POST['remove-member'])) 
		{
			return GroupsController::remove_member();
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

	public static function get_all() 
	{
		$groups = Group::get_all();
		
		$group_html = Group::display_all($groups);
	
		return json_encode([ 
			'groups' => $group_html
		]);
	}

	public static function submit() 
	{
		$title = [
			'title' => $_POST['title']
		];

		$group = Group::submit($title);

		$response = '';

		$response .= "<div id='group-" . $group->id . "-container'>";

		$response .= Group::display($group);

		$response .= static::get_group_buttons($group);

		$response .= '</div>';

		return json_encode([
			'group' => $response
		]);
	}

	public static function update()
	{
		$id = Group::update();

		$group = App::get('database')->select('groups', $id);

		$response = Group::display($group);

		$response .= static::get_group_buttons($group);

		return json_encode([
			'group' => $response
		]);
	}

	public static function get_group_buttons($group) 
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

	public static function update_form()
	{
		$group = App::get('database')->select('groups', $_POST['id']);

		$response = Group::form(	'update', 
									$group->id, 
									$group->title);

		return json_encode([
			'update-form' => $response
		]);
	}

	public static function leave() 
	{
		$user_id = $_SESSION['user_id'];

		Group::remove_user($user_id);
	}

	public static function join() 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		$user_id = $_SESSION['user_id'];

		Group::add_user($user_id);

		$user = App::get('database')->select('users', $user_id);

		$response = '';

		$response .= "<div id='user-" . $user->id . "-container'>";

		$response .= Account::display($user, ['username', 'email']);

		$response .= static::get_group_user_buttons($user_id);

		$response .= '</div>';

		return json_encode([
			'user' => $response,
			'leave-group' => Group::leave_form($_POST['group_id']),
		]);
	}

	public static function remove_member() 
	{
		return json_encode([
			'user' => Group::remove_user($_POST['user_id']),
		]);
	}

	public static function get_group_user_buttons($user_id) 
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		$response = '';

		if ($_SESSION['account_type'] != 'User') 
		{
			$user_buttons['Remove User'] = Button::delete('group-user', 12);

			foreach ($user_buttons as &$button) 
			{
				$button['data-user-id'] = $user_id;
				$button['data-group-id'] = $_POST['group_id'];
			}

			$response .= Button::create_group($user_buttons);
		}

		return $response;
	}
}

?>