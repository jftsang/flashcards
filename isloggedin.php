<?php
/* isloggedin.php - Checks if the user is logged in. If so, prepares the
* variables $username, $cardlist and $cardlist_filename. */

set_include_path('include/');
require_once('eatcsv.php');

$passwordfile = eatcsv('users.csv');
$passwords = array();
foreach($passwordfile as $user) {
 $passwords[$user['username']] = $user['password'];
}

session_start();
/* If the username and password are given, and they match, then the user is
 * logged in. Otherwise, they are not. */ 
$isloggedin = false;
if(   isset($_SESSION['flashcards_username'])
   && isset($_SESSION['flashcards_password'])) {

 if (array_key_exists($_SESSION['flashcards_username'],$passwords) 
     && $passwords[$_SESSION['flashcards_username']] == $_SESSION['flashcards_password']) {
  $isloggedin = true;
  $username = $_SESSION['flashcards_username'];

  /* Check whether the user has a directory in /cardlists/ or not.
   * If not, create a directory for them, copying across the files from
   * /cardlists/default/. */
  if (!file_exists('cardlists/'.$username))  {
   system('cp -r cardlists/default cardlists/'.$username);
  }
  
  system('touch cardlists/'.$username.'/'.$username);
  if(isset($_SESSION['flashcards_cardlist'])) {
   $cardlist = $_SESSION['flashcards_cardlist'];
  } else {
   $cardlist = $username;
  }
 }
}

?>
