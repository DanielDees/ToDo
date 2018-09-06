<?php  

namespace ToDo\Controllers;

// use ToDo\Controllers\PagesController;
use ToDo\Models\Account;
use Core\App;

/**
* The UsersController handles any requests made
* that require queries to be performed on users
*/
class UsersController
{
	//Determine which task action to perform
	public function query_user() 
	{
		if (isset($_POST['create-user'])) {
			return UsersController::create_user();
		}
		if (isset($_POST['update-user'])) {
			UsersController::update_user();
			return true;
		}
		if (isset($_POST['delete-user'])) {
			UsersController::delete_user();
			return true;
		}

		redirect('error_404');
	}

	public function create_user() 
	{
		$password = Account::set_password($_POST['password']);

		$user = [
			'username' => $_POST['username'],
			'email' => $_POST['email'],
			'password' => $password,
		];

		//Prevent duplicate accounts
		$valid = Account::validate($user);

		if (!$valid) {
			return json_encode([
				'valid' => false
			]);
		}

		Account::create($user);
		
		return json_encode([
			'valid' => true
		]);
	}

	public function update_user()
	{
		Account::update();

		redirect('admin-panel');
	}

	public function delete_user()
	{
		Account::delete();

		redirect('admin-panel');
	}
}

?>