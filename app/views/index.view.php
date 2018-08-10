<?php 
	require 'partials/header.php'; 
	use ToDo\Models\TableBuilder;
?>

<br>
<div class='row justify-content-center'>
	<h1>Home</h1>
</div>
<br>

<div class='row justify-content-center'>

	<div class='col-sm-6'>

		<?php 
			if ($_SESSION['logged_in']) {
				echo  "<h2>Welcome: " . $_SESSION['username'] . "!</h2>";
				echo "<p>Account Type: " . $_SESSION['account_type'] . "</p>";
			}
		?>
		
		<p>This application is an example of my programming ability with use of PHP, MySQL, HTML5/CSS, JavaScript, Jquery, and AJAX.</p> 

		<p>The makes uses BS4 for design, and an MVC framework built <a href='https://laracasts.com/series/php-for-beginners'>based off of Laravel's MVC layout.</a></p>

		<h2>About Me</h2>

		<h3>Daniel Dees</h3>

		<p>I am a graduate of Southern Wesleyan University, with a B.S. in Applied Computer Science. I have several years of experience programming and am now looking for employment.</p>

		<div class="row">
			<?php TableBuilder::build($table_data, $table_attributes); ?>
		</div>

		<p>I also have experience working with Bootstrap, JQuery, AJAX, and using MVC design patterns.</p>
		
	</div>
	
</div>

<?php require 'partials/footer.php'; ?>