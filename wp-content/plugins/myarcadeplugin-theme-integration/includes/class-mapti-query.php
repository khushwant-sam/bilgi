<?php
/**
 * Contains the query functions which alter the front-end post queries and loops.
 *
 * @class     Mapti_Query
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

if ( ! class_exists( 'Mapti_Query' ) ) :
class Mapti_Query {
  /**
   * Constructor for the query class. Hooks in methods.
   *
   * @access public
   */
  public function __construct() {
    add_action( 'init', array( $this, 'add_rewrite_endpoints' ) );

    if ( ! is_admin() ) {
      add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
    }
  }

  /**
   * Hook into pre_get_posts to do the main game query
   *
   * @access public
   * @param mixed $q query object
   * @return void
   */
  public function pre_get_posts( $q ) {
    global  $wp_post_types;

    // We only want to affect the main query
    if ( ! $q->is_main_query() ) {
      return;
    }

    // Fix for verbose page rules
    if ( $GLOBALS['wp_rewrite']->use_verbose_page_rules && isset( $q->queried_object_id ) && $q->queried_object_id === mapti_get_page_id( 'games' ) ) {

      $q->set( 'post_type', 'game' );
      $q->set( 'page', '' );
      $q->set( 'pagename', '' );

      // Fix conditional Functions
      $q->is_archive           = true;
      $q->is_post_type_archive = true;
      $q->is_singular          = false;
      $q->is_page              = false;
    }
  }

  /**
   * Add required permalink endpoints
   *
   * @version 1.0.0
   * @access  public
   */
  public function add_rewrite_endpoints() {
    add_rewrite_endpoint( 'fullscreen', EP_PERMALINK );
  }
}

endif;

return new Mapti_Query();