<?php
/**
 * Post types admin
 *
 * @class Mapti_Admin_Post_Types
 * @version 1.0.0
 * @package MyArcadePlugin/Classes
 * @author Daniel Bakovic <contact@myarcadeplugin.com>
 * @copyright (c) 2014, Daniel Bakovic
 * @license http://myarcadeplugin.com
 */
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

if ( ! class_exists( 'Mapti_Admin_Post_Types' ) ) :


/**
 * Handles the edit post views
 */
class Mapti_Admin_Post_Types {

  /**
   * Constructor
   *
   * @version 1.0.0
   */
  public function __construct() {
    add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );
    add_filter( 'manage_edit-game_columns', array( $this, 'game_columns' ) );
    add_action( 'manage_game_posts_custom_column', array( $this, 'render_game_columns' ), 2 );
    //add_filter( 'manage_edit-game_sortable_columns', array( $this, 'game_sortable_columns' ) );
  }

  /**
   * Change messages when a post type is updated.
   *
   * @param  array $messages
   * @return array
   */
  public function post_updated_messages( $messages ) {
    global $post, $post_ID;

    $messages['game'] = array(
      0 => '', // Unused. Messages start at index 1.
      1 => sprintf( __( 'Game updated. <a href="%s">View Game</a>', 'mapti' ), esc_url( get_permalink($post_ID) ) ),
      2 => __( 'Custom field updated.', 'mapti' ),
      3 => __( 'Custom field deleted.', 'mapti' ),
      4 => __( 'Game updated.', 'mapti' ),
      5 => isset($_GET['revision']) ? sprintf( __( 'Game restored to revision from %s', 'mapti' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
      6 => sprintf( __( 'Game published. <a href="%s">View Game</a>', 'mapti' ), esc_url( get_permalink($post_ID) ) ),
      7 => __( 'Game saved.', 'mapti' ),
      8 => sprintf( __( 'Game submitted. <a target="_blank" href="%s">Preview Game</a>', 'mapti' ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
      9 => sprintf( __( 'Game scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Game</a>', 'mapti' ),
        date_i18n( __( 'M j, Y @ G:i', 'mapti' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
      10 => sprintf( __( 'Game draft updated. <a target="_blank" href="%s">Preview Game</a>', 'mapti' ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    );

    return $messages;
  }

  /**
   * Define custom columns for games
   *
   * @version 1.1.0
   * @since   1.0.0
   * @param   array $existing_columns
   * @return  array
   */
  public function game_columns( $existing_columns ) {
    if ( empty( $existing_columns ) && ! is_array( $existing_columns ) ) {
      $existing_columns = array();
    }

    unset( $existing_columns['title'], $existing_columns['comments'], $existing_columns['date'] );

    $columns = array();
    $columns['cb']    = '<input type="checkbox" />';
    $columns['thumb'] = '<span class="mapti-image tips" data-tip="' . __( 'Image', 'mapti' ) . '">' . __( 'Image', 'mapti' ) . '</span>';
    $columns['name']  = __( 'Name', 'mapti' );
    $columns['game_cat']  = __( 'Categories', 'mapti' );
    $columns['game_tag']  = __( 'Tags', 'mapti' );
    $columns['date']         = __( 'Date', 'mapti' );

    return array_merge( $columns, $existing_columns );
  }

  /**
   * Ouput custom columns for games
   * @param  string $column
   */
  public function render_game_columns( $column ) {
    global $post;

    switch ( $column ) {

      case 'thumb' :
        echo '<a href="' . get_edit_post_link( $post->ID ) . '"><img src="'.$this->get_thumbnail().'" width="45" height="45" /></a>';
        break;

      case 'name' :
        $edit_link        = get_edit_post_link( $post->ID );
        $title            = _draft_or_post_title();
        $post_type_object = get_post_type_object( $post->post_type );
        $can_edit_post    = current_user_can( $post_type_object->cap->edit_post, $post->ID );

        echo '<strong><a class="row-title" href="' . esc_url( $edit_link ) .'">' . $title.'</a>';

        _post_states( $post );

        echo '</strong>';

        if ( $post->post_parent > 0 ) {
          echo '&nbsp;&nbsp;&larr; <a href="'. get_edit_post_link( $post->post_parent ) .'">'. get_the_title( $post->post_parent ) .'</a>';
        }

        // Excerpt view
        if ( isset( $_GET['mode'] ) && 'excerpt' == $_GET['mode'] ) {
          echo $this->get_excerpt(); //apply_filters( 'the_excerpt', $post->post_excerpt );
        }

        // Get actions
        $actions = array();

        if ( $can_edit_post && 'trash' != $post->post_status ) {
          $actions['edit'] = '<a href="' . get_edit_post_link( $post->ID, true ) . '" title="' . esc_attr( __( 'Edit this item', 'mapti' ) ) . '">' . __( 'Edit', 'mapti' ) . '</a>';
        }
        if ( current_user_can( $post_type_object->cap->delete_post, $post->ID ) ) {
          if ( 'trash' == $post->post_status ) {
            $actions['untrash'] = '<a title="' . esc_attr( __( 'Restore this item from the Trash', 'mapti' ) ) . '" href="' . wp_nonce_url( admin_url( sprintf( $post_type_object->_edit_link . '&amp;action=untrash', $post->ID ) ), 'untrash-post_' . $post->ID ) . '">' . __( 'Restore', 'mapti' ) . '</a>';
          } elseif ( EMPTY_TRASH_DAYS ) {
            $actions['trash'] = '<a class="submitdelete" title="' . esc_attr( __( 'Move this item to the Trash', 'mapti' ) ) . '" href="' . get_delete_post_link( $post->ID ) . '">' . __( 'Trash', 'mapti' ) . '</a>';
          }

          if ( 'trash' == $post->post_status || ! EMPTY_TRASH_DAYS ) {
            $actions['delete'] = '<a class="submitdelete" title="' . esc_attr( __( 'Delete this item permanently', 'mapti' ) ) . '" href="' . get_delete_post_link( $post->ID, '', true ) . '">' . __( 'Delete Permanently', 'mapti' ) . '</a>';
          }
        }
        if ( $post_type_object->public ) {
          if ( in_array( $post->post_status, array( 'pending', 'draft', 'future' ) ) ) {
            if ( $can_edit_post )
              $actions['view'] = '<a href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) ) . '" title="' . esc_attr( sprintf( __( 'Preview &#8220;%s&#8221;', 'mapti' ), $title ) ) . '" rel="permalink">' . __( 'Preview', 'mapti' ) . '</a>';
          } elseif ( 'trash' != $post->post_status ) {
            $actions['view'] = '<a href="' . get_permalink( $post->ID ) . '" title="' . esc_attr( sprintf( __( 'View &#8220;%s&#8221;', 'mapti' ), $title ) ) . '" rel="permalink">' . __( 'View', 'mapti' ) . '</a>';
          }
        }

        $actions = apply_filters( 'post_row_actions', $actions, $post );

        echo '<div class="row-actions">';

        $i = 0;
        $action_count = sizeof($actions);

        foreach ( $actions as $action => $link ) {
          ++$i;
          ( $i == $action_count ) ? $sep = '' : $sep = ' | ';
          echo '<span class="' . $action . '">' . $link . $sep . '</span>';
        }
        echo '</div>';
      break;

      case 'game_cat' :
      case 'game_tag' :
        if ( ! $terms = get_the_terms( $post->ID, $column ) ) {
          echo '<span class="na">&ndash;</span>';
        } else {
          $termlist = array();

          foreach ( $terms as $term ) {
            $termlist[] = '<a href="' . admin_url( 'edit.php?' . $column . '=' . $term->slug . '&post_type=game' ) . ' ">' . $term->name . '</a>';
          }

          if ( ! empty( $termlist ) ) {
            echo implode( ', ', $termlist );
          }
        }
        break;

      default :
        break;
    }
  }

  private function get_thumbnail() {
    global $post;

    $thumbnail_id = get_post_thumbnail_id();
    $thumbnail = '';

    if ( ! empty( $thumbnail_id ) ) {
      $thumbnail_array = wp_get_attachment_image_src( $thumbnail_id );
      if ( ! empty( $thumbnail_array ) ) {
        $thumbnail = $thumbnail_array[0];
      }
    }

    if ( ! $thumbnail ) {
      $thumbnail = get_post_meta($post->ID, "mabp_thumbnail_url", true);
    }

    if ( preg_match('|^(http).*|i', $thumbnail) == 0 ) {
      // No Thumbail available.. get the default thumb
      $thumbnail = mapti()->plugin_url() .'/assets/images/noimage.png';
    }

    return $thumbnail;
  }

 private function get_excerpt() {
    global $post;

    // Get post excerpt
    $text = strip_shortcodes( $post->post_content );
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
    $text = wp_trim_words( $text, 100, '' );

    return "<p>" . $text . "</p>";
  }
}

endif;

new Mapti_Admin_Post_Types();