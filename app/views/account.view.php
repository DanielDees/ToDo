<?php 
	require 'partials/header.php'; 

	use ToDo\Models\Account;
	use ToDo\Models\Button;
?>

<br>
<h1 class="text-center">Account Settings</h1>
<br>

<div class='row justify-content-center'>
	<div class='col-sm-3'>
		<?php echo Account::display($user, ['username', 'email', 'role_id']); ?>
	</div>
</div>
<br>

<form method="POST" action="/query-user">

	<div class='row justify-content-center'>
		<div class="form-group col-sm-3">
			<label>Change Password:</label>
			<input 	type="password"
					class="form-control"
					name="change-password" 
					maxlength="30" 
					pattern=".{8,}"
					title="Password must be at least 8 characters long!"
					placeholder="New Password..."
					required>
		</div>
	</div>

	<div class='row justify-content-center'>
		<div class="form-group col-sm-3">
			<label>Confirm Password:</label>
			<input 	type="password"
					class="form-control"
					name="change-password-confirm" 
					maxlength="30" 
					pattern=".{8,}"
					title="Re-enter the new password!"
					placeholder="Confirm Password..."
					required>
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


<?php require 'partials/footer.php'; ?>