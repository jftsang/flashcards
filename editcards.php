<?php
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html;charset=utf-8');
set_include_path('include/');
require_once('eatcsv.php');
require_once('writecsv.php');

session_start();
require_once('isloggedin.php');

if(!$isloggedin) {
 die('You are not logged in. Please go to <a href="login.php">login.php</a>.');
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
 $file = fopen($cardlist_filename,'w') or $msg.="Couldn't open file $cardlist_filename.";
 fputs($file,$_REQUEST['cardlist']) or $msg.="Couldn't write to file $cardlist_filename. ";
 fclose($file);
 if(!isset($msg)) $msg = "Written to file $cardlist_filename. ";

 /* Sanitise the newly-written cardlist. Fill in missing numerical values as
  * zero, and use htmlspecialchars() on the strings. */
 $cards = eatcsv($cardlist_filename);
 foreach($cards as &$card) {
  $card['side0'] = htmlspecialchars($card['side0']);
  $card['side1'] = htmlspecialchars($card['side1']);
  if (empty($card['correct'])) $card['correct']=0;
  if (empty($card['incorrect'])) $card['incorrect']=0;
  if (empty($card['lasttested'])) $card['lasttested']=0;
 }
 /* Rewrite the cardlist using the sanitised table. */
 $file = fopen($cardlist_filename,'w');
 writecsv($file,$cards);
} 

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit cardlist</title>
</head>

<body>

<h1>Editing cardlist <tt><?=$cardlist?></tt> of user <tt><?=$username?></tt></h1>

<p><?=$msg?></p>

<p><a href="viewcards.php">View your current cardlist</a></p>

<p><a href="index.php">Back to flashcards</a></p>

<form action="editcards.php" method="post">

<textarea name="cardlist" rows="24" cols="80" style="font-family: monospace">
<?php 
 // echo isset($_REQUEST['cardlist']) ? $_REQUEST['cardlist'] : file_get_contents($cardlist_filename);
 echo file_get_contents($cardlist_filename);
?>
</textarea>
<br/>
<input type="submit"/>

</form>

</body>
</html>
