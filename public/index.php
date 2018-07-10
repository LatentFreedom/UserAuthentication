<?php
// Check if the user is logged in
$username = isset($_COOKIE['I430-Project']) ? $_COOKIE['I430-Project'] : "";
?>
<?php include("../includes/layout/header.php"); ?>
        <nav>
            <ul>
            <?php if (empty($username)) : ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Signup</a></li>
            <?php else : ?>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
            </ul>
        </nav>
        <h2>Home
        <?php 
        if (!empty($username)) {
            echo " ($username)";
        }
        ?></h2>
        <h3>What is this website?</h3>
        <p> This website is to showcase I430 final project.</p>
        <p> The final project was to show how to set up file access and user privileges on a webserver.</p>
        <section>
            <h4>What was used:</h4>
            <ul>
                <li>Server: <a href="https://aws.amazon.com/ec2/">AWS EC2 Ubuntu 14.04</a> (free tier) </li>
                <li>Webserver: Apache</li>
                <li>PHP: <a href="phpinfo.php">7.0.12</a></li>
                <li>Database: <a href="http://dev.mysql.com/downloads/mysql/">5.7.16, for Linux (x86_64)</a></li>
            </ul>
        </section>
        <section>
            <h4>Files to download: </h4>
            <p>The name of the files distinguish the accessability</p>
            <ul id="fileList">
                <li class="file"><a href="../files/admin.txt">admin.txt</a></li>
                <li class="file"><a href="../files/user.txt">user.txt</a></li>
                <li class="file"><a href="../files/guest.txt">guest.txt</a></li>
            </ul>
        </section>
<?php include("../includes/layout/footer.php"); ?>