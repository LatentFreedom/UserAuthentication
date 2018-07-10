<?php require_once('../includes/functions.php'); ?>
<?php
$errors = [];
$missing = [];
// detect form submission
if (isset($_POST['submit'])) {
    $fields_expected = ['username','password','email'];
    $fields_required = ['username','password','email'];
    require '../includes/process_login.php';
    require '../includes/form_validation.php';

    $fields_with_max_lengths = array("username" => 20, "email" => 50, "password" => 20);
    $fields_with_min_lengths = array("username" => 4, "email" => 4, "password" => 8);

    validate_max_lengths($fields_with_max_lengths);
    validate_min_lengths($fields_with_min_lengths);

    // Try to login
    if (empty($errors) && empty($missing)) {
        // Create database connection
        $connection = open_connection();
        // Test connection
        if (mysqli_connect_errno()) {
            connection_error();
        } else {
            // Perform query
            $query = "SELECT username, email FROM users";
            $result = mysqli_query($connection, $query);
            // Test for query error
            if (!$result) {
                die("Database query failed.");
            } else {
                // search through query results for given username
                while ($row = mysqli_fetch_assoc($result)) {
                    // username taken
                    if ($row['username'] == $username) {
                        $errors['username'] = 'username';
                    }
                    if ($row['email'] == $email) {
                        $errors['email'] = 'email';
                    }
                    
                }
                // Release returned data
                mysqli_free_result($result);
                // If the username entered is not taken
                if (!isset($errors['username']) && !isset($errors['email'])) {
                    // make insert into databse of new user
                    $username = mysqli_real_escape_string($connection, $username);
                    $password = mysqli_real_escape_string($connection, $password);
                    $password = encrypt_password($password);
                    $email = mysqli_real_escape_string($connection, $email);
                    $query = "INSERT INTO users (username, password, email, privilege)
                              VALUES ('{$username}', '{$password}', '{$email}', 'user')";
                    $result = mysqli_query($connection, $query);
                    // Test for query error
                    if ($result) {
                        // successful database update and login
                        setcookie('I430-Project',$username,time()+(60*60*2));
                        redirect_to('index.php');
                    } else {
                        die("Database query failed.");
                    }
                }
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
        <h2>Signup</h2>
        </nav>
        <?php if ($_POST && $suspect) : ?>
            <p class="warning">Sorry, your signup could not be processed.</p>
        <?php elseif ($errors || $missing) : ?>
            <p class="warning">Please fix the item(s) indicated.</p>
        <?php endif; ?>
        <section class="formContainer">
            <form id="Signup" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                <h4> Signup </h4>
                <div class="row">
                    <p> (Username must be 4-20 characters) </p>
                    <label for="username"> Username: 
                    <?php if ($missing && in_array('username',$missing)) : ?>
                        <span class="warning"> Please enter a username</span> 
                    <?php endif; ?>
                    <?php if ($errors && in_array('username',$errors)) : ?>
                        <span class="warning"> Username taken</span> 
                    <?php endif; ?>
                    </label> 
                    <input id="username" type="text" name="username" 
                    <?php
                      if ($errors || $missing) {
                          echo 'value="' . htmlspecialchars($username) . '"';
                      }     
                    ?>
                    >
                </div>
                <div class="row">
                    <label for="email"> Email: 
                    <?php if ($missing && in_array('email',$missing)) : ?>
                        <span class="warning"> Please enter an email address</span> 
                    <?php endif; ?>
                    <?php if ($errors && in_array('email',$errors)) : ?>
                        <span class="warning"> Email taken</span> 
                    <?php endif; ?>
                    </label> 
                    <input id="email" type="email" name="email"
                    <?php
                      if ($errors || $missing) {
                          echo 'value="' . htmlspecialchars($email) . '"';
                      }     
                    ?>       
                    >
                </div>
                <div class="row">
                    <p> (Password must be 8-20 characters) </p>
                    <label for="password"> Password: 
                    <?php if ($missing && in_array('password',$missing)) : ?>
                        <span class="warning"> Please enter a password</span> 
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