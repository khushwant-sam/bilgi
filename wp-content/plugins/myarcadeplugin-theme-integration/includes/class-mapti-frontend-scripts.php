<?php
/**
 * Handle frontend scripts
 *
 * @version   1.0.0
 * @package   MyArcade/Classes/
 * @author Daniel Bakovic <contact@myarcadeplugin.com>
 * @copyright (c) 2014, Daniel Bakovic
 * @license http://myarcadeplugin.com
 */
class Mapti_Frontend_Scripts {

  /**
   * Constructor
   *
   * @version 1.0.0
   * @access  public
   */
  public function __construct() {
    //add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts'), 99 );
  }

  /**
   * Register/queue frontend scripts
   *
   * @version 1.0.0
   * @access  public
   * @return  void
   */
  public static function load_scripts() {

    //$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    $suffix = '';
    $assets_path = str_replace( array( 'http:', 'https:' ), '', mapti()->plugin_url() ) . '/assets/';
    $frontend_script_path = $assets_path . 'js/frontend/';

    if ( ( function_exists('is_game') && is_game() ) || is_post_type_archive( 'game' ) || is_page( mapti_get_page_id( 'games' ) ) ) {
      wp_enqueue_style( 'mapti-general', $assets_path . 'css/mapti.css' );
    }

    if ( function_exists('is_game') && is_game() ) {
      wp_register_script( 'mapti-single-game', $frontend_script_path . 'single-game' . $suffix . '.js', array( 'jquery' ), mapti()->version, true );
      wp_enqueue_script( 'mapti-single-game' );
    }
  }
}

//new Mapti_Frontend_Scripts();