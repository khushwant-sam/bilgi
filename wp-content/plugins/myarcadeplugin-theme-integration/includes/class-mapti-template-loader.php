<?php
/**
 * MyAracadePlugin Template Loader
 *
 * @class MyArcade_Template_Loader
 * @package MyArcadePlugin/Classes/Template
 * @author Daniel Bakovic <contact@myarcadeplugin.com>
 * @copyright (c) 2014, Daniel Bakovic
 * @license http://myarcadeplugin.com
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

class Mapti_Template_Loader {

  /**
   * Contructor
   *
   * @version 1.1.0
   * @since   1.0.0
   * @access  public
   * @static
   * @return  void
   */
  public static function init() {
    add_action( 'template_redirect', array( __CLASS__, 'template_redirect' ) );
    add_action( 'the_content', array( __CLASS__, 'game_template' ) );
  }

  /**
   * Redirect game arcive page to a regular page tempalte and reset the post query
   *
   * @version 1.1.0
   * @since   1.0.0
   * @access public
   * @static
   * @return  void
   */
  public static function template_redirect() {
    global $wp_query;

    if ( mapti_is_arcade() ) {

      $page_id = mapti_get_page_id( 'games' );
      $wp_query->post = get_post( $page_id );

      // Set up reset post args
      $reset_post_args = array(
        'ID'          => $page_id,
        'is_404'      => true,
        'post_status' => 'publish',
      );

      // MyArcade Archive Page
      add_filter( 'the_content', 'mapti_content_game_archive' );
      Mapti_Frontend_Scripts::load_scripts();

      /*$wp_query->is_page     = true;
      $wp_query->is_singular = false;
      $wp_query->is_404      = false;
      $wp_query->is_archive  = false;*/
      $wp_query->is_post_type_archive = false;

      self::reset_post( array(
        'ID'             => mapti_get_page_id( 'games' ),
        'post_title'     => get_the_title( mapti_get_page_id( 'games' ) ),
        'post_author'    => 0,
        'post_date'      => 0,
        'post_content'   => '',
        'post_type'      => 'game',
        'post_status'    => 'publish',
        'is_page'        => true,
        'comment_status' => 'closed',
      ) );
    }
    elseif ( is_tax( 'game_cat' ) || is_tax( 'game_tag' ) ) {
      // Arcade Taxonomie Page
      add_filter( 'the_content', 'mapti_content_game_taxonomies' );
      Mapti_Frontend_Scripts::load_scripts();

      if ( ! empty( $wp_query->queried_object->name ) ) {
        $term = '"'.$wp_query->queried_object->name.'"';
      }
      else {
        $term = '"'. ucfirst( get_query_var( 'term' ) ) . '"';
      }

      //$wp_query->is_page     = true;
      //$wp_query->is_singular = false;
      //$wp_query->is_404      = false;
      //$wp_query->is_archive  = false;
      $wp_query->is_post_type_archive = false;

      self::reset_post( array(
        'ID'             => mapti_get_page_id( 'games' ),
        'post_title'     => get_the_title( mapti_get_page_id( 'games' ) ),
        'post_author'    => 0,
        'post_date'      => 0,
        'post_content'   => '',
        'post_type'      => 'game',
        'post_status'    => 'publish',
        'is_page'        => true,
        'comment_status' => 'closed',
      ) );
    }
    elseif ( is_single() && 'game' == get_post_type() ) {
      // Arcade Single View / Fullscreen Handling
      if ( isset( $wp_query->query_vars['fullscreen'] ) ) {
        $find = array();
        $file = '';

        $file   = 'fullscreen-game.php';
        $find[] = $file;
        $find[] = mapti()->template_path() . $file;

        if ( $file ) {
          $template = locate_template( $find );

          if ( ! $template ) {
            $template = mapti()->plugin_path() . '/templates/' . $file;
          }
        }

        include $template;
        exit;
      }
    }
  }

  /**
   * single game
   *
   * @version 1.1.0
   * @since   1.1.0
   * @access  public
   * @static
   * @param   string $content Post content
   * @return  string Post content
   */
  public static function game_template( $content ) {

    $is_single = is_single();
    $post_type = get_post_type();

    if ( is_single() && "game" == get_post_type() && function_exists( 'get_game' ) ) {
      // Remove content filter
      remove_filter( 'the_content', array( __CLASS__, 'game_template' ) );
      $content = mapti_content_game_single( $content );
      Mapti_Frontend_Scripts::load_scripts();
    }

    return $content;
  }

  /**
   * Reset post
   *
   * @version 1.1.0
   * @since   1.1.0
   * @static
   * @param   array $args
   * @return  void
   */
  public static function reset_post( $args = array() ) {
    global $wp_query, $post;

    // Switch defaults if post is set
    if ( isset( $wp_query->post ) ) {
      $dummy = wp_parse_args( $args, array(
        'ID'                    => $wp_query->post->ID,
        'post_status'           => $wp_query->post->post_status,
        'post_author'           => $wp_query->post->post_author,
        'post_parent'           => $wp_query->post->post_parent,
        'post_type'             => $wp_query->post->post_type,
        'post_date'             => $wp_query->post->post_date,
        'post_date_gmt'         => $wp_query->post->post_date_gmt,
        'post_modified'         => $wp_query->post->post_modified,
        'post_modified_gmt'     => $wp_query->post->post_modified_gmt,
        'post_content'          => $wp_query->post->post_content,
        'post_title'            => $wp_query->post->post_title,
        'post_excerpt'          => $wp_query->post->post_excerpt,
        'post_content_filtered' => $wp_query->post->post_content_filtered,
        'post_mime_type'        => $wp_query->post->post_mime_type,
        'post_password'         => $wp_query->post->post_password,
        'post_name'             => $wp_query->post->post_name,
        'guid'                  => $wp_query->post->guid,
        'menu_order'            => $wp_query->post->menu_order,
        'pinged'                => $wp_query->post->pinged,
        'to_ping'               => $wp_query->post->to_ping,
        'ping_status'           => $wp_query->post->ping_status,
        'comment_status'        => $wp_query->post->comment_status,
        'comment_count'         => $wp_query->post->comment_count,
        'filter'                => $wp_query->post->filter,

        'is_404'                => false,
        'is_page'               => false,
        'is_single'             => false,
        'is_archive'            => false,
        'is_tax'                => false,
      ) );
    }
    else {
      $dummy = wp_parse_args( $args, array(
        'ID'                    => -9999,
        'post_status'           => 'public',
        'post_author'           => 0,
        'post_parent'           => 0,
        'post_type'             => 'page',
        'post_date'             => 0,
        'post_date_gmt'         => 0,
        'post_modified'         => 0,
        'post_modified_gmt'     => 0,
        'post_content'          => '',
        'post_title'            => '',
        'post_excerpt'          => '',
        'post_content_filtered' => '',
        'post_mime_type'        => '',
        'post_password'         => '',
        'post_name'             => '',
        'guid'                  => '',
        'menu_order'            => 0,
        'pinged'                => '',
        'to_ping'               => '',
        'ping_status'           => '',
        'comment_status'        => 'closed',
        'comment_count'         => 0,
        'filter'                => 'raw',

        'is_404'                => false,
        'is_page'               => false,
        'is_single'             => false,
        'is_archive'            => false,
        'is_tax'                => false,
      ) );
    }

    // Bail if dummy post is empty
    if ( empty( $dummy ) ) {
      return;
    }

    // Set the $post global
    $post = new WP_Post( (object) $dummy );

    // Copy the new post global into the main $wp_query
    $wp_query->post       = $post;
    $wp_query->posts      = array( $post );

    // event comments form from appearing
    $wp_query->post_count = 1;
    $wp_query->is_404     = $dummy['is_404'];
    $wp_query->is_page    = $dummy['is_page'];
    $wp_query->is_single  = $dummy['is_single'];
    $wp_query->is_archive = $dummy['is_archive'];
    $wp_query->is_tax     = $dummy['is_tax'];

    // Clean up the dummy post
    unset( $dummy );

    /**
     * Force the header back to 200 status if not a deliberate 404
     *
     * @see http://bbpress.trac.wordpress.org/ticket/1973
     */
    if ( ! $wp_query->is_404() ) {
      status_header( 200 );
    }

    add_filter( 'get_edit_post_link', array( __CLASS__, 'filter_edit_post_link' ), 10, 2 );
  }

  /**
   * Filter the edit post link to avoid display in arcade pages
   *
   * @version 1.1.0
   * @since   1.1.0
   * @access  public
   * @static
   * @param   string  $edit_link The edit link
   * @param   integer $post_id   Post ID
   * @return  mixed              Will be a boolean (false) if $post_id is 0. Will be a string (the unchanged edit link) otherwise.
   */
  public static function filter_edit_post_link ( $edit_link = '', $post_id = 0 ) {
    if ( 0 == $post_id ) {
      $edit_link = false;
    }

    return $edit_link;
  }
}

Mapti_Template_Loader::init();