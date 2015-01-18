<?php
/**
 * Plugin Name:  MyArcadePlugin - myCRED Bridge
 * Plugin URI:   http://myarcadeplugin.com
 * Description:  Integrates MyArcadePlugin with myCRED
 * Version:      1.1.0
 * Author:       Gabriel S Merovingi, Daniel Bakovic
 * Author URI:   http://mycred.me
 * Requires at least: 3.5
 * Tested up to: 4.0
 */

function myarcade_mycred_init() {
	require_once( 'class-myarcade-mycred.php' );
	// Register hook with myCRED
	add_filter( 'mycred_setup_hooks', 'register_myarcadeplugin_hook' );
}
add_action( 'mycred_pre_init', 'myarcade_mycred_init' );

function register_myarcadeplugin_hook( $installed ) {
  $installed['myarcade'] = array(
    'title'       => __( '%plural% for MyArcadePlugin', 'mycred' ),
    'description' => __( 'This hook award / deducts points from users playing in your arcade.', 'mycred' ),
    'callback'    => array( 'myCRED_Hook_MyArcadePlugin' )
  );
  return $installed;
}
?>