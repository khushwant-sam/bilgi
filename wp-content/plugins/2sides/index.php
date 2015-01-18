<?php
/* 
Plugin Name: 2sides
Plugin URI: #
Description: Created By puko
Version: 1.0
Author: puko 
Author URI: ##
License: personal 
 
*/
// Activation of plugin starts here
function prefixActivation()
{
    global $wpdb;
   global $jal_db_version;

   $table_name2 = $wpdb->prefix . "2s_debate_topics";
   $table_name3 = $wpdb->prefix . "2s_contributions";
   $table_name4 = $wpdb->prefix . "2s_tags";
   $table_name5 = $wpdb->prefix . "2s_topic_tags";
   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  $sql = "";
  $sql = "CREATE TABLE IF NOT EXISTS `$table_name2` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text NOT NULL,
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `agree` int(11) NOT NULL,
  `disagree` int(11) NOT NULL,
  `agree_comments` int(11) NOT NULL,
  `disagree_comments` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";

 dbDelta( $sql );
$sql ="CREATE TABLE IF NOT EXISTS `$table_name3` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `contribution` longtext NOT NULL,
  `uid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `cstatus` int(11) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
 dbDelta( $sql );
$sql ="CREATE TABLE IF NOT EXISTS `$table_name4` (
  `tgid` int(11) NOT NULL AUTO_INCREMENT,
  `tgname` varchar(255) NOT NULL,
  `tpcount` int(11) NOT NULL,
  `tcreated_on` datetime NOT NULL,
  PRIMARY KEY (`tgid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
 dbDelta( $sql );
$sql ="CREATE TABLE IF NOT EXISTS `$table_name3` (
  `ttid` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `tgid` int(11) NOT NULL,
  PRIMARY KEY (`ttid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

 dbDelta( $sql );
   
  
 
}
register_activation_hook( __FILE__, 'prefixActivation' );

// Activation of plugin ends here

// Deactivation of plugin starts here
function prefixDeactivation()
{

}

register_deactivation_hook( __FILE__, 'prefixDeactivation' );
// Deactivation of plugin ends here

//include('twosidesHTML.php');
add_shortcode( 'getalltopics', 'getTopics' );


include("admin/getcontributions.php");

function getTopics(){
  ob_start();
  // adding call for contributions starts here
  wp_enqueue_script('mainJS', plugins_url('/2sides/js/custom.js'), array("jquery") );
  wp_localize_script( 'mainJS', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 , 'tid' => $_GET["ref"]) );
  // call for contributions ends here

  if(isset($_GET["ref"]))
    include("admin/topicview.php");
  else
    include("admin/getalltopics.php");
    
  return ob_get_clean();
}
add_action( 'admin_menu', 'Custom2sidesOptions' );
function twosides() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    //include("admin/managetwosides.php");
}

function addtopic() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }

    include("admin/addtopics.php");
}
function managetopics() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    include("admin/managetopics.php");
}
function managecontributions() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    //include("admin/twosidesContentPage.php");
}
function twosidessettings() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    //include("admin/twosidesContentPage.php");
}



function Custom2sidesOptions() {
  add_menu_page( '2sides', '2sides', 'manage_options', 'twosides', 'twosides', '', 1 );
  add_submenu_page( 'twosides', 'Manage Topics', 'All Topics', 'manage_options', 'managetopics', 'managetopics' );
  add_submenu_page( 'twosides', 'Add Topic Title', 'Add Topic', 'manage_options', 'addtopic', 'addtopic' );
  add_submenu_page( 'twosides', 'All Contributions', 'All Contributions', 'manage_options', 'managecontributions', 'managecontributions' );
  add_submenu_page( 'twosides', '2sides Settings', 'Settings', 'manage_options', 'twosidessettings', 'twosidessettings' );
}


// tinymce starts here
add_action( 'admin_head', 'custom_add_tinymce' );
function custom_add_tinymce() {
  global $typenow;
  if( ! in_array( $typenow, array( 'post', 'page' ) ) )
    return ;
  
  add_filter( 'mce_external_plugins', 'custom_add_tinymce_plugin' );
  add_filter( 'mce_buttons', 'custom_add_tinymce_button' );
  add_filter( 'mce_buttons_2', 'custom_add_tinymce_button_2' );
}

function custom_add_tinymce_plugin( $plugin_array ) {
  $plugin_array['cu_test'] = plugins_url( '/custom_btn.js', __FILE__ );
  return $plugin_array;
}

function custom_add_tinymce_button( $buttons ) {
  array_push( $buttons, 'custom_button_key' );
  return $buttons;
}

function custom_add_tinymce_button_2( $buttons ) {
  return $buttons;
}

// tiny mece ends here 
?>