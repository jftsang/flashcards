<?php
/* Prepares a doubly-indexed array for a chisq independence test. */
function multiarray_chisq_independence($arr,$mode='chisq') {
 $keys1 = array_keys($arr);
 $keys2 = array(); 
 foreach($arr as $key=>$subarr) {
  $keys2 = array_merge($keys2,array_keys($subarr));
 }
 $keys2 = array_unique($keys2);
 sort($keys1); sort($keys2);

 foreach($keys1 as $key1) {
  foreach($keys2 as $key2) {
   if (!isset($arr[$key1][$key2])) $arr[$key1][$key2] = 0;
  }
 }
 
 foreach($keys1 as $key1) {
  $arr_by_keys1[$key1] = array_sum($arr[$key1]);
  foreach($keys2 as $key2) {
   @$arr_by_keys2[$key2] += $arr[$key1][$key2];
  }
 }

 foreach($keys1 as $key1) {
  if($arr_by_keys1[$key1]==0) $dropkeys1[] = $key1;
 } 
 foreach($keys2 as $key2) {
  if($arr_by_keys2[$key2]==0) $dropkeys2[] = $key2;
 } 
 $total = array_sum($arr_by_keys1);
 if (array_sum($arr_by_keys1) != array_sum($arr_by_keys2)) die('Error!');
 @$dof =  (count($keys1) - count($dropkeys1) - 1)*(count($keys2) - count($dropkeys2) - 1);
 
 foreach($keys1 as $key1) {
  foreach($keys2 as $key2) {
   $expected[$key1][$key2] = $arr_by_keys1[$key1] * $arr_by_keys2[$key2] / $total;
   
   if($mode == 'chisq') {
    $ndiff[$key1][$key2] = ($arr[$key1][$key2] - $expected[$key1][$key2])/sqrt($expected[$key1][$key2]);
   }
   if($mode == 'gtest') {
    $gstat[$key1][$key2] = ($arr[$key1][$key2] == 0) ? 0 :
2*$arr[$key1][$key2] * log($arr[$key1][$key2]/$expected[$key1][$key2]);
   }
  }
 }
 
 if ($mode == 'chisq') return array($dof,$ndiff);
 if ($mode == 'gtest') return array($dof,$gstat);
}
?>
