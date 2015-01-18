<?php
/**
 * Core Functions
 *
 * Functions available on both the front-end and admin
 *
 * @author    Daniel Bakovic <contact@myarcadeplugin.com>
 */

/**
 * Clean variables
 *
 * @version 1.0.0
 * @access public
 * @param string $var
 * @return string
 */
function mapti_clean( $var ) {
  return sanitize_text_field( $var );
}

/**
 * Retrieve page ids - used for games. Returns -1 if no page is found.
 *
 * @version 1.0.0
 * @access  public
 * @param   string $page Page slug
 * @return  int Page ID
 */
function mapti_get_page_id( $page ) {

  $page = get_option( 'mapti_' . $page . '_page_id' );

  return $page ? absint($page) : -1;
}

/**
 * Get template part (for templates like the games-loop).
 *
 * @access public
 * @param mixed $slug
 * @param string $name (default: '')
 * @return void
 */
function mapti_get_template_part( $slug, $name = '' ) {
  $template = '';

  // Look in yourtheme/slug-name.php and yourtheme/myarcade/slug-name.php
  if ( $name ) {
    $template = locate_template( array ( "{$slug}-{$name}.php", mapti()->template_path() . "{$slug}-{$name}.php" ) );
  }

  // Get default slug-name.php
  if ( !$template && $name && file_exists( mapti()->plugin_path() . "/templates/{$slug}-{$name}.php" ) ) {
    $template = mapti()->plugin_path() . "/templates/{$slug}-{$name}.php";
  }

  // If template file doesn't exist, look in yourtheme/slug.php and yourtheme/myarcade/slug.php
  if ( !$template ) {
    $template = locate_template( array ( "{$slug}.php", mapti()->template_path() . "{$slug}.php" ) );
  }

  if ( $template ) {
    load_template( $template, false );
  }
}

/**
 * Get other templates (e.g. game attributes) passing attributes and including the file.
 *
 * @access public
 * @param mixed $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */
function mapti_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
  if ( $args && is_array($args) ) {
    extract( $args );
  }

  $located = mapti_locate_template( $template_name, $template_path, $default_path );

  do_action( 'mapti_before_template_part', $template_name, $template_path, $located, $args );

  include( $located );

  do_action( 'mapti_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *    yourtheme   / $template_path  / $template_name
 *    yourtheme   / $template_name
 *    $default_path / $template_name
 *
 * @access public
 * @param mixed $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function mapti_locate_template( $template_name, $template_path = '', $default_path = '' ) {

  if ( ! $template_path ) {
    $template_path = mapti()->template_path();
  }

  if ( ! $default_path ) {
    $default_path = mapti()->plugin_path() . '/templates/';
  }

  // Look within passed path within the theme - this is priority
  $template = locate_template(
    array(
      trailingslashit( $template_path ) . $template_name,
      $template_name
    )
  );

  // Get default template
  if ( ! $template ) {
    $template = $default_path . $template_name;
  }

  // Return what we found
  return apply_filters('mapti_locate_template', $template, $template_name, $template_path);
}

/**
 * Get game categories
 *
 * @version 1.0.0
 * @return  string Comma separated category names
 */
function mapti_get_game_category() {
  global $post;

  $terms = get_the_terms( $post->ID, 'game_cat' );

  if ( $terms && ! is_wp_error( $terms ) ) {
    $category_links = array();

    foreach ( $terms as $term ) {
      $category_inks[] = $term->name;
    }

    return join( ", ", $category_inks );
  }

  return false;
}