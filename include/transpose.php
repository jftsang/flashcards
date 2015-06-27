<?php
/* If $table is a 2-dimensional associative array, then transpose($table)
 * returns its transpose. */
function transpose($table) {
 $rt = array();
 foreach ($table as $rid=>$row) {
  foreach ($row as $cid=>$cell) {
   $rt[$cid][$rid] = $cell;
  }
 }
 return $rt;
}
?>
