<?php
session_start();

require_once('isloggedin.php');

unset($_SESSION['flashcards_username']);
unset($_SESSION['flashcards_password']);
?>
<html>
<body>
<p>You are now logged out.</p>
<p>You can <a href="login.php">log in again</a>.</p>
</body>
</html>
