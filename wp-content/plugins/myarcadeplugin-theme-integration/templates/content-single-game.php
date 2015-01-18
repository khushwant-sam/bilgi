<?php
/**
 * The template for displaying game content in the single-game.php template
 *
 * Override this template by copying it to yourtheme/myarcade/content-single-game.php
 *
 * @author    MyArcadePlugin
 * @package   MyArcadePlugin/Templates
 * @version   6.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

do_action( 'mapti_before_single_game' );

// Display the game
?>
<div class="game-wrapper">
  <div>
    <a href="<?php echo get_permalink() . 'fullscreen'; ?>" class="fullscreen" title="<?php _e("Fullscreen"); ?>" rel="bookmakr">
      <div>Full Screen</div>
    </a>
  </div>
<?php
if ( function_exists( 'get_game' ) ) {
  echo get_game();
}
?>
</div>
<?php

// Include the leaderboard bridge if available
if ( function_exists( 'myarcade_get_leaderboard_code') ) {
  myarcade_get_leaderboard_code();
}

do_action( 'mapti_after_single_game' );