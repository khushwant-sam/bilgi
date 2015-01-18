<?php
/**
 * Adds settings to the permalinks admin settings page.
 *
 * @class Mapti_Admin_Permalink_Settings
 * @package MyArcadePlugin/Admin/
 * @author Daniel Bakovic <contact@myarcadeplugin.com>
 * @copyright (c) 2014, Daniel Bakovic
 * @license http://myarcadeplugin.com
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

class Mapti_Admin_Permalink_Settings {

  /**
   * Constructor
   *
   * @version 1.0.0
   * @access  public
   */
  public function __construct() {
    $this->settings_init();
    $this->settings_save();
  }

  /**
   * Init our settings
   *
   * @version 1.0.0
   * @access  public
   * @return  void
   */
  public function settings_init() {
    // Add a section to the permalink page
    add_settings_section( 'mapti-permalink', __( 'Game permalink base', 'mapti'), array( $this, 'settings'), 'permalink' );

    // Add our settings
    add_settings_field(
      'mapti_game_category_slug',                     // id
      __( 'Game category base', 'mapti' ),   // setting title
      array( $this, 'game_category_slug_input' ),     // display callback
      'permalink',                                    // settings page
      'optional'                                      // settings section
    );
    add_settings_field(
      'mapti_game_tag_slug',                          // id
      __( 'Game tag base', 'mapti' ),        // setting title
      array( $this, 'game_tag_slug_input' ),          // display callback
      'permalink',                                    // settings page
      'optional'                                      // settings section
    );
  }

  /**
   * Show the settings
   *
   * @version 1.0.0
   * @access  public
   * @return  void
   */
  public function settings() {
    echo wpautop( __( 'These settings control the permalinks used for games. These settings only apply when <strong>not using "default" permalinks above</strong>.', 'mapti' ) );

    $permalinks = get_option( 'mapti_permalinks' );
    $game_permalink = $permalinks['game_base'];

    // Get games page
    $games_page_id   = mapti_get_page_id( 'games' );
    $base_slug    = ( $games_page_id > 0 && get_page( $games_page_id ) ) ? get_page_uri( $games_page_id ) : _x( 'games', 'default-slug', 'mapti' );
    $game_base   = _x( 'game', 'default-slug', 'mapti' );

    $structures = array(
      0 => '',
      1 => '/' . trailingslashit( $game_base ),
      2 => '/' . trailingslashit( $base_slug ),
      3 => '/' . trailingslashit( $base_slug ) . trailingslashit( '%game_cat%' )
    );
    ?>
    <table class="form-table">
      <tbody>
        <tr>
          <th><label><input name="game_permalink" type="radio" value="<?php echo $structures[0]; ?>" class="myarcadetog" <?php checked( $structures[0], $game_permalink ); ?> /> <?php _e( 'Default', 'mapti' ); ?></label></th>
          <td><code><?php echo home_url(); ?>/?game=sample-game</code></td>
        </tr>
        <tr>
          <th><label><input name="game_permalink" type="radio" value="<?php echo $structures[1]; ?>" class="myarcadetog" <?php checked( $structures[1], $game_permalink ); ?> /> <?php _e( 'Game', 'mapti' ); ?></label></th>
          <td><code><?php echo home_url(); ?>/<?php echo $game_base; ?>/sample-game/</code></td>
        </tr>
        <?php if ( $games_page_id ) : ?>
          <tr>
            <th><label><input name="game_permalink" type="radio" value="<?php echo $structures[2]; ?>" class="myarcadetog" <?php checked( $structures[2], $game_permalink ); ?> /> <?php _e( 'Games base', 'mapti' ); ?></label></th>
            <td><code><?php echo home_url(); ?>/<?php echo $base_slug; ?>/sample-game/</code></td>
          </tr>
          <tr>
            <th><label><input name="game_permalink" type="radio" value="<?php echo $structures[3]; ?>" class="myarcadetog" <?php checked( $structures[3], $game_permalink ); ?> /> <?php _e( 'Games base with category', 'mapti' ); ?></label></th>
            <td><code><?php echo home_url(); ?>/<?php echo $base_slug; ?>/game-category/sample-game/</code></td>
          </tr>
        <?php endif; ?>
        <tr>
          <th><label><input name="game_permalink" id="mapti_custom_selection" type="radio" value="custom" class="tog" <?php checked( in_array( $game_permalink, $structures ), false ); ?> />
            <?php _e( 'Custom Base', 'mapti' ); ?></label></th>
          <td>
            <input name="game_permalink_structure" id="mapti_permalink_structure" type="text" value="<?php echo esc_attr( $game_permalink ); ?>" class="regular-text code"> <span class="description"><?php _e( 'Enter a custom base to use. A base <strong>must</strong> be set or WordPress will use default instead.', 'mapti' ); ?></span>
          </td>
        </tr>
      </tbody>
    </table>
    <script type="text/javascript">
      jQuery(function(){
        jQuery('input.myarcadetog').change(function() {
          jQuery('#mapti_permalink_structure').val( jQuery(this).val() );
        });

        jQuery('#mapti_permalink_structure').focus(function(){
          jQuery('#mapti_custom_selection').click();
        });
      });
    </script>
    <?php
  }

  /**
   * Show the category input box
   *
   * @version 1.0.0
   * @access  public
   * @return  void
   */
  public function game_category_slug_input() {
    $permalinks = get_option( 'mapti_permalinks' );
    ?>
    <input name="mapti_game_category_slug" type="text" class="regular-text code" value="<?php if ( isset( $permalinks['category_base'] ) ) echo esc_attr( $permalinks['category_base'] ); ?>" placeholder="<?php echo _x('game-category', 'slug', 'mapti') ?>" />
    <?php
  }

  /**
   * Show the tag input box
   *
   * @version 1.0.0
   * @access  public
   * @return  void
   */
  public function game_tag_slug_input() {
    $permalinks = get_option( 'mapti_permalinks' );
    ?>
    <input name="mapti_game_tag_slug" type="text" class="regular-text code" value="<?php if ( isset( $permalinks['tag_base'] ) ) echo esc_attr( $permalinks['tag_base'] ); ?>" placeholder="<?php echo _x('game-tag', 'slug', 'mapti') ?>" />
    <?php
  }

  /**
   * Save the settings
   *
   * @version 1.0.0
   * @access  public
   * @return  void
   */
  public function settings_save() {
    if ( ! is_admin() ) {
      return;
    }

    // We need to save the options ourselves; settings api does not trigger save for the permalinks page
    if ( isset( $_POST['permalink_structure'] ) || isset( $_POST['category_base'] ) && isset( $_POST['game_permalink'] ) ) {
      // Cat and tag bases
      $mapti_game_category_slug = mapti_clean( $_POST['mapti_game_category_slug'] );
      $mapti_game_tag_slug = mapti_clean( $_POST['mapti_game_tag_slug'] );

      $permalinks = get_option( 'mapti_permalinks' );

      if ( ! $permalinks ) {
        $permalinks = array();
      }

      $permalinks['category_base']  = untrailingslashit( $mapti_game_category_slug );
      $permalinks['tag_base']       = untrailingslashit( $mapti_game_tag_slug );

      // Game base
      $game_permalink = mapti_clean( $_POST['game_permalink'] );

      if ( $game_permalink == 'custom' ) {
        // Get permalink without slashes
        $game_permalink = trim( mapti_clean( $_POST['game_permalink_structure'] ), '/' );

        // This is an invalid base structure and breaks pages
        if ( '%game_cat%' == $game_permalink ) {
          $game_permalink = _x( 'game', 'slug', 'mapti' ) . '/' . $game_permalink;
        }

        // Prepending slash
        $game_permalink = '/' . $game_permalink;
      }
      elseif ( empty( $game_permalink ) ) {
        $game_permalink = false;
      }

      $permalinks['game_base'] = untrailingslashit( $game_permalink );

      update_option( 'mapti_permalinks', $permalinks );
    }
  }
}

return new Mapti_Admin_Permalink_Settings();