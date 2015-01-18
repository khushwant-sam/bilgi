<?php
/**
 * General Settings
 *
 * @author    MyArcadePlugin
 * @category  Admin
 * @package   Admin
 * @version   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

if ( ! class_exists( 'Mapti_Settings_General' ) ) :

/**
 * WC_Admin_Settings_General
 */
class Mapti_Settings_General extends Mapti_Settings_Page {

  /**
   * Constructor.
   */
  public function __construct() {
    $this->id    = 'general';
    $this->label = __( 'General', 'mapti' );

    add_filter( 'mapti_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
    add_action( 'mapti_settings_' . $this->id, array( $this, 'output' ) );
    add_action( 'mapti_settings_save_' . $this->id, array( $this, 'save' ) );
  }

  /**
   * Get settings array
   *
   * @version 1.1.0
   * @since   1.0.0
   * @access  public
   * @return array
   */
  public function get_settings() {

    return apply_filters( 'mapti_general_settings', array(

      array( 'title' => __( 'General Options', 'mapti' ), 'type' => 'title', 'desc' => '', 'id' => 'general_options' ),

        array(
          'title' => __( 'Arcade Archive Page', 'mapti' ),
          'desc'    => '<br/>' . sprintf( __( 'The base page can also be used in your <a href="%s">game permalinks</a>.', 'mapti' ), admin_url( 'options-permalink.php' ) ),
          'id'    => 'mapti_games_page_id',
          'type'    => 'single_select_page',
          'default' => '',
          'css'     => 'min-width:300px;',
        ),

        /*array(
          'title' => __( 'Arcade Template', 'mapti' ),
          'desc'    => '<br/>' . __( 'Select a template how games should be displayed on the arcade page.', 'mapti' ),
          'id'    => 'mapti_archive_template',
          'type'    => 'select',
          'default' => 'newest',
          'css'     => 'min-width:300px;',
          'options' => array(
            'newest'    => __("Newest games first", 'mapti'),
            'category'  => __("Category groups", 'mapti' ),
          ),
        ),*/

        array(
          'title' => __( 'Games Per Page', 'mapti' ),
          'desc'    => '<br/>' . __( 'Set how many games should be displayed at most.', 'mapti' ),
          'id'    => 'mapti_games_per_page',
          'type'    => 'number',
          'default' => '12',
          'css'     => 'min-width:300px;',
        ),

        array(
          'title' => __( 'Games Per Row', 'mapti' ),
          'desc'    => '<br/>' . __( 'Set how many games should be displayed per row to fit your theme.', 'mapti' ),
          'id'    => 'mapti_games_per_row',
          'type'    => 'number',
          'default' => '4',
          'css'     => 'min-width:300px;',
        ),

        array(
          'title' => __( 'Game Title Heading', 'mapti' ),
          'desc'    => '<br/>' . __( 'Select a heading for arcade archive page that best fits your theme.', 'mapti' ),
          'id'    => 'mapti_archive_heading',
          'type'    => 'select',
          'default' => 'h3',
          'css'     => 'min-width:300px;',
          'options' => array(
            'h1' => 'Heading 1',
            'h2' => 'Heading 2',
            'h3' => 'Heading 3',
            'h4' => 'Heading 4',
            'h5' => 'Heading 5',
            'h6' => 'Heading 6' ),
        ),

      array( 'type' => 'sectionend', 'id' => 'general_options'),
    ) ); // End general settings
  }

  /**
   * Save settings
   */
  public function save() {
    $settings = $this->get_settings();

    Mapti_Admin_Settings::save_fields( $settings );
  }
}

endif;

return new Mapti_Settings_General();