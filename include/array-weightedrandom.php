<?php
/* array_weightedrandom() - Chooses a random element of an array,
 * according to given weights. Returns the index of the chosen element. */

function array_weightedrandom($arr,$weights) {
 if (array_keys($arr) != array_keys($weights))
  die("array_weightedrandom() : $arr and $weights don\'t have the same
keys\n");
 
 $totalweights = array_sum($weights); 
 $weights = array_map(function($x) use($totalweights) {return $x/$totalweights;},$weights);
 asort($weights);
 $x = rand(0,999999) / 1000000;
 $summa = 0;
 foreach($weights as $ind=>$weight) {
  $summa += $weight;
  if($summa > $x) {
   return $ind; 
   break;
  }
 }
}

/*
$arr = array('a','b','c','d');
$weights = array(4,3,2,1);
for($i=1;$i<=1000;$i++) {
 $x = array_weightedrandom($arr,$weights);
 echo $x.' ';
 $res[$x]++;
}
echo "<br/>";
ksort($res);
var_dump($res);
*/

?>
