<?php  

namespace ToDo\Models;

use Core\App;

/**
* The Group class handles all Group creation, modification, and output.
*/
class Group
{
	private const DISPLAY_ATTRIBUTES = ['title'];

	//Accepts an associative array
	public static function get($filters)
	{
		return App::get('database')->where('groups', $filters);
	}

	public static function get_all() {
		return App::get('database')->select_all('groups');
	}

	public static function display_all($groups) {

		if (!$groups) {
			$result .= "<div id='no-groups-warning'><br><h3>No groups yet...</h3><br></div>";
		}

		foreach ($groups as $group) 
		{
			$result .= "<div id='group-" . $group->id . "-container'>";

			$result .= static::display($group);
	
			$result .= "</div>";
		}

		return $result;
	}

	public static function display($group) 
	{
		$result = '';
		$result .= '<br><ul class="list-group">';
		
		foreach($group as $key => $value) {
			if (in_array($key, static::DISPLAY_ATTRIBUTES)) {

				$result .= '<div class="row justify-content-center">';

				$result .= "<li class='col-sm-6 text-center list-group-item list-group-item-info";

				$result .= "' data-id='" . $group->id . "'>";

				$result .= nl2br(htmlentities($value));

				$result .= "</li>";

				$result .= "</div>";
			}
		}
		
		$result .= "</ul>";

		return $result;
	}

	public static function form($type, $id = null, $title = '') {

		$form = '<br><div class="row justify-content-center">';
		
		$form .= '<input type="text" 
						class="form-control col-sm-4"
						id="'. $type . '-group-title" 
						maxlength="20" 
						placeholder="New Group..."
						value="' . $title . '" 
						required>';

		$form .= '<br></div>';

		$form .= '<div class="row justify-content-center">';

		$form .= '<button id="' . $type . '-group" class="btn btn-primary bg-success col-sm-2" data-id="' . $id . '"><span class="fas fa-plus-circle"></span> Submit</button>';
		
		$form .= '</div><br>';

		return $form;
	}

	//Join form and leave form can be merged with some tweaks
	//'user_form' might be a good function name since 'form' is taken
	public static function join_form($group_id = null, $text = 'Join Group') 
	{
		return '<button 
			id="join-group" ' .
			'class="btn btn-primary bg-success col-sm-2" ' . 
			'data-id="' . $group_id . ' ">' . 
			'<span class="fas fa-plus-circle fa-fw"></span> ' . $text . '</button>';
	}

	//Join form and leave form can be merged with some tweaks
	//'user_form' might be a good function name since 'form' is taken
	public static function leave_form($group_id = null, $text = 'Leave Group') 
	{
		return '<button 
			id="leave-group" ' .
			'class="btn btn-primary bg-danger col-sm-2" ' . 
			'data-id="' . $group_id . ' ">' . 
			'<span class="fas fa-minus-circle fa-fw"></span> ' . $text . '</button>';
	}

	public static function delete()
	{
		App::get('database')->delete('groups', $_POST['id']);

		return $_POST['id'];
	}

	public static function submit($group) 
	{
		$id = App::get('database')->insert('groups', $group);

		return App::get('database')->select('groups', $id);
	}

	public static function update() 
	{
		$condition = [
			'id' => $_POST['id']
		];

		$values = [
			'title' => $_POST['title']
		];

		App::get('database')->update('groups', $values, $condition);

		return $_POST['id'];
	}

	public static function remove_user($id) 
	{
		$info = [
			'user_id' => $id,
			'group_id' => $_POST['group_id'],
		];

		App::get('database')->delete_where('group_users', $info);

		return $id;
	}

	public static function add_user($id) 
	{
		$info = [
			'user_id' => $id,
			'group_id' => $_POST['group_id'],
		];

		$duplicate = App::get('database')->where('group_users', $info);

		if ($duplicate) 
		{
			return false;
		}

		$id = App::get('database')->insert('group_users', $info);

		return App::get('database')->select('users', $info->user_id);
	}
}

?>