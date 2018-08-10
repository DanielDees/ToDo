<?php 
	require 'partials/header.php'; 

	use Core\App;

	use ToDo\Models\Group;
	use ToDo\Models\Button;
	use ToDo\Models\Account;
?>

<br>
<h1 class="text-center"><?php echo $group->title; ?></h2>
<br>

<div class="row justify-content-center">

<?php 
	//Move this php snippet to pagescontroller
	$member = false;

	foreach ($group_data as $info) 
	{
		if ($_SESSION['user_id'] == $info->user_id) 
		{
			$member = true;
		}
	}

	if ($member) 
	{
		echo Group::leave_form($group->id, 'Leave Group');
	}
	else 
	{
		echo Group::join_form($group->id, 'Join Group'); 
	}
?>

</div>

<br>
<div id='users-container' class='groups-grid'>	
		<?php 
			foreach ($group_data as $info) 
			{
				echo '<div class="grid-col">';

				$user = App::get('database')->select('users', $info->user_id);

				$user_buttons = [];

				echo "<div id='user-" . $user->id . "-container'>";

				echo Account::display($user, ['username', 'email']);

				if ($_SESSION['account_type'] != 'User') 
				{
					$user_buttons['Remove User'] = Button::delete('group-user', 12);

					foreach ($user_buttons as &$button) 
					{
						$button['data-user-id'] = $info->user_id;
						$button['data-group-id'] = $info->group_id;
					}

					//echo "<div class='row justify-content-center'>";
					echo Button::create_group($user_buttons);
					//echo "</div>";
				}
			
				echo "</div>";

				echo "</div>";
			}
		?>
</div>

<!-- AJAX -->
<script type="text/javascript">

	function leave_group() {

		var id = $(this).data('id');

		$.ajax({
			data: { 
				'group_id': id,
				'leave-group': true
			},
			type: 'POST',
			url: '/query-group',

			success: function(data) {
				window.location = '/groups';
			},
			error: function(data) {
				alert("Failed to leave group!");
				console.log(data['responseText']);
			},
		});
	};

	function join_group() {

		var group_id = $('#join-group').attr('data-id');

		$.ajax({
			data: { 
				'group_id': group_id,
				'join-group': true
			},
			type: 'POST',
			url: '/query-group',
			dataType: 'json',

			success: function(data) {
				// $('#join-group').remove();
				$('#join-group').replaceWith(data['leave-group']);
				$("#users-container").append(data['user']);
			},
			error: function(data) {
				alert("Failed to join group!");
				console.log("Failure response: " + data['responseText']);
			},
		});
	};

	function remove_member() {

		var group_id = $(this).data('group-id');
		var user_id = $(this).data('user-id');

		$.ajax({
			data: { 
				'group_id': group_id,
				'user_id': user_id,
				'remove-member': true,
			},
			type: 'POST',
			url: '/query-group',
			dataType: 'json',

			success: function(data) 
			{
				$('#user-' + data['user'] + '-container').remove();
				console.log('#user-' + data['user'] + '-container');
			},
			error: function(data) {
				alert("Failed to remove member!");
				console.log(data['responseText']);
			},
		});
	};

	$('document').ready(function() 
	{
		//Add in for editors/admins
		$('body').on('click', '.delete-group-user' , remove_member);
		$('body').on('click', '#join-group' , join_group);
		$('body').on('click', '#leave-group' , leave_group);
	});

</script>

<?php require 'partials/footer.php'; ?>