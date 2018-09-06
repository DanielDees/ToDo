<?php require 'partials/header.php'; ?>

<h1>Login</h1>

<form id="user-form" action="user-login" method="POST">

	<div class="input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"><i class="fas fa-envelope fa-fw"></i></span>
			<input 	type="email"
					name="email"
					maxlength="50" 
					class="form-control"
					placeholder="Email..."
					required>
		</div>
	</div>

	<div class="input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"><i class="fas fa-lock fa-fw"></i></span>
			<input 	type="password" 
					name="password" 
					maxlength="30"
					class="form-control"
					placeholder="Password..."
					required>
		</div>
	</div>

	<button type="submit" class="btn btn-info">Submit</button>
</form>

<br>

<h3>Don't have an account?</h3>
<p><a href="create-account">Create an account</a></p>

<?php require 'partials/footer.php'; ?>