<?php
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html;charset=utf-8');
set_include_path('include/');
require_once('eatcsv.php');
require_once('writecsv.php');
require_once('array-weightedrandom.php');

session_start();

/* Check whether the user is logged in, and whether they have a directory in
 * /cardlists/ or not. */
require_once('isloggedin.php');
if (!$isloggedin) {
 die('You are not logged in. Please go and <a href="login.php">log in</a>.'); 
}

$cards = eatcsv($cardlist_filename) or die("Couldn't open file $cardlist_filename.");

$oldcardid = $_REQUEST['cardid'];
$oldside   = $_REQUEST['side'];
switch ($_REQUEST['action']) {
 case 'I know this':
  $cards[$oldcardid]['correct']++;
  $cards[$oldcardid]['lasttested'] = time();
  break;
 case 'I don\'t know this':
  $cards[$oldcardid]['incorrect']++;
  $cards[$oldcardid]['lasttested'] = time();
  break;
}
?><br/><?php
/* Update the cardlist file */
$file = fopen($cardlist_filename,'w');
writecsv($file,$cards);

/* Choose the next thing to display */

switch ($_REQUEST['action']) {
 case 'refresh':
  $cardid = $oldcardid;
  $side   = $oldside;
  break;
 case 'flip':
  $cardid = $oldcardid;
  $side   = 1-$oldside;
  break;
 case 'newcard':
 default:
  /* Weight the cards, and choose a random card. Cards are given more weight if
   * the user has got them wrong very often, and if the card hasn't come up
   * in a while. */
  $weights = array_map(
   function($card) {
    $propright = ($card['correct'] + $card['incorrect'] > 0) ?
     $card['correct'] / ($card['correct'] + $card['incorrect']) : 0.5;
     $weight = (time() - $card['lasttested'])/3600 + 1/($propright+1) - 1/2;
    return $weight;
   }
  , $cards); //array_map
  while (true) {
   $cardid = array_weightedrandom($cards,$weights);
   if ($cardid != $oldcardid) break;
  }
  /* Choose a random side of the card to be shown. */
  $side = array_rand(array(0,1));
  break;
}

$card = $cards[$cardid];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Flashcards tool</title>
</head>
<body>
<div style="text-align: center; margin-top:10%">
<form action="index.php" method="post">
<div style="font-weight:bold; font-size: 120px;">
<?=$card['side'.$side]?>
</div>

<input type="hidden" name="cardid" value="<?=$cardid?>"/>
<input type="hidden" name="side" value="<?=$side?>"/>

<p>
<input type="submit" name="action" value="I know this"/>
<input type="submit" name="action" value="I don't know this"/>
<br/>
(Be honest!)
</p>
<?php
if (isset($card['correct']) && isset($card['incorrect']) && $card['correct'] + $card['incorrect'] > 0) {
?>
    <p>You have got this card right <?=
sprintf('%.1f',$card['correct']/($card['correct']+$card['incorrect'])*100)?>% of the time. (<?=$card['correct']?> out of <?=$card['correct'] + $card['incorrect']?>)</p>
<?php
}
if (!empty($card['lasttested'])) {
?>
    <p>This card was last tested on <?=date('d M Y',$card['lasttested'])?>.</p>
<?php }?>
<p>
<input type="submit" name="action" value="new card"/>
<input type="submit" name="action" value="flip"/>
<input type="submit" name="action" value="refresh"/>
</p>
</form>

Logged in as <tt><?=$username?></tt>.<br/>
Using card list <tt><?=$cardlist?></tt>.<br/>
<a href="viewcards.php">view cardlist</a> |
<a href="editcards.php">edit cardlist</a> | 
<a href="about.php">about</a> |
<a href="logout.php">logout</a>
</div>
</body>
</html>
