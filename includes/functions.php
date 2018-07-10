<?php
define("DB_SERVER","localhost");
define("DB_USER","i430_cms");
define("DB_PASS","passwordI430");
define("DB_NAME","i430_project");

function open_connection() {
	// Create database connection
	$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	return $connection;
}

function redirect_to($new_location) {
    header("Location: " . $new_location);
    exit;
}

function connection_error() {
	die("Database connection failed: " . 
		mysqli_connect_error() . 
		" (" . mysqli_connect_errno() . ")"
	);
}

function  encrypt_password($password) {
	$hash_format = "$2y$10$";
	$salt = "SafeI430Password4MyProject";
	$format_and_salt = $hash_format . $salt;
	$hash = crypt($password,$format_and_salt);
	return $hash;
}

?>