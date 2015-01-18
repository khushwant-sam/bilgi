<?php
/**
 * MyArcadePlugin Site Functions
 *
 * Functions related to MyArcadePlugin integration with default WordPress themes and custom post type.
 *
 * @author    Daniel Bakovic <contact@myarcadeplugin.com>
 * @package   MyArcadePlugin/Functions
 * @category  Core
 */

/**
 * Function to allow game_cat in the permalinks for games.
 *
 * @version 1.0.0
 * @access  public
 * @param   string $permalink The existing permalink URL
 * @param   object $post
 * @return  string
 */
function mapti_game_post_type_link( $permalink, $post ) {

  // Abort if post is not a game
  if ( 'game' != $post->post_type ) {
    return $permalink;
  }

  // Abort early if the placeholder rewrite tag isn't in the generated URL
  if ( false === strpos( $permalink, '%' ) ) {
    return $permalink;
  }

  // Get the custom taxonomy terms in use by this post
  $terms = get_the_terms( $post->ID, 'game_cat' );

  if ( empty( $terms ) ) {
    // If no terms are assigned to this post, use a string instead (can't leave the placeholder there)
    $game_cat = _x( 'uncategorized', 'slug', 'mapti' );
  }
  else {
    // Replace the placeholder rewrite tag with the first term's slug
    $first_term = array_shift( $terms );
    $game_cat = $first_term->slug;
  }

  $find = array(
    '%year%',
    '%monthnum%',
    '%day%',
    '%hour%',
    '%minute%',
    '%second%',
    '%post_id%',
    '%category%',
    '%game_cat%'
  );

  $replace = array(
    date_i18n( 'Y', strtotime( $post->post_date ) ),
    date_i18n( 'm', strtotime( $post->post_date ) ),
    date_i18n( 'd', strtotime( $post->post_date ) ),
    date_i18n( 'H', strtotime( $post->post_date ) ),
    date_i18n( 'i', strtotime( $post->post_date ) ),
    date_i18n( 's', strtotime( $post->post_date ) ),
    $post->ID,
    $game_cat,
    $game_cat
  );

  $replace = array_map( 'sanitize_title', $replace );

  $permalink = str_replace( $find, $replace, $permalink );

  return $permalink;
}
add_filter( 'post_type_link', 'mapti_game_post_type_link', 10, 2 );

/**
 * Add default game tabs to game pages
 *
 * @version 1.1.0
 * @since   1.0.0
 * @access  public
 * @param   array  $tabs [description]
 * @return  array
 */
function mapti_default_game_tabs( $tabs = array() ) {
  global $post;

  // Description tab - shows game content
  if ( $post->post_content ) {
    $tabs['description'] = array(
      'title'     => __( 'Description', 'mapti' ),
      'priority'  => 10,
      'callback'  => 'mapti_game_description_tab'
    );

    $instructions = get_post_meta( $post->ID, 'mabp_instructions', true );

    if ( $instructions ) {
      $tabs['instructions'] = array(
        'title'     => __( 'Instructions', 'mapti' ),
        'priority'  => 10,
        'callback'  => 'mapti_game_instruction_tab'
      );
    }

    if ( function_exists( 'is_leaderboard_game' ) && is_leaderboard_game() ) {
      $tabs['scores'] = array(
        'title'     => __( 'Scores', 'mapti' ),
        'priority'  => 10,
        'callback'  => 'mapti_game_scores_tab'
      );
    }

    if ( get_post_meta($post->ID, "mabp_video_url", true) ) {
      $tabs['video'] = array(
        'title'     => __( 'Video', 'mapti' ),
        'priority'  => 10,
        'callback'  => 'mapti_game_video_tab'
      );
    }
  }

  return $tabs;
}
add_filter( 'mapti_game_tabs', 'mapti_default_game_tabs' );

/**
 * Output the game tabs
 *
 * @version 1.0.0
 * @access  public
 * @return  void
 */
function mapti_output_game_data_tabs() {
  mapti_get_template( 'single-game/tabs/tabs.php' );
}
add_action( 'mapti_after_single_game', 'mapti_output_game_data_tabs', 10 );

/**
 * Output the game description tab content
 *
 * @version 1.0.0
 * @access  public
 * @return  void
 */
function mapti_game_description_tab() {
  mapti_get_template( 'single-game/tabs/description.php' );
}

/**
 * Output the game instructions tab content
 *
 * @version 1.0.0
 * @access  public
 * @return  void
 */
function mapti_game_instruction_tab() {
  mapti_get_template( 'single-game/tabs/instructions.php' );
}

/**
 * Output the game scores tab content
 *
 * @version 1.0.0
 * @access  public
 * @return  void
 */
function mapti_game_scores_tab() {
  mapti_get_template( 'single-game/tabs/scores.php' );
}

/**
 * Output the game video tab content
 *
 * @version 1.1.0
 * @since   1.1.0
 * @return  void
 */
function mapti_game_video_tab() {
  mapti_get_template( 'single-game/tabs/video.php');
}

/**
 * Output the startof a game loop. By default this is a UL
 *
 * @version 1.0.0
 * @access  public
 * @param   boolean $echo
 * @return  string
 */
function mapti_game_loop_start( $echo = true ) {
  ob_start();

  mapti_get_template( 'loop/loop-start.php' );

  if ( $echo ) {
    echo ob_get_clean();
  }
  else {
    return ob_get_clean();
  }
}

/**
 * Output the end of a game loop.
 *
 * @version 1.0.0
 * @access  public
 * @param   boolean $echo
 * @return  string
 */
function mapti_game_loop_end( $echo = true ) {
  ob_start();

  mapti_get_template( 'loop/loop-end.php' );

  if ( $echo ) {
    echo ob_get_clean();
  }
  else {
    return ob_get_clean();
  }
}

/**
 * Output the pagination
 *
 * @version 1.0.0
 * @return  void
 */
function mapti_pagination() {
  mapti_get_template( 'loop/pagination.php' );
}
add_action( 'mapti_after_games_loop', 'mapti_pagination', 10 );

/**
 * Displays the content on game archive page
 *
 * @version 1.0.0
 * @return  void
 */
function mapti_content_game_archive( $content = '' ) {
  global $wp_query;

  ob_start();

  //$template =  get_option( 'mapti_archive_tempalte', 'newest' );

  $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

  query_posts( array(
      'post_type' => 'game',
      'posts_per_page' => get_option( 'mapti_games_per_page', 12 ),
      'paged' => $paged,
    )
  );

  if ( have_posts() ) :
    mapti_game_loop_start();

    while ( have_posts() ) : the_post();
      mapti_get_template_part( 'content', 'game' );
    endwhile;

    mapti_game_loop_end();

    ?>
    <div style="clear:both"></div>
    <?php
    do_action( 'mapti_after_games_loop' );
  endif;

  wp_reset_query();

  return ob_get_clean();
}

/**
 * Display the content on game single page
 *
 * @version 1.1.0
 * @since   1.0.0
 * @param   string $content post content
 * @return  string new post content
 */
function mapti_content_game_single( $content = '' ) {
  global $post;

  // Remove content filter
  remove_filter( 'the_content', 'mapti_content_game_single' );

  if ( function_exists( 'get_game' ) ) {
    ob_start();

    mapti_get_template_part( 'content', 'single-game' );

    $content = ob_get_clean();
  }

  return $content;
}

/**
 * Displays the content on game taxonomie page
 *
 * @version 1.0.0
 * @return  void
 */
function mapti_content_game_taxonomies( $content = '' ) {
  global $wp_query;

  ob_start();

  $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

  if ( ! empty( $wp_query->query['game_tag'] ) ) {
    query_posts( array(
          'post_type' => 'game',
          'posts_per_page' => "-1",
          'paged' => $paged,
          'game_tag' => $wp_query->query['game_tag'],
        )
      );
  }
  elseif ( $wp_query->query['game_cat'] ) {
    query_posts( array(
          'post_type' => 'game',
          'posts_per_page' => "-1",
          'paged' => $paged,
          'game_cat' => $wp_query->query['game_cat'],
        )
      );
  }
  else {
    query_posts( array(
        'post_type' => 'game',
        'posts_per_page' => get_option( 'mapti_games_per_page', 12 ),
        'paged' => $paged,
      )
    );
  }


  if ( have_posts() ) :
    mapti_game_loop_start();

    while ( have_posts() ) : the_post();
      mapti_get_template_part( 'content', 'game' );
    endwhile;

    mapti_game_loop_end();

    ?>
    <div style="clear:both"></div>
    <?php
    do_action( 'mapti_after_games_loop' );
  else :
    echo "<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'mapti' ); ?></p>";
  endif;

  wp_reset_query();

  return ob_get_clean();
}

/**
 * Facebook like number formatting
 *
 * @version 1.0.0
 * @param   int $n number
 * @return  string number
 */
function mapti_format_num( $n ) {
  $s = array("K", "M", "G", "T");
  $out = "";
  while ($n >= 1000 && count($s) > 0) {
    $n = $n / 1000.0;
    $out = array_shift($s);
  }

  return round($n, max(0, 3 - strlen((int)$n))) ."$out";
}