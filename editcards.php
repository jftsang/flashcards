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
 $file = fopen($cardlist_filename,'w') or $msg.="Couldn't open file $cardlist_filename.";
 fputs($file,$_REQUEST['cardlist']) or $msg.="Couldn't write to file $cardlist_filename. ";
 if(!isset($msg)) $msg = "Written to file $cardlist_filename. ";
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
<?= file_get_contents($cardlist_filename) ?>
</pre>

<h2>Edit cardlist</h2>

<p><?=$msg?></p>

<p><strong>Warning!</strong> Make sure you know what you're doing! Your cardlist is stored internally as a CSV file.</p>

<p><a href="index.php">Back to flashcards</a></p>

<form action="editcards.php" method="post">

<textarea name="cardlist" rows="24" cols="80">
<?=isset($_REQUEST['cardlist']) ? $_REQUEST['cardlist'] : file_get_contents($cardlist_filename) ?>
</textarea>
<br/>
<input type="submit"/>

</form>

</body>
</html>
