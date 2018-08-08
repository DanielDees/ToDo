<?php 
	require 'partials/header.php'; 

	use ToDo\Models\Group;
	use ToDo\Models\Button;
?>

<br>
<h1 class="text-center">Groups</h1>

<?php echo Group::form('submit') ?>

<div id='groups-container'>
	
<?php 
	//Nasty code! Cleanup needed!
	foreach ($groups as $group) 
	{
		//Reset
		$group_buttons = [];

		echo "<div id='group-" . $group->id . "-container'>";

		echo group::display($group);

		if ($_SESSION['account_type'] != 'User') 
		{
			$group_buttons['Edit'] = Button::edit('group');
			$group_buttons['Delete'] = Button::delete('group');
		}

		if (isset($group_buttons)) {

			foreach ($group_buttons as &$button) {
				$button['data-id'] = $group->id;
			}

			echo "<div class='row justify-content-center'>";
			echo Button::create_group($group_buttons);
			echo "</div>";
		}
	
		echo "</div>";
	}
?>

</div>

<!-- AJAX -->
<script type="text/javascript">

	function view_group() 
	{
		var id = $(this).data('id');
		
		window.location = 'view-group-view/?id=' + id;
	}

	function edit_form() {

		var id = $(this).data('id');

		$.ajax({
			data: { 
				'id': id,
				'update-form': true
			},
			type: 'POST',
			url: '/query-group',
			dataType: 'json',

			success: function(data) {
				$('#group-' + id + '-container').empty();
				$('#group-' + id + '-container').append(data['update-form']);
			},
			error: function(data) {
				alert("Failed to load group editor!");
				console.log(data);
			},
		});
	};

	function delete_group() {

		var id = $(this).data('id');

		$.ajax({
			data: { 
				id: id,
				'delete-group': true
			},
			type: 'POST',
			url: '/query-group',

			success: function(data) {
				$('#group-' + data + '-container').remove();
			},
			error: function(data) {
				alert("Failed to delete group!");
				console.log(data['responseText']);
			},
		});
	};

	function submit_group() {

		var group = $('#submit-group-title').val();
		var id = $('#submit-group').attr('data-id');

		$.ajax({
			data: { 
				'id': id,
				'title': group,
				'submit-group': true
			},
			type: 'POST',
			url: '/query-group',
			dataType: 'json',

			success: function(data) {

				if ($('#no-groups-warning')) {
					$('#no-groups-warning').remove();
				}

				$('#submit-group-title').val('');
				$("#groups-container").append(data['group']);
			},
			error: function(data) {
				alert("Failed to submit group!");
				console.log("Failure response: " + data['responseText']);
			},
		});
	};

	function update_group() {

		var group = $('#update-group-title').val();
		var id = $('#update-group').attr('data-id');

		$.ajax({
			data: { 
				'id': id,
				'title': group,
				'update-group': true
			},
			type: 'POST',
			url: '/query-group',
			dataType: 'json',

			success: function(data) {
				$('#group-' + id + '-container').empty();
				$("#group-" + id + "-container").append(data['group']);
			},
			error: function(data) {
				alert("Failed to update group!");
				console.log("Failure response: " + data['responseText']);
			},
		});
	};

	$('document').ready(function() {
		$('body').on('click', '.edit-group', edit_form);
		$('body').on('click', '.delete-group', delete_group);
		$('body').on('click', '#submit-group', submit_group);
		$('body').on('click', '#update-group', update_group);

		$('#groups-container').on('click', '.list-group-item', view_group);
	});

</script>

<?php require 'partials/footer.php'; ?>