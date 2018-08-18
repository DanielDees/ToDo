<?php  

namespace ToDo\Models;

/**
* The Button class ouptuts custom buttons based on settings provided
*/
class Button
{
	//Accepts an associative array
	public static function create_group($buttons)
	{
		$result = "";

		$num = count($buttons);

		for ($i=0; $i < $num; $i++) 
		{	
			$text = current(array_keys($buttons));
			$button = array_shift($buttons);
			$button_icon = "<span class='fas " . $button['icon'] . " fa-fw'></span> ";

			$result .= "<button type='submit' ";

			foreach ($button as $key => $value) 
			{
				if ($key == 'class' && $num == 1) {
					$result .= $key . "='btn " . $value . " " . "group-btn'";
				}
				else if ($key == 'class' && $i == 0) {
					$result .= $key . "='btn " . $value . " " . "group-btn-left'";
				}
				else if ($key == 'class' && $i == $num - 1) {
					$result .= $key . "='btn " . $value . " " . "group-btn-right'";
				}
				else if ($key == 'class') {
					$result .= $key . "='btn " . $value . " " . "group-btn-center'";
				}
				else if ($key != "icon") {
					$result .= $key . "='" . $value . "'";
				}
			}
			$result .= ">" . $button_icon . $text . "</button>";
		}

		return $result;
	}

	public static function get_usable($account_type, $archived) 
	{
		$buttons = [];

		//Get buttons for appropriate page / account type permmissions
		if ($archived) 
		{
			if ($account_type != 'User')
			{
				$buttons['Restore'] = Button::archive('task');	
			}

			if ($account_type == 'Admin') 
			{
				$buttons['Delete'] = Button::delete('task');
			}

			return $buttons;
		}
		
		if ($account_type != 'User') 
		{
			$buttons['Edit'] = Button::edit('task');
			$buttons['Archive'] = Button::archive('task');
		}

		return $buttons;
	}

	public static function edit($name, $size = 2) {
		return [
			'class' => 'btn-success edit-' . $name . ' col-sm-' . $size,
			'icon' => 'fa-edit'
		];
	}

	public static function archive($name, $size = 2) {
		return [
			'class' => 'btn-warning archive-' . $name . ' col-sm-' . $size,
			'icon' => 'fa-minus-square'
		];
	}

	public static function delete($name, $size = 2) {
		return [
			'class' => 'btn-danger delete-' . $name . ' col-sm-' . $size,
			'icon' => 'fa-trash-alt'
		];
	}

	public static function user($size = 12) {
		return [
			'class' => 'btn-success edit-account col-sm-' . $size,
			'icon' => 'fa-user',
		];
	}

	public static function editor($size = 12) {
		return [
			'class' => 'btn-warning edit-account col-sm-' . $size,
			'icon' => 'fa-user-edit',
		];
	}

	public static function admin($size = 12) {
		return [
			'class' => 'btn-danger edit_account col-sm-' . $size,
			'icon' => 'fa-user-cog',
		];
	}
}

?>