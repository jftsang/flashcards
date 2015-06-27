<?php
function strclean($str) {
 $str = strtolower(array_shift(explode(',',$str)));
 $str = array_shift(explode(' (',$str));
 return $str;
}
?>
