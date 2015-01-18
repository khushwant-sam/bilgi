<?php
/**
 * Post types. Registers post types and taxonomies
 *
 * @class Mapti_Post_Types
 * @package MyArcadePlugin/Classes
 * @author Daniel Bakovic <contact@myarcadeplugin.com>
 * @copyright (c) 2014, Daniel Bakovic
 * @license http://myarcadeplugin.com
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

class Mapti_Post_Types {

  /**
   * Hook in methods
   *
   * @version 1.0.0
   * @access public
   * @return void
   */
  public static function init() {
    add_action( 'init', array( __CLASS__, 'register_taxonomies' ) );
    add_action( 'init', array( __CLASS__, 'register_post_types' ) );
    add_action( 'admin_menu', array( __CLASS__, 'removeAddNew') );
    add_action( 'admin_head', array( __CLASS__, 'hide_add_new') );
  }

  /**
   * Register MyArcadePlugin taxonomies.
   *
   * @version 1.0.0
   * @access public
   * @return void
   */
  public static function register_taxonomies() {

    if ( post_type_exists( 'game' ) ) {
      return;
    }

    do_action( 'mapti_register_taxonomy' );

    $permalinks = get_option( 'mapti_permalinks' );

    register_taxonomy( 'game_cat',
      apply_filters( 'mapti_taxonomy_objects_game_cat', array( 'game' ) ),
      apply_filters( 'mapti_taxonomy_args_game_cat', array(
          'hierarchical'          => true,
          'update_count_callback' => '_update_post_term_count',
          'label'                 => __( 'Game Categories', 'mapti' ),
          'labels'                => array(
            'name'                => __( 'Game Categories', 'mapti' ),
            'singular_name'       => __( 'Game Category', 'mapti' ),
            'menu_name'           => _x( 'Categories', 'Admin menu name', 'mapti' ),
            'search_items'        => __( 'Search Game Categories', 'mapti' ),
            'all_items'           => __( 'All Game Categories', 'mapti' ),
            'parent_item'         => __( 'Parent Game Category', 'mapti' ),
            'parent_item_colon'   => __( 'Parent Game Category:', 'mapti' ),
            'edit_item'           => __( 'Edit Game Category', 'mapti' ),
            'update_item'         => __( 'Update Game Category', 'mapti' ),
            'add_new_item'        => __( 'Add New Game Category', 'mapti' ),
            'new_item_name'       => __( 'New Game Category Name', 'mapti' )
          ),
          'show_ui'               => true,
          'query_var'             => true,
          'capabilities'          => array(
            'manage_terms'        => 'manage_categories',
            'edit_terms'          => 'manage_categories',
            'delete_terms'        => 'manage_categories',
            'assign_terms'        => 'edit_posts',
          ),
          'rewrite'               => array(
            'slug'                => empty( $permalinks['category_base'] ) ? _x( 'game-category', 'slug', 'mapti' ) : $permalinks['category_base'],
            'with_front'          => false,
            'hierarchical'        => true,
          ),
        )
      )
    );

    register_taxonomy( 'game_tag',
      apply_filters( 'mapti_taxonomy_objects_game_tag', array( 'game' ) ),
      apply_filters( 'mapti_taxonomy_args_game_tag', array(
          'hierarchical'          => false,
          'update_count_callback' => '_update_post_term_count',
          'label'                 => __( 'Game Tags', 'mapti' ),
          'labels'                => array(
            'name'                => __( 'Game Tags', 'mapti' ),
            'singular_name'       => __( 'Game Tag', 'mapti' ),
            'menu_name'           => _x( 'Tags', 'Admin menu name', 'mapti' ),
            'search_items'        => __( 'Search Game Tags', 'mapti' ),
            'all_items'           => __( 'All Game Tags', 'mapti' ),
            'parent_item'         => __( 'Parent Game Tag', 'mapti' ),
            'parent_item_colon'   => __( 'Parent Game Tag:', 'mapti' ),
            'edit_item'           => __( 'Edit Game Tag', 'mapti' ),
            'update_item'         => __( 'Update Game Tag', 'mapti' ),
            'add_new_item'        => __( 'Add New Game Tag', 'mapti' ),
            'new_item_name'       => __( 'New Game Tag Name', 'mapti' )
          ),
          'show_ui'               => true,
          'query_var'             => true,
          'capabilities'          => array(
            'manage_terms'        => 'manage_categories',
            'edit_terms'          => 'manage_categories',
            'delete_terms'        => 'manage_categories',
            'assign_terms'        => 'edit_posts',
          ),
          'rewrite'               => array(
            'slug'                => empty( $permalinks['tag_base'] ) ? _x( 'game-tag', 'slug', 'mapti' ) : $permalinks['tag_base'],
            'with_front' => false
          ),
        )
      )
    );
  }

  /**
   * Register core post types
   *
   * @access public
   * @return void
   */
  public static function register_post_types() {

    if ( post_type_exists( 'game' ) ) {
      return;
    }

    do_action( 'mapti_register_post_type' );

    $permalinks = get_option( 'mapti_permalinks' );

    //$permalinks     = get_option( 'mapti_permalinks' );
    $game_permalink = empty( $permalinks['game_base'] ) ? _x( 'game', 'slug', 'mapti' ) : $permalinks['game_base'];

    register_post_type( "game",
      apply_filters( 'mapti_register_post_type_game', array(
        'labels'                  => array(
          'name'                  => __( 'Games', 'mapti' ),
          'singular_name'         => __( 'Game', 'mapti' ),
          'menu_name'             => _x( 'Games', 'Admin menu name', 'mapti' ),
          /*'add_new'               => __( 'Add Game', 'mapti' ),
          'add_new_item'          => __( 'Add New Game', 'mapti' ),*/
          'edit'                  => __( 'Edit', 'mapti' ),
          'edit_item'             => __( 'Edit Game', 'mapti' ),
          'new_item'              => __( 'New Game', 'mapti' ),
          'view'                  => __( 'View Game', 'mapti' ),
          'view_item'             => __( 'View Game', 'mapti' ),
          'search_items'          => __( 'Search Games', 'mapti' ),
          'not_found'             => __( 'No Games found', 'mapti' ),
          'not_found_in_trash'    => __( 'No Games found in trash', 'mapti' ),
          'parent'                => __( 'Parent Game', 'mapti' )
        ),
        'description'             => __( 'This is where you can add new games to your site.', 'mapti' ),
        'public'                  => true,
        'show_ui'                 => true,
        'capability_type'         => 'post',
        'map_meta_cap'            => true,
        'publicly_queryable'      => true,
        'exclude_from_search'     => false,
        'hierarchical'            => false, // Hierarchical causes memory issues - WP loads all records!
        'rewrite'                 => $game_permalink ? array( 'slug' => untrailingslashit( $game_permalink ), 'with_front' => false, 'feeds' => true ) : false,
        'query_var'               => true,
        'supports'                => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields' ),
        'has_archive'             => ( $game_page_id = mapti_get_page_id( 'games' ) ) && get_page( $game_page_id ) ? get_page_uri( $game_page_id ) : 'games',
        'show_in_nav_menus'       => true
      ))
    );
  }

  /**
   * Remove "Add New" button from games post type menu
   *
   * @version 1.0.0
   * @access  public
   * @return  void
   */
  public static function removeAddNew() {
    global $submenu;
    unset($submenu['edit.php?post_type=game'][10]); // Removes 'Add New'.
  }

  /**
   * Hide "Add New" button on games post type page
   *
   * @version 1.0.0
   * @access  public
   * @return  void
   */
  public static function hide_add_new() {
    global $post;

    $post_type = ( ! empty( $_REQUEST['post_type'] ) ) ? $_REQUEST['post_type'] : false;

    if ( ! $post_type && isset( $post->post_type) ) {
      $post_type = $post->post_type;
    }

    if ( 'game' == $post_type ) {
      echo '<style type="text/css">.add-new-h2{display:none;}</style>';
    }
  }
}

Mapti_Post_Types::init();