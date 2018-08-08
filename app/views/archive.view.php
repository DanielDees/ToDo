<?php require 'partials/header.php'; ?>

<br>
<h1 id='tasks-head' class="text-center"></h1>
<br>

<?php require 'partials/filter.php'; ?>

<!-- Hold all tasks displayed -->
<div id='tasks-container'></div>

<script type="text/javascript">

	function set_filter() {
		
		var status_id = $('#filter_status_id').val();
		var priority_id = $('#filter_priority_id').val();
		var category_id = $('#filter_category_id').val();
		var group_id = $('#filter_group_id').val();
		var archived = 1;

		$.ajax({
			data: { 
				filter: {
					'status_id': status_id,
					'category_id': category_id,
					'priority_id': priority_id,
					'group_id': group_id,
					'archived': archived,
				},
			},
			type: 'POST',
			url: 'get_filtered',
			dataType: 'json',

			success: function(data) {
				$("#tasks-container").html(data['tasks']);
				$("#tasks-head").html(data['page_head']);
				console.log(data['debug']);
			},
			error: function(data) {
				alert(data['responseText']);
				console.log("Could not set filter to: " + data['page_head']);
				console.log(data['responseText']);
			},
		});
	};

	function view_task() 
	{
		var id = $(this).data('id');
		var archived = true;

		window.location = 'view-task-view/?id=' + id + "&archived=" + archived;
	}

	//Filter
	$('document').ready(function() {
		set_filter();
		$('[id^=filter_]').on('change', set_filter);
		$('#tasks-container').on('click', '.list-group-item', view_task);
	});
	
</script>

<?php require 'partials/footer.php'; ?>