<?php
/* Given a table (an array of associative arrays), produces a CSV file. */
function writecsv($handle,$records) {
 $labels = array_keys($records[0]);
 fputcsv($handle,$labels);
 foreach($records as $record) {
  fputcsv($handle,$record);
 }
}
?>
