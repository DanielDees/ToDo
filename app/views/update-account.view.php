<?php 
	require 'partials/header.php'; 

	use ToDo\Models\Account;
	use ToDo\Models\Button;
?>

<h1 class="text-center">Account Settings</h1>

<form method="POST" action="/query-user">

	<div class='row justify-content-center'>
		<div class="form-group col-sm-3">
			<label>Username:</label>
			<input 	type="text"
					class="form-control"
					name="username" 
					maxlength="60"
					value="<?php echo $user->username; ?>"
					placeholder="Title..."
					required>
		</div>
	</div>

	<div class='row justify-content-center'>
		<div class="form-group col-sm-3">
			<label>Email:</label>
			<input 	type="text"
					class="form-control"
					name="email" 
					maxlength="60"
					value="<?php echo $user->email; ?>"
					placeholder="Title..."
					required>
		</div>
	</div>
	
	<div class='row justify-content-center'>
		<div class="form-group col-sm-3">
			<label for="role">Account Type:</label>
			<select name="role_id" class="form-control">
				<?php 
					for ($i=0; $i < count($roles); $i++) { 
						$select = ($user->role_id == $roles[$i]->id ? 'selected' : '');
						
						echo "<option value='" . 
								$roles[$i]->id . "' " . $select . '>' . 
								$roles[$i]->title . 
							"</option>";
					};
				?>
			</select>
		</div>
	</div>

	<div class='row justify-content-center'>
		<label class="form-check form-check-label">
			<input 	type="checkbox" 
					class="form-check-input" 
					name="reset-password">Reset Password</label>
	</div><br>

	<div class="row justify-content-center">
		<button type="submit"
				class='btn btn-primary bg-info col-sm-3'
				name='update-user' 
				value="<?php echo $user->id; ?>">
				<span class="fas fa-save fa-fw"></span> Save Changes
			</button>
	</div><br>
</form>

<form method="POST" action="/query-user">
	<div class="row justify-content-center">
		<button type="submit"
				class='btn btn-primary bg-danger col-sm-3'
				name='delete-user' 
				value="<?php echo $user->id; ?>">
				<span class="fas fa-trash-alt fa-fw"></span> Delete User
			</button>
	</div><br>
</form>

<?php require 'partials/footer.php'; ?>