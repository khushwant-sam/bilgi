<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

/**
 * Admin.
 *
 * @class Mapti_Admin
 */
class Mapti_Admin {

  /**
   * Constructor
   */
  public function __construct() {
    add_action( 'init', array( $this, 'includes' ) );
    add_action( 'current_screen', array( $this, 'conditonal_includes' ) );
  }

  /**
   * Include any classes we need within admin.
   */
  public function includes() {

    include_once( 'class-mapti-admin-post-type.php' );

    // Classes we only need during non-ajax requests
    if ( ! is_ajax() ) {
      include_once( 'class-mapti-admin-menus.php' );
    }
  }

  /**
   * Include admin files conditionally
   */
  public function conditonal_includes() {

    $screen = get_current_screen();

    switch ( $screen->id ) {
      case 'options-permalink' :
        include( 'class-mapti-admin-permalink-settings.php' );
      break;
    }
  }
}

return new Mapti_Admin();
