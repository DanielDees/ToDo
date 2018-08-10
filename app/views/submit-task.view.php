<?php require 'partials/header.php'; ?>

<br>
<h1 class="text-center">New Task</h1>
<br>

<form action="query-task" method="POST">
	<div class='row form-group justify-content-center'>
		<input 	type="text" 
				class="form-control col-sm-8"
				name="title" 
				maxlength="60" 
				placeholder="Title..." 
				required><br>
	</div>
	<div class='row form-group justify-content-center'>
		<textarea name="content" 
				class="form-control col-sm-8"
				rows="8"
				placeholder="Content..."
				required></textarea><br>
	</div>

	<div class='row form-group justify-content-center'>
		<div class="col-sm-8">
			<div class='row form-group'>
				<select name="status_id" class="form-control col-sm-4">
					<option value="" selected disabled>Status...</option>
					<?php 
						for ($i=0; $i < count($task_statuses); $i++) 
						{ 			
							echo "<option value='" . $task_statuses[$i]->id . "'>" .
									$task_statuses[$i]->title . 
								"</option>";
						};
					?>
				</select><br>

				<select name="priority_id" class="form-control col-sm-4">
					<option value="" selected disabled>Priority...</option>
					<?php 
						for ($i=0; $i < count($task_priorities); $i++) 
						{ 			
							echo "<option value='" . $task_priorities[$i]->id . "'>" .
									$task_priorities[$i]->title . 
								"</option>";
						};
					?>
				</select><br>

				<select name="category_id" class="form-control col-sm-4">
					<option value="" selected disabled>Category...</option>
					<?php 
						for ($i=0; $i < count($task_categories); $i++) 
						{ 			
							echo "<option value='" . $task_categories[$i]->id . "'>" .
									$task_categories[$i]->title . 
								"</option>";
						};
					?>
				</select><br>
			</div>
		</div>
	</div>	

	<div class='row form-group justify-content-center'>
		<input 	class="form-control col-sm-3 calendar" 
				name="deadline"
				value='<?php 
					//Time is stupid to work with
					//Need to find a way to get user's timezone.
					echo Carbon\Carbon::now('EST');
				?>'
				placeholder="Deadline..." required>
	</div>
	

	<div class="row justify-content-center">
		<button type="submit" name='submit-task' class='btn btn-primary bg-success col-sm-3'>
			<span class="fas fa-plus-circle"></span> Submit New Task
		</button>
	</div>
</form>

<?php require 'partials/flatpickr.php'; ?>

<?php require 'partials/footer.php'; ?>