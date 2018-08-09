<?php  

namespace ToDo\Models;

use Core\App;

/**
* The Account class handles creation and modifications of users
* Note: ADMIN accounts must be deleted manually!
*/
class Account
{
	public function get_role($id) 
	{
		$role = App::get('database')->select('roles', $id);

		return "Account Type: " . $role->title;
	}

	public function get_username($username) 
	{
		return $username;
	}

	public function get_email($email) 
	{
		return $email;
	}

	public function display($user, $attributes) 
	{	
		$style = App::get('database')->select('roles', $user->role_id)->style;

		$result = '<ul class="list-group">';

		foreach($user as $key => $value) 
		{
			if (in_array($key, $attributes)) 
			{
				$result .= "<li class='list-group-item list-group-item-" . $style . "'>";

				if ($key == 'username') {
					$result .= static::get_username($value);
				}
				else if ($key == 'email') {
					$result .= static::get_email($value);
				}
				else if ($key == 'role_id') {
					$result .= static::get_role($value);
				}
				else {
					$result .= nl2br(htmlentities($value));
				}

				$result .= "</li>";
			}
		}

		$result .= "</ul>";

		return $result;
	}

	//Checks if account information is valid
	public function validate($user) 
	{
		$email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);

		$valid_email = filter_var($email, FILTER_VALIDATE_EMAIL);

		if (!$valid_email) {
		 	return false;
		}

		$new_user = [
			'username' => $user['username'],
			'email' => $email
		];

		$duplicate = App::get('database')->where('users', $new_user);

		if (!empty($duplicate)) {
			return false;
		}

		return true;
	}

	//Accepts associative array
	public function create($user) 
	{
		App::get('database')->insert('users', $user);

		$message = "Thank you for creating your account!" . 
					"\n\nAccount Details:" . 
					"\n\nUsername: " . $user['username'];

		mail($user['email'], "ToDo Account Created", $message);

		return true;
	}

	public function update() 
	{
		$condition = [
			'id' => $_POST['update-user']
		];

		unset($_POST['update-user']);	

		if (isset($_POST['change-password']) && $_POST['change-password'] == $_POST['change-password-confirm']) 
		{
			$_POST['password'] = Account::set_password($_POST['change-password']);

			unset($_POST['change-password']);
			unset($_POST['change-password-confirm']);
		}

		foreach ($_POST as $key => $value) 
		{
			if ($value !== '') 
			{
				$values[$key] = $value;
			}	
		}

		App::get('database')->update('users', $values, $condition);
		
	 	static::reset_password($condition);
	}

	public function delete() 
	{
		$user = App::get('database')->select('users', $_POST['delete-user']);

		//Admin accounts must be manually deleted from database
		if ($user->role_id == '3') {	
			return false;
		}

		App::get('database')->delete('users', $_POST['delete-user']);

		return $_POST['id'];
	}

	public function set_password($password) 
	{
		$options = [
			'cost' => 10
		];

		//Encrypt password
		return password_hash($password, PASSWORD_DEFAULT, $options);
	}

	public function reset_password($condition) 
	{
		if (isset($_POST['reset-password'])) 
		{	
			//Generate temporary password and email to user
			$bytes = openssl_random_pseudo_bytes(4);

			$temp = bin2hex($bytes);

			$password = ['password' => static::set_password($temp)];

			$message = "Your ToDo account password has been reset. Please use this temporary password to login." . 
				"\n\n Password: " . $temp;

			mail($_POST['email'], "ToDo Password Reset", $message);

			App::get('database')->update('users', $password, $condition);
		}
	}

	public function logout() 
	{
		session_start();
		session_destroy();
	}
}

?>