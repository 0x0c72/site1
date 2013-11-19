<?php
/**
 * Loads the WordPress environment and template.
 *
 * @package WordPress
 */

if ( !isset($wp_did_header) ) {

	$wp_did_header = true;

	require_once( dirname(__FILE__) . '/wp-load.php' );

	if ( false == @file_exists('/var/services/web/wordpress/enabled')) {
		$response = file_get_contents('/var/services/web/wordpress/disabled.html');
		echo preg_replace('/The service is disabled now\./', __('The service is disabled now.'), $response);
		exit;                              
	}    

	wp();

	require_once( ABSPATH . WPINC . '/template-loader.php' );

}
