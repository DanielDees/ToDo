<?php require 'partials/header.php'; ?>

<h1 class="text-center"><?php echo "Task #" . $task->id ?></h1>

<form method="POST" action="/query-task">
	<div class='row form-group justify-content-center'>
		<input 	type="text"
				class="form-control col-sm-8"
				name="title" 
				maxlength="60"
				value="<?php echo $task->title; ?>"
				placeholder="Title..."
				required><br>
	</div>
	<div class='row form-group justify-content-center'>
		<textarea 	name="content"
					class="form-control col-sm-8"
					rows="8"
					placeholder="Content..."><?php echo $task->content; ?></textarea>
		<br>
	</div>
	
	<div class='row form-group justify-content-center'>
		<div class="col-sm-8">
			<div class='row form-group'>
				<select name="status_id" class="form-control col-sm-4">
					<?php 
						for ($i=0; $i < count($task_statuses); $i++) 
						{ 
							$select = '';

							$select = ($task->status_id == $task_statuses[$i]->id) ? 'selected' : '';
							
							echo "<option value='" . 
									$task_statuses[$i]->id . "' " . 
									$select . '>' .
									$task_statuses[$i]->title . 
								"</option>";
						};
					?>
				</select><br>

				<select name="priority_id" class="form-control col-sm-4" required>
					<?php 
						for ($i=0; $i < count($task_priorities); $i++) 
						{ 
							$select = ($task->priority_id == $task_priorities[$i]->id) ? 'selected' : '';
							
							echo "<option value='" . 
									$task_priorities[$i]->id . "' " . 
									$select . '>' .
									$task_priorities[$i]->title . 
								"</option>";
						};
					?>
				</select><br>

				<select name="category_id" class="form-control col-sm-4">
					<?php 
						var_dump($task->category_id);
						for ($i=0; $i < count($task_categories); $i++) 
						{ 
							$select = ($task->category_id == $task_categories[$i]->id) ? 'selected' : '';
							
							echo "<option value='" . 
									$task_categories[$i]->id . "' " . 
									$select . '>' .
									$task_categories[$i]->title . 
								"</option>";
						};
					?>
				</select><br>
			</div>
		</div>
	</div>	

	<div class='row form-group justify-content-center'>
		<input 	type="datetime-local" 
				name="deadline" 
				class="form-control col-sm-4"
				value="<?php  
					$date = date_create($task->deadline);
					echo date_format($date, 'Y-m-d\TH:i');
				?>"
				required>
	</div>

	<div class="row justify-content-center">
		<button type="submit"
				class='btn btn-primary bg-warning col-sm-3'
				name='update-task' 
				value="<?php echo $task->id; ?>">
				<span class="fas fa-save"></span> Save Edits
			</button>
	</div>
</form>

<?php require 'partials/footer.php'; ?>