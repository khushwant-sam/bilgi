<?php
/**
 * Scores tab
 *
 * @author    MyArcadePlugin
 * @package   MyArcadePlugin/Templates
 * @version   6.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

global $post;

$heading = esc_html( apply_filters( 'mapti_game_scores_heading', __( 'Game Scores', 'mapti' ) ) );

?>
<?php //echo "<h2>" . $heading . "</h2>"; ?>
<?php

if ( ! function_exists('myscore_get_game_scores') ) {
  echo "Please install <strong>MyScoresPresenter</strong> Plugin in order to display game scores!";
}
else {
  ?>
  <ul>
    <?php myscore_get_game_scores(); ?>
  </ul>
  <?php
}
?>