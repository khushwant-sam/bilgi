<?php
/**
 * Setup menus in WP admin.
 *
 * @author    MyArcadePlugin
 * @category  Admin
 * @package   MyArcadePlugin/Admin
 * @version   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

if ( ! class_exists( 'Mapti_Admin_Menus' ) ) :

/**
 * WC_Admin_Menus Class
 */
class Mapti_Admin_Menus {

  /**
   * Hook in tabs.
   */
  public function __construct() {
    // Add menus
    add_action( 'admin_menu', array( $this, 'admin_menu' ), 50 );
  }

  /**
   * Add menu items
   */
  public function admin_menu() {

    add_submenu_page( 'myarcade_admin.php', __('Theme Integration',  'mapti'), __('Theme Integration',  'mapti'), 'manage_options',  'mapti-settings',  array( $this, 'settings_page' ) );
  }

  /**
   * Init the settings page
   */
  public function settings_page() {
    Mapti_Admin_Settings::output();
  }
}

endif;

return new Mapti_Admin_Menus();
