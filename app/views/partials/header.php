<?php 
	if (!isset($_SESSION)) 
	{
		session_start();
	} 
?>

<!DOCTYPE html>
<html>
<head>
	<title>To-Do App | <?php echo $page_title; ?></title>
	<?php require 'public/bootstrap.php'; ?>
	<link rel="stylesheet" type="text/css" href="../public/default.css">
</head>
<body>
	<?php require 'nav.php'; ?>
	<div class="container-fluid">