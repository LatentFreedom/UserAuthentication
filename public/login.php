<?php require_once('../includes/functions.php'); ?>
<?php
$errors = [];
$missing = [];
// detect form submission
if (isset($_POST['submit'])) {
    $fields_expected = ['username','password'];
    $fields_required = ['username','password'];
    require '../includes/process_login.php';
    require '../includes/form_validation.php';

    // Try to login
    if (empty($errors) && empty($missing)) {
        // Create database connection
        $connection = open_connection();
        // Test connection
        if (mysqli_connect_errno()) {
            connection_error();
        } else {
            // Perform query
            $query = "SELECT username, password FROM users";
            $result = mysqli_query($connection, $query);
            // Test for query error
            if (!$result) {
                die("Database query failed.");
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['username'] == $username && $row['password'] == encrypt_password($password)) {
                        // successful login
                        setcookie('I430-Project',$username,time()+(60*60*2));
                        redirect_to('index.php');
                    } else {
                        $errors['login'] = "<p class=\"warning\">Wrong username or password.</p>";
                    }
                }
                // Release returned data
                mysqli_free_result($result);
            }
        }
    }
}

?>
<?php include("../includes/layout/header.php"); ?>
        <nav>
            <ul>
                <li><a href="index.php">Return Home</a></li>
            </ul>
        </nav>
        <h2>Login</h2>
        <?php if ($_POST && $suspect) : ?>
            <p class="warning">Sorry, your login could not be processed.</p>
        <?php elseif ($errors || $missing) : ?>
            <p class="warning">Please fix the item(s) indicated.</p>
        <?php endif; ?>
        <?php if (isset($errors['login'])) {
            echo $errors['login'];
        } ?>
        <section class="formContainer">
            <form id="Login" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                <h4> Login </h4>
                <div class="row">
                    <label for="username"> Username: 
                    <?php if (($missing && in_array('username',$missing)) || isset($errors['username'])) : ?>
                        <span class="warning"> <?= $errors['username'] ?></span>
                    <?php endif; ?>
                    </label>
                    <input id="username" class="input" type="text" name="username"
                    <?php
                      if ($errors || $missing) {
                          echo 'value="' . htmlspecialchars($username) . '"';
                      }     
                    ?>      
                    >
                </div>
                <div class="row">
                    <label for="password"> Password: 
                    <?php if (($missing && in_array('password',$missing)) || isset($errors['password'])) : ?>
                        <span class="warning"> <?= $errors['password'] ?></span>
                    <?php endif; ?>
                    </label> 
                    <input id="password" type="password" name="password">
                </div>
                <div class="row">
                    <input id="submit" type="submit" name="submit">
                </div>
            </form>
        </section>
<?php include("../includes/layout/footer.php"); ?>