<?php
/* loadcards.php - Loads $username's cards $cardlist into the array $cards.
 * Also updates information about card weights. */
require_once('eatcsv.php');

if (!( 
    isset($username) && isset($cardlist)
)) {
 die("Tried to open cardlist <tt>$cardlist</tt> of user <tt>$username</tt>, and failed.");
}

$cardlist_filename = 'cardlists/'.$username.'/'.$cardlist;
$cards = eatcsv($cardlist_filename) or die("Couldn't open file $cardlist_filename.");
/* Weight the cards, and choose a random card. Cards are given more weight if
 * the user has got them wrong very often, and if the card hasn't come up
 * in a while. */

$weights = array_map(
    function($card) {
        /* Work out the proportion of times we have got the card right. If it
         * has never been tested before, then arbitrarily say that the
         * proportion is 0.5. */
        $propright = ($card['correct'] + $card['incorrect'] > 0) ?
            $card['correct'] / ($card['correct'] + $card['incorrect']) : 0.5;
        $weight = (time() - $card['lasttested'])/3600 + 1/($propright+1) - 1/2;
        return $weight;
    }
, $cards); //array_map


?>
