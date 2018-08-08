<?php 
	require 'partials/header.php'; 
	use ToDo\Models\TableBuilder;
?>

	<h1>Home</h1>

<?php 
	if ($_SESSION['logged_in']) {
		echo  "<h2>Welcome: " . $_SESSION['username'] . "!</h2>";
		echo "<p>Account Type: " . $_SESSION['account_type'] . "</p>";
	}
?>

<p>This application is an example of my programming ability with use of PHP, MySQL, HTML5/CSS, JavaScript, Jquery, and AJAX.</p> 

<p>The site also makes use of Bootstrap4 for design, and an MVC framework.</p>

<h2>About Me</h2>

<h3>Daniel Dees</h3>

<p>I am a graduate of Southern Wesleyan University, with a B.S. in Applied Computer Science. I have several years of experience programming and am now looking for employment.</p>

<div class="row">
	<?php TableBuilder::build($table_data, $table_attributes); ?>
</div>

<p>I also have experience working with Bootstrap, JQuery, AJAX, and using MVC design patterns</p>

<?php require 'partials/footer.php'; ?>