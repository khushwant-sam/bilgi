<?php
/**
 * Description tab
 *
 * @author    MyArcadePlugin
 * @package   MyArcadePlugin/Templates
 * @version   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

global $post;

$heading = esc_html( apply_filters( 'mapti_game_instructions_heading', __( 'Game Instructions', 'mapti' ) ) );
?>

<?php //echo "<h2>" . $heading . "</h2>"; ?>

<?php echo get_post_meta( $post->ID, 'mabp_instructions', true ); ?>