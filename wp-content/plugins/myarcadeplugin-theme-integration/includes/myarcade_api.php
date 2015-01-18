<?php
/**
 * MyArcadePlugin Theme API helps theme developers to create MyArcadePlugin Pro compatible themes.
 *
 * Use this function only within the loop.
 *
 * @package MyArcadePlugin Pro Theme API
 * @author Daniel Bakovic - http://myarcadeplugin.com
 * @version 2.00
 */

if ( !function_exists('myarcade_get_title') ) {
/**
 * Display or retrieve the title of the current post/game. The title can be cutted after $chars.
 * Words will not be cutted off (wordwrap).
 * @since 1.0
 * @param int $chars Optional. Max. length of the title
 * @param bool $echo Optional. default to true. Whether to display or return.
 * @return null|string Null on no title. String if $echo parameter is false.
 */
function myarcade_get_title ($chars = 0, $echo = true) {
    global $post;

    $chars = intval($chars);
    $title = strip_tags( the_title('', '', FALSE) ); // before, after, echo

    if ( $chars > 0 ) {
      if ( (strlen($title) > $chars) ) {
        $title = mb_substr($title, 0, $chars);
        $title = mb_substr($title, 0, -strlen(strrchr($title, ' ')));  // Wordwrap

        if ( strlen($title) < 4 ) {
          $title = mb_substr( the_title('', '',FALSE), 0, $chars );
        }

        $title .= ' ..';
      }
    }

    if ($echo == true) { echo $title; } else { return $title; }
  }
}


if ( !function_exists('myarcade_get_description') ) {
/**
 * Display or retrieve the description of the current game. The description can be cutted after $chars.
 * Words will not be cutted off (wordwrap).
 * @since 1.0
 * @param int $chars Optional. Max. length of the description
 * @param bool $echo Optional. default to true. Whether to display or return.
 * @return null|string Null on no description. String if $echo parameter is false.
 */
  function myarcade_get_description ($chars = 0, $echo = true) {
    global $post;

    $chars = intval($chars);
    $description = get_post_meta($post->ID, 'mabp_description', true);

    if ( $chars > 0 ) {
      if ( (strlen($description) > $chars) ) {
        $description = mb_substr($description, 0, $chars);
        $description = mb_substr($description, 0, -strlen(strrchr($description, ' ')));  // Wordwrap

        if ( strlen($description) < 4 ) {
          $description = mb_substr( get_post_meta($post->ID, 'mabp_description', true), 0, $chars );
        }

        $description .= ' ..';
      }
    }

    if ($echo == true) { echo $description; } else { return $description; }
  }
}

if ( !function_exists('myarcade_excerpt')) {
  /**
  * Display or retrieve the excerpt of a game post. All tags will be removed.
  *
  * @usage Use this function only in the WordPress post loop
  *
  * @since 1.0
  *
  * @param int $length Character length of the excerpt
  * @param bool $echo Optional. Return or echo the result
  */
  function myarcade_excerpt($length = false, $echo = true) {
    global $post;

    // Get post excerpt
    $text = strip_shortcodes( $post->post_content );
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
    $text = wp_trim_words( $text, 100, '' );

    if ( $length ) {
      if ( strlen($text) > $length ) {
        $text = mb_substr($text, 0, $length).' [...]';
      }
    }

    if ($echo) { echo $text; } else { return $text; }
  }
}



if ( !function_exists('myarcade_thumbnail') ) {
/**
 * Display the game thumbnail of the current game.
 * If no thumbnail is available the function will display a default thumbnail located in the template directory.
 * default thumb: /template_directory/images/def_thumb.png
 * @since 1.0
 * @param int $width Optional. Width of the thumbnail in px. Default: 100
 * @param int $height Optional. Height of the thumbnail in px. Default: 100
 * @param string $class Optional. CSS class fot the image tag
 */
  function myarcade_thumbnail ($width = 100, $height = 100, $class = '') {
    global $post;

    if ( !empty($class) ) { $class = 'class="'.$class.'"'; }

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
      $thumbnail = get_template_directory_uri().'/images/def_thumb.png';
    }

    echo '<img src="'.$thumbnail.'" width="'.$width.'" height="'.$height.'" '.$class.' alt="'.the_title('', '', FALSE).'" />';
  }
}


if ( !function_exists('myarcade_get_thumbnail_url') ) {
  /**
  * Get url of current game thumbnail
  *
  * @usage Use this function only in the WordPress post loop
  *
  * @since 1.0
  */
  function myarcade_get_thumbnail_url() {
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
      $thumbnail = get_template_directory_uri().'/images/def_thumb.png';
    }

    return $thumbnail;
  }
}


if ( !function_exists('myarcade_get_instructions') ) {
/**
 * Display or retrieve the game instructions
 * @since 1.0
 * @param bool echo true (default) | false to return
 */
  function myarcade_get_instructions($echo = true) {
    global $post;
    $instructions = get_post_meta($post->ID, "mabp_instructions", true);
    if ($echo == true) { echo $instructions; } else { return $instructions; }
  }
}


if ( !function_exists('myarcade_count_screenshots') ) {
/**
 * Retrieve the number of available screenshots for the current game.
 * @since 1.0
 * @return int
 */
  function myarcade_count_screenshots () {
    global $post;

    $screen_count = 0;

    for ($screen_nr = 1; $screen_nr <= 4; $screen_nr++) {
      if ( preg_match('|^(http).*|i', get_post_meta($post->ID, "mabp_screen".$screen_nr."_url", true)) ) {
        $screen_count++;
      }
    }

    return intval($screen_count);
  }
}


if ( !function_exists('myarcade_screenshot') ) {
/**
 * Display the given screen shot of the current game.
 * @since 1.0
 * @param int $width Optional. Width of the screen shot in px. Default: 450
 * @param int $height Optional. Height of the screen shot in px. Default: 350
 * @param int $screen_nr Optional. The number of the screen (1..4). Default 1
 * @param string $class Optional. CSS class fot the image tag
 * @param bool $echo Optional. Return or echo the result
 */
  function myarcade_screenshot ($width = 450, $height = 300, $screen_nr = 1, $class = '', $echo = true) {
    global $post;

    $output = '';

    if ( !empty($class) ) { $class = 'class="'.$class.'"'; }

    $screenshot = get_post_meta($post->ID, "mabp_screen".$screen_nr."_url", true);

    if ( preg_match('|^(http).*|i', $screenshot) ) {
      $output = '<img src="'.$screenshot.'"  width="'.$width.'" height="'.$height.'" '.$class.' alt="" />';
    }

    if ( $echo == true ) {
      echo $output;
    }
    else {
      return $output;
    }
  }
}

if ( !function_exists('myarcade_get_screenshot_url') ) {
/**
 * Retrieves the url of a screenshot
 * @since 1.0
 * @param int $screen_nr Optional. The number of the screen (1..4). Default 1
 * @param bool $echo Optional. Return or echo the result
 */
  function myarcade_get_screenshot_url ($screen_nr = 1, $echo = true) {
    global $post;

    $screenshot = get_post_meta($post->ID, "mabp_screen".$screen_nr."_url", true);

    if ( $echo == true ) {
      echo $screenshot;
    }
    else {
      return $screenshot;
    }
  }
}


if ( !function_exists('myarcade_all_screenshots') ) {
/**
 * Display all available screen shot of the current game.
 * @since 1.0
 * @param int $width Optional. Width of the screen shot in px. Default: 450
 * @param int $height Optional. Height of the screen shot in px. Default: 350
 * @param int $screen_nr Optional. The number of the screen (1..4). Default 1
 * @param string $class Optional. CSS class fot the image tag
 */
  function myarcade_all_screenshots ($width = 450, $height = 300, $class = '') {
    global $post;

    if ( !empty($class) ) { $class = 'class="'.$class.'"'; }

    for ($screen_nr = 1; $screen_nr <= 4; $screen_nr++) {
      $screenshot = get_post_meta($post->ID, "mabp_screen".$screen_nr."_url", true);

      if ( preg_match('|^(http).*|i', $screenshot) ) {
        echo '<a href="'.$screenshot.'" title="" rel="lightbox"><img src="'.$screenshot.'"  width="'.$width.'" height="'.$height.'" '.$class.' alt="" /></a>';
      }
    }
  }
}


if ( !function_exists('myarcade_get_video') ) {
/**
 * Display (Embed) the gameplay video of the current game.
 * @since 1.0
 * @param int $width Optional. Width of the video in px. Default: 450
 * @param int $height Optional. Height of the video in px. Default: 350
 */
  function myarcade_get_video($width = 400, $height = 336) {
    global $post;

    $video_url = get_post_meta($post->ID, "mabp_video_url", true);

    if ( $video_url ) {
      // Get the embed code
      return wp_oembed_get( $video_url, array( 'width' => $width, 'height' => $height ) );
    }

    return false;
  }
}