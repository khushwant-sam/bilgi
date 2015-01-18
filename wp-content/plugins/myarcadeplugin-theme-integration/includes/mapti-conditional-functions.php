<?php
/**
 * MyArcadePlugin Conditional Functions
 *
 * Functions for determinating the current query/page.
 *
 * @package MyArcadePlugin/Classes/Tempalte
 * @author Daniel Bakovic <contact@myarcadeplugin.com>
 * @copyright (c) 2014, Daniel Bakovic
 * @license http://myarcadeplugin.com
 */

/**
 * is_myarcade - Returns true if on a page which uses MyArcadePlugin templates
 *
 * @access public
 * @return bool
 */
function mapti_is_myarcade() {
  return ( mapti_is_arcade() || mapti_is_game_taxonomy() || mapti_is_game() ) ? true : false;
}

/**
 * is_arcade - Returns true when viewing the game type archive (games).
 *
 * @access public
 * @return bool
 */
function mapti_is_arcade() {
  return ( is_post_type_archive( 'game' ) || is_page( mapti_get_page_id( 'games' ) ) );
}

/**
 * is_game_taxonomy - Returns true when viewing a game taxonomy archive.
 *
 * @access public
 * @return bool
 */
function mapti_is_game_taxonomy() {
  return is_tax( get_object_taxonomies( 'game' ) );
}

/**
 * is_game_category - Returns true when viewing a game category.
 *
 * @access public
 * @param string $term (default: '') The term slug your checking for. Leave blank to return true on any.
 * @return bool
 */
function mapti_is_game_category( $term = '' ) {
  return is_tax( 'game_cat', $term );
}

/**
 * is_game - Returns true when viewing a single game.
 *
 * @access public
 * @return bool
 */
function mapti_is_game( $post_id = false ) {
  global $post;

  if ( is_singular( array( 'game') ) ) {
    return true;
  }

  if ( ! $post_id ) {
    if ( ! isset( $post->ID ) ) {
      return false;
    }

    $post_id = $post->ID;
  }

  if ( get_post_meta( $post_id, "mabp_swf_url", true) ) {
    return true;
  }
  else {
    return false;
  }
}


if ( ! function_exists( 'is_ajax' ) ) {

  /**
   * is_ajax - Returns true when the page is loaded via ajax.
   *
   * @access public
   * @return bool
   */
  function is_ajax() {
    if ( defined('DOING_AJAX') ) {
      return true;
    }

    return ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) ? true : false;
  }
}