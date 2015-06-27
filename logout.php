<?php
session_start();

require_once('isloggedin.php');

unset($_SESSION['flashcards_username']);
unset($_SESSION['flashcards_password']);
?>
<html>
<body>
<p>You are now not logged in. You can <a href="login.php">log in again</a> or <a href="index.php">go back to the front page</a>.</p>
</body>
</html>
