<?php
/**
 * Plugin Name: Kaleidoscope Digital Marketing Platform
 * Description: This plugin provides Kaleidoscope clients using a Wordpress website, to display images and videos from our comprehensive content library or from our client’s library.
 * Plugin URI:
 * Author: Kaleidoscope
 * Author URI: https://thekaleidoscope.com
 * Version: 1.2.4
 * Text Domain: Kaleidoscope Digital Marketing Platform
 * License: GPL v2 or later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.txt
 *
*/

require_once plugin_dir_path(__FILE__) . 'includes/kaleidoscope-functions.php';

// define the address of the kaleidoscope server endpoint for playlist data
define("KALEIDOSCOPE_END_POINT", "https://control.thekaleidoscope.com/api/public/playlists/");

// Register as a shortcode to be used on the site.
add_shortcode('kaleidoscope-playlist', 'kaleidoscope_slideshow_function');

// Hook the 'admin_menu' action hook, run the function named 'kaleidoscope_Add_Admin_Link()'
add_action( 'admin_menu', 'kaleidoscope_Add_Admin_Link' );

// Hook the 'wp_print_scripts & wp_print_styles' action hook, run the function named 'kaleidoscope_register_scripts & kaleidoscope_register_styles'
add_action('wp_print_scripts', 'kaleidoscope_register_scripts');
add_action('wp_print_styles', 'kaleidoscope_register_styles');

// Hook the 'wp_ajax_my_action' action hook, run the function named 'kaleidoscope_fetch_callback'
add_action('wp_ajax_my_action', 'kaleidoscope_fetch_callback');
add_action('wp_ajax_nopriv_my_action', 'kaleidoscope_fetch_callback');

// Hook the 'wp_ajax_ivs_action' action hook, run the function named 'kaleidoscope_ivs_fetch_callback'
add_action('wp_ajax_ivs_action', 'kaleidoscope_ivs_fetch_callback');
add_action('wp_ajax_nopriv_ivs_action', 'kaleidoscope_ivs_fetch_callback');
add_action('wp_ajax_ivs_action', 'kaleidoscope_ivs_fetch_callback');

// Hook the 'wp_ajax_kaleidoscope_cache_clear' action hook, run the function named 'kaleidoscope_cache_clear'
add_action('wp_ajax_kaleidoscope_cache_clear', 'kaleidoscope_cache_clear');
add_action('wp_ajax_nopriv_kaleidoscope_cache_clear', 'kaleidoscope_cache_clear');


add_action( 'rest_api_init', 'kaleidoscope_cache_clear_route' );

// plugin uninstallation data clear
register_uninstall_hook( __FILE__, 'kaleidoscope_fn_uninstall' );