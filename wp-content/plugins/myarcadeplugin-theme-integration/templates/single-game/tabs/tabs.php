<?php
/**
 * Single Game tabs
 *
 * @author    MyArcadePlugin
 * @package   MyArcadePlugin/Templates
 * @version   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see mapti_default_game_tabs()
 */
$tabs = apply_filters( 'mapti_game_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

  <div class="myarcade-tabs">
    <ul class="tabs">
      <?php foreach ( $tabs as $key => $tab ) : ?>

        <li class="<?php echo $key ?>_tab">
          <a href="#tab-<?php echo $key ?>"><?php echo apply_filters( 'mapti_game_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
        </li>

      <?php endforeach; ?>
    </ul>
    <?php foreach ( $tabs as $key => $tab ) : ?>

      <div class="game-tab" id="tab-<?php echo $key ?>">
        <?php call_user_func( $tab['callback'], $key, $tab ) ?>
      </div>

    <?php endforeach; ?>
  </div>

<?php endif; ?>