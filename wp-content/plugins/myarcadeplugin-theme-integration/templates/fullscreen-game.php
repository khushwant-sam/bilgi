<?php
/**
 * Fullscreen game play page
  */
?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<title><?php bloginfo('name'); ?> - <?php single_post_title(); ?></title>

<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="all" />

<?php wp_head(); ?>

<style type="text/css">
#fullgame {
  width:95%;
  margin:5px auto 0 auto;
  display:block;
  position: relative;
}

#fullgame h2 {
  background:#C9CCD3;
  line-height:40px;
  margin-bottom: 5px;
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  border-radius:4px;
}
</style>
</head>

<body>
  <center>
    <div id="fullgame">
      <h2><a href="javascript:history.go(-1)">&laquo; <?php _e('Go Back To', 'mapti'); ?>: <?php bloginfo('name'); ?> </a></h2>
    </div>
    <?php
    global $mypostid, $post;
    $mypostid = $post->ID;
    // overwrite the post id
    $post->ID = $mypostid;
    if ( function_exists('get_game') ) {
      echo get_game($mypostid, $fullsize = false, $preview = false, $fullscreen = true);
    }
    if ( function_exists( 'myarcade_get_leaderboard_code') ) {
      myarcade_get_leaderboard_code();
    }
    ?>
  </center>
<?php
wp_footer();
?>
</body>
</html>