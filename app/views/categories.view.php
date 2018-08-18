<?php 
	require 'partials/header.php'; 

	use ToDo\Models\Category;
	use ToDo\Models\Button;
?>

<br>
<h1 class="text-center">Categories</h1>

<?php echo Category::form('submit') ?>

<br>
<div id='categories-container'>
	
<?php 
	//Nasty code! Cleanup needed!
	foreach ($categories as $category) 
	{
		//Reset
		$category_buttons = [];

		echo "<div id='category-" . $category->id . "-container'>";

		echo Category::display($category);

		if ($_SESSION['account_type'] != 'User') 
		{
			$category_buttons['Edit'] = Button::edit('category');
			$category_buttons['Delete'] = Button::delete('category');
		}

		if (isset($category_buttons)) {

			foreach ($category_buttons as &$button) {
				$button['data-id'] = $category->id;
			}

			echo "<div class='row justify-content-center'>";
			echo Button::create_group($category_buttons);
			echo "</div>";
		}
	
		echo "</div>";
	}
?>

</div>

<!-- AJAX -->
<script type="text/javascript">

	function edit_form() {

		var id = $(this).data('id');

		$.ajax({
			data: { 
				'id': id,
				'update-form': true
			},
			type: 'POST',
			url: '/query-category',
			dataType: 'json',

			success: function(data) {
				$('#category-' + id + '-container').empty();
				$('#category-' + id + '-container').append(data['update-form']);
			},
			error: function(data) {
				alert("Failed to load category editor!");
				console.log(data);
			},
		});
	};

	function delete_category() {

		var id = $(this).data('id');

		$.ajax({
			data: { 
				id: id,
				'delete-category': true
			},
			type: 'POST',
			url: '/query-category',

			success: function(data) {
				$('#category-' + data + '-container').remove();
			},
			error: function(data) {
				alert("Failed to delete category!");
				console.log(data['responseText']);
			},
		});
	};

	function submit_category() {

		var category = $('#submit-category-title').val();
		var id = $('#submit-category').attr('data-id');

		$.ajax({
			data: { 
				'id': id,
				'title': category,
				'submit-category': true
			},
			type: 'POST',
			url: '/query-category',
			dataType: 'json',

			success: function(data) {
				if ($('#no-categories-warning')) {
					$('#no-categories-warning').remove();
				}

				$('#submit-category-title').val('');
				$("#categories-container").append(data['category']);
			},
			error: function(data) {
				alert("Failed to submit category!");
				console.log("Failure response: " + data['responseText']);
			},
		});
	};

	function update_category() {

		var category = $('#update-category-title').val();
		var id = $('#update-category').attr('data-id');

		$.ajax({
			data: { 
				'id': id,
				'title': category,
				'update-category': true
			},
			type: 'POST',
			url: '/query-category',
			dataType: 'json',

			success: function(data) {
				$('#category-' + id + '-container').empty();
				$("#category-" + id + "-container").append(data['category']);
			},
			error: function(data) {
				alert("Failed to update category!");
				console.log("Failure response: " + data['responseText']);
			},
		});
	};

	$('document').ready(function() {
		$('body').on('click', '.edit-category', edit_form);
		$('body').on('click', '.delete-category', delete_category);
		$('body').on('click', '#submit-category', submit_category);
		$('body').on('click', '#update-category', update_category);
	});

</script>

<?php require 'partials/footer.php'; ?>