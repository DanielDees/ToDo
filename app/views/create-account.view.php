<?php require 'partials/header.php'; ?>

<h1>Create Account</h1>

<form id='user-form'>
	<div class="input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"><i class="fas fa-user fa-fw"></i></span>
			<input 	type="text"
					name="username" 
					maxlength="30" 
					class="form-control"
					placeholder="Username..." 
					required>
		</div>
	</div>
	<div class="input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"><i class="fas fa-lock fa-fw"></i></span>
			<input 	type="password"
					name="password" 
					maxlength="30" 
					pattern=".{8,}"
					title="Password must be at least 8 characters long!"
					class="form-control"
					placeholder="Password..." 
					required>
		</div>
	</div>
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

	<input type="hidden" name="create-user" />

	<button type="submit" class="btn btn-info">Submit</button>
</form>

<br>
<p id='warning'></p>

<script type="text/javascript">

	function show_warning(msg) {
		$('#warning').animate({opacity:0.1}, 0);
		$('#warning').animate({opacity:1}, 400);
		$('#warning').html(msg);
	};

	//Check for duplicate account and set some div for warning to response if fail.
	function login() {

		var form = $('#user-form').serialize();

		$.ajax({
			data: form,
			type: 'POST',
			url: 'query-user',
			dataType: 'json',

			success: function(data) {

				if (data['valid']) {
					window.location = '/login';
				}

				//Duplicate account!
				var msg = 'That email address has already been taken!';

				show_warning(msg);

				console.log("Duplicate account!" + data);
			},
			error: function(data) {
				alert("ERROR: " + data['responseText']);
				//$("#warning").html(data);
				console.log("Account duplication!");
				console.log(data);
			}
		});
	}

	$('document').ready(function() {
		$('#user-form').submit(function(e) {
			e.preventDefault();
			login();
		});
	});

</script>

<?php require 'partials/footer.php'; ?>