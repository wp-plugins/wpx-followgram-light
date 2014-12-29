<?php
/// @cond private
/**
 * Plugin Name:     WPX Followgram Light
 * Plugin URI:      https://wpxtre.me
 * Description:     Simple sidebar widget that shows Your Instagram profile with 8 instagr.am pictures, follower, following and photos.
 * Version:         1.1.13
 * Author:          wpXtreme, Inc.
 * Author URI:      https://wpxtre.me
 * Text Domain:     wpx-followgram
 * Domain Path:     localization
 *
 * WPX PHP Min: 5.2.4
 * WPX WP Min: 3.8
 * WPX MySQL Min: 5.0
 * WPX wpXtreme Min: 1.4.8
 *
 */
/// @endcond

// Avoid directly access
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

// wpXtreme kickstart logic
require_once( trailingslashit( dirname( __FILE__ ) ) . 'wp_kickstart.php' );

wpxtreme_wp_kickstart( __FILE__, 'wpx-followgram_000031', 'WPXFollowgram', 'wpx-followgram.php' );