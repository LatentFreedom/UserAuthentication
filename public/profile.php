<?php require_once('../includes/functions.php'); ?>
<?php
// Check if the user is logged in
$username = isset($_COOKIE['I430-Project']) ? $_COOKIE['I430-Project'] : "";
if ($username == "") {
	redirect_to("index.php");
}
$privilege = 'guest';
$username_array = [];
// Create database connection
$connection = open_connection();
// Test connection
if (mysqli_connect_errno()) {
    die("Database connection failed: " . 
        mysqli_connect_error() .
        " (" . mysqli_connect_errno() . ")"
    );
} else {
    // Perform query
    $query = "SELECT username, privilege FROM users";
    $result = mysqli_query($connection, $query);
    // Test for query error
    if (!$result) {
        die("Database query failed.");
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['username'] == $username) {
                // successful login
                $privilege = $row['privilege'];
            } else {
            	$username_array[] = $row['username'];
            }
        }
        // Release returned data
        mysqli_free_result($result);
    }
}
// Check for POST
//if isset($_POST['id']) {
//	$query = "DELETE FROM users WHERE id = {$_POST['id']}";
//    $result = mysqli_query($connection, $query);
//}
?>
<?php include("../includes/layout/header.php"); ?>
        <nav>
            <ul>
                <li><a href="index.php">Return Home</a></li>
             </ul>
        </nav>
        <h2>User-Profile<?= " ($username)" ?></h2>
        <section>
        	<h3>What do you want to do?</h3>
			<ul>
				<?php if ($privilege == 'user') : ?>
				<li><a href="">Deactivate Your account</a></li>
				<?php elseif ($privilege == 'admin') : ?>
				<li>Deactivate User
					<ul>
						<?php for ($i = 0; $i < count($username_array); $i++) {
							echo "<li>{$username_array[$i]}</li>";
						}
						?>
					</ul>
				</li>
				<?php endif; ?>
			</ul>
		</section>
<?php include("../includes/layout/footer.php"); ?>