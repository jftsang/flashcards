<?php
ini_set('default_charset','UTF-8');
header('Content-Type: text/html;charset=utf-8');
set_include_path('include/');
require_once('eatcsv.php');

session_start();
require_once('isloggedin.php');
if(!$isloggedin) {
 die('You are not logged in. Please go to <a href="login.php">login.php</a>.');
}

require_once('loadcards.php');

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View cardlist</title>

<style>
table {
    border-collapse: collapse;
}
table, th, td {
   border: 1px solid gray;
}
th {
 font-weight:bold;
}
th, td {
 width: 150px;
 word-break: keep-all;
}
td.numeric {
    text-align: right;
}
</style>

</head>

<body>
<h1>Cardlist <tt><?=$cardlist?></tt> of user <tt><?=$username?></tt></h1>

<p>The <em>Weight</em> column indicates how likely the tool is to show you this card again. More weighting is given to cards which haven't come up in a while, and to cards which you have not got right very often.</p>

<table>
<tr>
<th>Side 0</th>
<th>Side 1</th>
<th>Positive responses</th>
<th>Negative responses</th>
<th>Total responses</th>
<th>Percentage</th>
<th>Last tested</th>
<th>Weight</th>
</tr>
<?php
foreach($cards as $i=>$card) {
?>
<tr>
 <td><?=$card['side0']?></td>
 <td><?=$card['side1']?></td>
 <td class="numeric"><?=$card['correct']?></td>
 <td class="numeric"><?=$card['incorrect']?></td>
 <td class="numeric"><?=$card['correct']+$card['incorrect']?></td>
 <td class="numeric"><?= ($card['correct']+$card['incorrect'] > 0) ? sprintf('%.1f%%',
    $card['correct']/($card['correct']+$card['incorrect'])* 100) : '--'?></td>
 <td class="numeric"><?=!empty($card['lasttested'])?date('d M Y',$card['lasttested']):'--'?></td>
 <td class="numeric"><?=sprintf('%.2f',$weights[$i])?></td>
</tr>
<?}?>
</table>

<p><a href="<?=$cardlist_filename?>">Raw CSV</a></p>
<p><a href="index.php">Back to flashcards</a></p>
<p><a href="editcards.php">Edit cardlist</a></p>
</body>
</html>
