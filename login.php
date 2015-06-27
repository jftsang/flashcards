<?php
session_start();

$_SESSION['flashcards_username'] = $_REQUEST['username'];
$_SESSION['flashcards_password'] = $_REQUEST['password'];

require_once('isloggedin.php');

if ($isloggedin) {
?>
<p>Welcome, <?=$username?>! You are logged in. <a href="index.php">Flashcards!</a></p>
<?php
} else {
?>
Hello. You are not logged in.

<form action="login.php" method="post">
Username <input type="text" name="username"/><br/>
Password <input type="password" name="password"/><br/>
<input type="submit"/>
</form>

<?php
}
?>
