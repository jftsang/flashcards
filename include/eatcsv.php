<?php
function eatcsv($filename,$header=true) {
 $f = fopen($filename,'r') or die("Could not read from $filename");
 $records = array();
 if ($header) {
  $labels = fgetcsv($f); // first row
  while($record = fgetcsv($f)) {
   foreach($labels as $ind=>$label) {
    $row[$label] = $record[$ind];
   }
   $records[] = $row;
  } 
 } else {
  while($record = fgetcsv($f)) {
   $records[] = $record; 
  }
 }
 return($records);
}
?>
