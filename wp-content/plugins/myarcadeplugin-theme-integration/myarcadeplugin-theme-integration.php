<?php
/**
 * Plugin Name:  MyArcadePlugin - Theme Integration
 * Plugin URI:   http://myarcadeplugin.com
 * Description:  Integrates MyArcadePlugin with existing non arcade themes.
 * Version:      1.1.0
 * Author:       Daniel Bakovic
 * Author URI:   http://myarcadeplugin.com
 * Requires at least: 3.6
 * Tested up to: 4.0
 */

// No direct Access
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( ! class_exists( 'MyArcadeThemeIntegration' ) ) {
/**
 * Main MyArcadeThemeIntegration Class
 */
final class MyArcadeThemeIntegration {

  /**
   * @var string Holds the version number
   */
  public $version = '1.1.0';

  /**
   * @var array options
   */
  public $options = array();

  /**
   * @var Mapti_Query $query
   */
  public $query = null;

  /**
   * @var The single instance
   */
  protected static $_instance = null;

  /**
   * @var string Plugin URL
   */
  public $plugin_url;

  /**
   * @var string Plugin Path
   */
  public $plugin_path;

  /**
   * @var string Plugin file name
   */
  public $plugin_file;

  /**
   * @var string Plugin basename
   */
  public $plugin_basename;

  /**
   * Main Instance
   *
   * Ensures only one instance is loaded or can be loaded.
   *
   * @static
   * @return Main instance
   */
  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  /**
   * Cloning is forbidden.
   *
   * @access public
   */
  public function __clone() {

    _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
  }

  /**
   * Unserializing instances of this class is forbidden.
   *
   * @access public
   */
  public function __wakeup() {

    _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
  }

  /**
   * Constructor.
   *
   * @version 1.0.0
   * @access public
   * @return void
   */
  public function __construct() {
    global $wpdb;

    // Auto-load classes on demand
    if ( function_exists( "__autoload" ) ) {
      spl_autoload_register( "__autoload" );
    }
    spl_autoload_register( array( $this, 'autoload' ) );

    // Include required files
    $this->includes();

    // Hooks
    add_action( 'init', array( $this, 'init' ), 0 );
  }

  /**
   * Auto-load in-accessible properties on demand.
   *
   * @param mixed $key
   * @return mixed
   */
  public function __get( $key ) {
    if ( method_exists( $this, $key ) ) {
      return $this->$key();
    }

    return false;
  }

  /**
   * Auto-load classes on demand to reduce memory consumption
   *
   * @version 1.0.0
   * @access public
   * @param mixed $class
   * @return void
   */
  public function autoload( $class ) {

    $class = strtolower( $class );
    $path = $this->plugin_path() . '/includes/';
    $file = 'class-' . str_replace( '_', '-', $class ) . '.php';

    if ( strpos( $class, 'mapti_archive_template_') === 0 ) {
      $path .= 'archive-templates/';

      if ( is_readable( $path . $file ) ) {
        include_once( $path . $file );
        return;
      }
    }
    elseif ( strpos( $class, 'mapti_single_template_') === 0 ) {
      $path .= 'single-templates/';

      if ( is_readable( $path . $file ) ) {
        include_once( $path . $file );
        return;
      }
    }
    elseif ( strpos( $class, 'mapti_' ) === 0 ) {

      if ( strpos( $class, 'mapti_admin' ) === 0 ) {
        $path .= 'admin/';
      }

      if ( is_readable( $path . $file ) ) {
        include_once( $path . $file );
        return;
      }
    }
  }

  /**
   * Include required core files used in admin and on the frontend.
   *
   * @version 1.0.0
   * @return  void
   */
  public function includes() {

    include_once( 'includes/mapti-core-functions.php' );
    include_once( 'includes/mapti-conditional-functions.php' );

    if ( is_admin() ) {
      include_once( 'includes/admin/class-mapti-admin.php' );
    }

    // Load template loader
    if ( ! is_admin() || defined( 'DOING_AJAX' ) ) {
      include_once( 'includes/myarcade_api.php' );
      include_once( 'includes/class-mapti-template-loader.php' );
      include_once( 'includes/class-mapti-frontend-scripts.php' );
    }

    // Query class
    $this->query = include( 'includes/class-mapti-query.php' );

    include_once( 'includes/class-mapti-post-types.php' );
    include_once( 'includes/mapti-template-functions.php' );
  }

  /**
   * Init when WordPress initializes
   *
   * @version 1.0.0
   * @access  public
   * @return  [type] [description]
   */
  public function init() {
    // Set up localisation
    $this->load_plugin_textdomain();
  }

  /**
   * Load textdomain files
   *
   * @version 1.0.0
   * @access public
   * @return  void
   */
  public function load_plugin_textdomain() {
    $locale = apply_filters( 'plugin_locale', get_locale(), 'mapti' );
    $dir    = trailingslashit( WP_LANG_DIR );

    load_textdomain( 'mapti', $dir . 'mapti/mapti-' . $locale . '.mo' );
    load_plugin_textdomain( 'mapti', false, $dir . 'plugins' );
  }

  /**
   * Get the template path
   *
   * @version 1.0.0
   * @access  public
   * @return  string
   */
  public function template_path() {
    return apply_filters( 'mapti_template_path', 'myarcade/' );
  }

  /**
   * Get the plugin url.
   *
   * @version 1.0.0
   * @access public
   * @return string Plugin URL
   */
  function plugin_url() {
    if ( $this->plugin_url ) return $this->plugin_url;

    return $this->plugin_url = plugins_url( basename( plugin_dir_path(__FILE__) ), basename( __FILE__ ) );
  }

  /**
   * Get the plugin path.
   *
   * @version 1.0.0
   * @access public
   * @return string
   */
  public function plugin_path() {
    if ( $this->plugin_path ) return $this->plugin_path;

    return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
  }

  /**
   * Get plugin file name
   *
   * @version 1.0.0
   * @access public
   * @return string
   */
  public function plugin_file() {
    if ( $this->plugin_file ) return $this->plugin_file;

    return $this->plugin_file = plugin_dir_path( __FILE__ );
  }

  /**
   * Get plugin basename
   *
   * @version 1.0.0
   * @access public
   * @return string
   */
  public function plugin_basename() {
    if ( $this->plugin_basename ) return $this->plugin_basename;

    return $this->plugin_basename = plugin_basename( $this->plugin_file() );
  }
}
}

/**
 * Returns the main instance to prevent the need to use globals.
 *
 * @version 1.0.0
 * @access  public
 * @return  object
 */
function mapti() {
  return MyArcadeThemeIntegration::instance();
}

// Create a new instance
mapti();