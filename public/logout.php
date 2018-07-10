<?php require_once('../includes/functions.php'); ?>
<?php 
setcookie('I430-Project',null,time()-3600);
redirect_to("index.php");
?>
<?php include("../includes/layout/header.php"); ?>
		<h2>Logout</h2>
		<h2>You are logged out. Thank you for hanging out!</h2>
		<p> If you are not automatically redirected to the home page, please click the link below. </p>
		<a href="index.php">Return Home</a>
<?php include("../includes/layout/footer.php"); ?>