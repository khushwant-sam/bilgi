<?php
/**
 * The template for displaying game content within loops.
 *
 * Override this template by copying it to yourtheme/myarcade/content-game.php
 *
 * @package MyArcadePlugin/Templates
 * @author Daniel Bakovic <contact@myarcadeplugin.com>
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

global $post, $mapti_loop;

// Store loop count we're currently on
if ( empty( $mapti_loop['loop'] ) ) {
  $mapti_loop['loop'] = 0;
}

if ( empty( $mapti_loop['archive_heading'] ) ) {
  $mapti_loop['archive_heading'] = get_option( 'mapti_archive_heading', 'h3' );
}

// Store column count for displaying the grid
if ( empty( $mapti_loop['columns'] ) ) {
  $mapti_loop['columns'] = apply_filters( 'loop_games_columns', get_option( 'mapti_games_per_row', 4 ) );
}

// Increase loop count
$mapti_loop['loop']++;

// Extra post classes
$class = '';
if ( 0 == ( $mapti_loop['loop'] - 1 ) % $mapti_loop['columns'] || 1 == $mapti_loop['columns'] ) {
  $class = 'first';
}
if ( 0 == $mapti_loop['loop'] % $mapti_loop['columns'] ) {
  $class = 'last';
}
?>
<div class="game-item <?php echo $class; ?>">
  <div class="game-thumb-wrapper">
    <a class="game-link" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>" rel="bookmark">
      <span class="game-img">
        <img src="<?php echo myarcade_get_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>" />
        <span class="vertical-align"></span>
      </span>
      <span class="overlay"></span>
    </a>
  </div>
  <div class="game-data">
    <div class="stats">
      <?php if ( function_exists('the_views') ) : ?>
        <div class="views"><i class="count"><?php echo mapti_format_num( post_custom('views') ); ?></i></div>
      <?php endif; ?>
      <?php if ( function_exists('the_ratings') ) : ?>
        <?php the_ratings(); ?>
      <?php endif; ?>
      <div style="clear:both"></div>
    </div><!-- end .stats -->

    <<?php echo $mapti_loop['archive_heading']; ?> class="game-title">
      <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
        <?php the_title(); ?>
      </a>
    </<?php echo $mapti_loop['archive_heading']; ?>>
  </div><!-- end .game-data -->
</div><!-- end game-item -->