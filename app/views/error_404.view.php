<?php require 'partials/header.php'; ?>

<h1>Error 404</h1>

<h2>Something went wrong!</h2>

<p>Please try again later.</p>

<?php 
	if (isset($error_info)) 
	{	
		echo "<h3>Error Info:</h3>";

		echo $error_info; 

		echo "<br>";
	}
?>

<?php require 'partials/footer.php'; ?>