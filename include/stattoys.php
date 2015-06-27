<?php

/* Calculates the mean value of the elements of $arr */
function array_mean($arr) {
 return array_sum($arr)/count($arr);
}

function array_covariance($arr1,$arr2) {
 if (count($arr1)!=count($arr2)) die("Arrays not of the same length\n");
 $mean1 = array_mean($arr1);
 $mean2 = array_mean($arr2);
 $cov=0;
 foreach($arr1 as $ind=>$elem1) {
  $elem2=$arr2[$ind];
  $cov+=($elem1-$mean1)*($elem2-$mean2);
 } 
 $cov /= (count($arr1)-1);
 return $cov;
}

function array_variance($arr) {
 return array_covariance($arr,$arr);
}

/* Calculates the covariance between the keys and the values of $arr */
function array_covariance_assoc($arr) {
 return array_covariance(array_keys($arr), array_values($arr));
}

/* Finds the coefficients for the least squares regression line between
 * $arr1 and $arr2: in the form y = a+bx */
function array_regression_b($arr1,$arr2) {
 return array_covariance($arr1,$arr2) / array_variance($arr1); 
}

function array_regression_a($arr1,$arr2) {
 return array_mean($arr2) - array_regression_b($arr1,$arr2) * array_mean($arr1);
}

function array_regression_assoc_b($arr) {
 return array_regression_b(array_keys($arr), array_values($arr));
}

function array_regression_assoc_a($arr) {
 return array_regression_a(array_keys($arr), array_values($arr));
}


?>
