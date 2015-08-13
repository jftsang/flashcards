<?php
session_start();

if(isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
 $_SESSION['flashcards_username'] = $_REQUEST['username'];
 $_SESSION['flashcards_password'] = $_REQUEST['password'];
}

require_once('isloggedin.php');

if ($isloggedin) {
?>
<p>Welcome, <?=$username?>! You are logged in.</p>
<p><a href="index.php">Flashcards!</a></p>
<p><a href="logout.php">Logout</a></p>
<?php
} else {
?>
<p>You are not logged in.</p>

<p><a href="register.php">Register</a> to use flashcards.</p>

<form action="login.php" method="post">
Username <input type="text" name="username"/><br/>
Password <input type="password" name="password"/><br/>
<input type="submit"/>
</form>

<?php
}
?>
