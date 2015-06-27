<?php
/* Calculates the metaphone key for a string, but preserving spaces and
 * hyphens. */

function strmp($str) {
 $arr = explode(' ', $str);
 foreach ($arr as $ind=>$word) {
  $word = trim($word);
  $arr[$ind] = metaphone($word);
 }
 $str = implode(' ', $arr);
 return $str;
}
?>
