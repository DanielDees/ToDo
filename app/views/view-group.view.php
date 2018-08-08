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

<br>
<div id='users-container' class='row justify-content-center'>	
	<div class='col-sm-10'>
		
		<?php 
			//This should also be moved out of the view
			$user_attributes = ['username', 'email'];
			
			foreach ($group_data as $info) 
			{
				$user = App::get('database')->select('users', $info->user_id);

				echo Account::display($user, $user_attributes);
				echo "<br>";
			}
		?>
		
	</div>
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
				$('#join-group').remove();
				$("#users-container").append(data['user']);
			},
			error: function(data) {
				alert("Failed to join group!");
				console.log("Failure response: " + data['responseText']);
			},
		});
	};

	function get_group_users() {

		var group_id = $('#submit-comment-content').attr('data-id');

		$.ajax({
			data: {
				'group_id': group_id
			},
			type: 'GET',
			url: '/get-group-users',
			dataType: 'json',

			success: function(data) {
				$("#users-container").append(data['users']);
			},
			error: function(data) {
				alert("Failed to load users!");
				console.log("Failure response: " + data['responseText']);
			},
		});
	};

	$('document').ready(function() {
		//get_group_members();
		//$('body').on('click', '.remove-member' , remove-member);
		$('body').on('click', '#join-group' , join_group);
		$('body').on('click', '#leave-group' , leave_group);
	});

</script>

<?php require 'partials/footer.php'; ?>