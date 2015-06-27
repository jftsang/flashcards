<?php
function multiarray_to_csv($arr,$fill='',$sort = false) {
 $keys1 = array_keys($arr);
 $keys2 = array(); 
 foreach($arr as $key=>$subarr) {
  $keys2 = array_merge($keys2,array_keys($subarr));
 }
 $keys2 = array_unique($keys2);
 
 if ($sort) {
  sort($keys1);
  sort($keys2);
 }

 foreach($keys1 as $key1) {
  foreach($keys2 as $key2) {
   if (!isset($arr[$key1][$key2])) $arr[$key1][$key2] = 0;
  }
 }
 
 $op = '';
 foreach($keys2 as $key2) {
  $op .= sprintf(",%s",$key2);
 }
 $op.="\n";
 foreach($keys1 as $key1) {
  $op.=sprintf("%s",$key1);
  foreach($keys2 as $key2) {
   $op.=sprintf(",%s",$arr[$key1][$key2]);
  }
  $op.="\n";
 }
 return $op;
}
?>
