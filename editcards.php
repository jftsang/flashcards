<?php
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html;charset=utf-8');
set_include_path('include/');

session_start();
require_once('isloggedin.php');

if(!$isloggedin) {
 die('You are not logged in. Please go to <a href="login.php">login.php</a>.');
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
 $file = fopen('cardlists/'.$username,'w') or $msg.="Couldn't open file cardlists/$username. ";
 fputs($file,$_REQUEST['cardlist']) or $msg.="Couldn't write to file cardlists/$username. ";
 if(!isset($msg)) $msg = "Written to file cardlists/$username. ";
} 

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit cardlist</title>
</head>

<body>

<h1>Your current cardlist</h1>
<pre>
<?= file_get_contents('cardlists/'.$username) ?>
</pre>

<h2>Edit cardlist</h2>

<p><?=$msg?></p>

<p><strong>Warning!</strong> Make sure you know what you're doing...</p>

<p><a href="index.php">Back to flashcards</a></p>

<form action="editcards.php" method="post">

<textarea name="cardlist" rows="24" cols="80">
<?=isset($_REQUEST['cardlist']) ? $_REQUEST['cardlist'] : file_get_contents('cardlists/'.$username) ?>
</textarea>
<br/>
<input type="submit"/>

</form>

</body>
</html>
