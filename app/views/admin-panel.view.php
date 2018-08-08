<?php 
	require 'partials/header.php'; 

	use ToDo\Models\Button;
	use ToDo\Models\Account;
?>

<br>
<h1 class="text-center">Users</h1>
<br>

<div class="grid">
	<?php 
		foreach ($users as $user) {

			$buttons = [];

			if ($user->role_id == '1') {
				$buttons['Edit User'] = Button::user();
			}
			if ($user->role_id == '2') {
				$buttons['Edit User'] = Button::editor();
			}
			if ($buttons['Edit User']) {
				$buttons['Edit User']['data-id'] = $user->id;
			}

			echo "<div class='grid-col'>";

				$user_attributes = ['username', 'email', 'role_id'];

				echo Account::display($user, $user_attributes);
				echo Button::create_group($buttons);
			
			echo "</div>";
		}
	?>
</div>

<!-- AJAX -->
<script type="text/javascript">

	function edit_account() {

		var id = $(this).data('id');

		$.ajax({
			data: { 
				id: id
			},
			type: 'GET',

			success: function() {
				window.location = 'update-account/?id=' + id;
			},
			error: function() {
				alert("Failed to perform action!");
			},
		});
	};

	//Filter
	$('document').ready(function() {
		//set_filter();
		//$('#filter_status').on('change', set_filter);
		$('.grid').on('click', '.edit-account', edit_account);
	});

</script>

<?php require 'partials/footer.php'; ?>