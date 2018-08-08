<?php 
	require 'partials/header.php'; 

	use ToDo\Models\Task;
	use ToDo\Models\Button;
	use ToDo\Models\Comment;
?>

<br>
<h1 class="text-center"><?php echo $task->title; ?></h2>

<?php
	echo Task::display($task, $task_attributes);

	if ($_SESSION['logged_in'] && isset($task_buttons)) {

		foreach ($task_buttons as &$button) {
			$button['data-id'] = $task->id;
		}

		echo "<div class='row justify-content-center'>";
		echo Button::create_group($task_buttons);
		echo "</div>";
	}
?>
	
<br>
<h3 class="text-center">New Comment</h1>

<?php echo Comment::form('submit', $task->id); ?>

<div id='comments-container'>

<?php 
	//Nasty code! Cleanup needed!
	foreach ($comments as $comment) 
	{
		//Reset
		$comment_buttons = [];

		echo "<div id='comment-" . $comment->id . "-container'>";

		echo Comment::display($comment);

		if ($_SESSION['user_id'] == $comment->author_id) 
		{
			$comment_buttons['Edit'] = Button::edit('comment');
			$comment_buttons['Delete'] = Button::delete('comment');
		}

		else if ($_SESSION['account_type'] == 'Admin') 
		{
			$comment_buttons['Delete'] = Button::delete('comment');
		}

		if ($_SESSION['logged_in'] && isset($comment_buttons)) {

			foreach ($comment_buttons as &$button) {
				$button['data-id'] = $comment->id;
			}

			echo "<div class='row justify-content-center'>";
			echo Button::create_group($comment_buttons);
			echo "</div>";
		}
	
		echo "</div>";
	}
?>

</div>

<!-- AJAX -->
<script type="text/javascript">

	function edit_task() {

		var id = $(this).data('id');
		window.location = '/update-task-view/?id=' + id;
	};

	function archive_task() {

		var id = $(this).data('id');

		$.ajax({
			data: { 
				id: id,
				archive: true
			},
			type: 'POST',
			url: '/query-task',

			success: function(data) {
				console.log("Task #" + data + " has been archived!");
				window.location = '/tasks';
			},
			error: function(data) {
				alert("Failed to perform action!");
			},
		});
	};

	function delete_task() {

		var id = $(this).data('id');

		$.ajax({
			data: { 
				id: id,
				'delete': true
			},
			type: 'POST',
			url: '/query-task',

			success: function(data) {
				window.location = '/archive';
			},
			error: function(data) {
				alert("Failed to delete task!");
			},
		});
	};

	function edit_form() {

		var id = $(this).data('id');

		$.ajax({
			data: { 
				'id': id,
				'update-form': true
			},
			type: 'POST',
			url: '/query-comment',
			dataType: 'json',

			success: function(data) {
				$('#comment-' + id + '-container').empty();
				$('#comment-' + id + '-container').append(data['update-form']);
			},
			error: function(data) {
				alert("Failed to load comment editor!");
				console.log(data);
			},
		});
	};

	function delete_comment() {

		var id = $(this).data('id');

		$.ajax({
			data: { 
				id: id,
				'delete-comment': true
			},
			type: 'POST',
			url: '/query-comment',

			success: function(data) {
				$('#comment-' + data + '-container').remove();
			},
			error: function(data) {
				alert("Failed to delete task!");
				console.log(data['responseText']);
			},
		});
	};

	function submit_comment() {

		var comment = $('#submit-comment-content').val();
		var task_id = $('#submit-comment').attr('data-id');

		$.ajax({
			data: { 
				'content': comment,
				'task_id': task_id,
				'submit-comment': true
			},
			type: 'POST',
			url: '/query-comment',
			dataType: 'json',

			success: function(data) {

				if ($('#no-comments-warning')) {
					$('#no-comments-warning').remove();
				}

				$('#submit-comment-content').val('');
				$("#comments-container").append(data['comment']);
			},
			error: function(data) {
				alert("Failed to submit comment!");
				console.log("Failure response: " + data['responseText']);
			},
		});
	};

	function update_comment() {

		var comment = $('#update-comment-content').val();
		var id = $('#update-comment').attr('data-id');

		$.ajax({
			data: { 
				'id': id,
				'content': comment,
				'update-comment': true
			},
			type: 'POST',
			url: '/query-comment',
			dataType: 'json',

			success: function(data) {
				$('#comment-' + id + '-container').empty();
				$("#comment-" + id + "-container").append(data['comment']);
			},
			error: function(data) {
				alert("Failed to update comment!");
				console.log("Failure response: " + data['responseText']);
			},
		});
	};

	function get_task_comments() {

		var task_id = $('#submit-comment-content').attr('data-id');

		$.ajax({
			data: {
				'task_id': task_id
			},
			type: 'GET',
			url: '/get-comments',
			dataType: 'json',

			success: function(data) {
				$("#comments-container").append(data['comments']);
			},
			error: function(data) {
				alert("Failed to load comments!");
				console.log("Failure response: " + data['responseText']);
			},
		});
	};

	$('document').ready(function() {
		//get_task_comments();
		$('body').on('click', '.edit-task', edit_task);
		$('body').on('click', '.archive-task' , archive_task);
		$('body').on('click', '.delete-task' , delete_task);
		$('body').on('click', '.edit-comment' , edit_form);
		$('body').on('click', '.delete-comment' , delete_comment);
		$('body').on('click', '#submit-comment' , submit_comment);
		$('body').on('click', '#update-comment' , update_comment);
	});

</script>

<?php require 'partials/footer.php'; ?>