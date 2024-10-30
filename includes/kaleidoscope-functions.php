<?php 

/**
 * Get response via REST API.
 */

// function to get json response from kaleidoscope server
function kaleidoscope_get_response_via_rest() {
    $key = get_option('kaleidoscope_api_key');
    $response = wp_remote_get(KALEIDOSCOPE_END_POINT.$key);

	// Exit if error.
	if ( is_wp_error( $response ) ) {
		return;
	}

	// Get the body.
    $data = json_decode( wp_remote_retrieve_body( $response ));

    return $data;
}

/*
 * Add my new menu to the Admin Control Panel
 */
 
// Add a new top level menu link to the ACP
function kaleidoscope_Add_Admin_Link()
{
    add_menu_page(
        'Kaleidoscope Admin page', // Title of the page
        'KL Playlist', // Text to show on the menu link
        'manage_options', // Capability requirement to see the link
        'kaleidoscope-playlist/includes/admin/kaleidoscope-admin-page.php', // The 'slug' - file to display when clicking the link
        '',
        'dashicons-format-image'
    );
    // Hook the 'admin_init' action hook, run the function named 'update_kaleidoscope_playlist_settings'
    add_action( 'admin_init', 'update_kaleidoscope_playlist_settings' );
}

/*
 * Registering the Playlist settings set in the admin page to Database
 */

// Register the playlist settings in the database
function update_kaleidoscope_playlist_settings() {
    register_setting( 'kaleidoscope-playlist-settings', 'kaleidoscope_api_key');
    register_setting( 'kaleidoscope-playlist-settings', 'kaleidoscope_playlist_width' );
    register_setting( 'kaleidoscope-playlist-settings', 'kaleidoscope_playlist_height');
    register_setting( 'kaleidoscope-playlist-settings', 'kaleidoscope_playlist_background_color');
    register_setting( 'kaleidoscope-playlist-settings', 'kaleidoscope_playlist_background_transparency');
    register_setting( 'kaleidoscope-playlist-settings', 'kaleidoscope_playlist_border');
    register_setting( 'kaleidoscope-playlist-settings', 'kaleidoscope_playlist_border_color');
    register_setting( 'kaleidoscope-playlist-settings', 'kaleidoscope_playlist_animation');
    register_setting( 'kaleidoscope-playlist-settings', 'kaleidoscope_playlist_autoplay');
    register_setting( 'kaleidoscope-playlist-settings', 'kaleidoscope_playlist_interval');
    register_setting( 'kaleidoscope-playlist-settings', 'kaleidoscope_playlist_caption');
    register_setting( 'kaleidoscope-playlist-settings', 'kaleidoscope_playlist_image_fit');
    register_setting( 'kaleidoscope-playlist-settings', 'kaleidoscope_playlist_navigation');
}

/*
 * Registering and Including Scripts and Styles
 */

// Includes and register the required scripts  
function kaleidoscope_register_scripts() {
    $kl_js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'js/kaleidoscope-ivs-script.js' ));

    if (!is_admin()) {
        // register
        wp_register_script('kaleidocope_ivs_script', plugins_url('js/kaleidoscope-ivs-script.js', __FILE__), array( 'jquery' ),$kl_js_ver);
        // wp_register_script('kaleidoscope_script', plugins_url('js/kaleidoscope-script.js', __FILE__));
        // wp_register_script('kaleidoscope_clear_cache', plugins_url('js/kaleidoscope-clear-cache.js', __FILE__));

 
        // enqueue
        wp_enqueue_script('kaleidocope_ivs_script');
        // wp_enqueue_script('kaleidoscope_script');
        // wp_enqueue_script('kaleidoscope-clear-cahe');

        // localize 
        wp_localize_script( 'kaleidocope_ivs_script', 'kaleidoscope_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        // wp_localize_script( 'kaleidoscope_script', 'kaleidoscope_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        // wp_localize_script( 'kaleidoscope_clear_cache', 'kaleidoscope_cache_clear', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }
}
// Includes & registers the required styles 
function kaleidoscope_register_styles() {
    $kl_css_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'css/kaleidoscope-ivs-style.css' ));
    // register
    wp_register_style('kaleidocope_ivs_styles', plugins_url('css/kaleidoscope-ivs-style.css', __FILE__), false, $kl_css_ver);
 
    // enqueue
    wp_enqueue_style('kaleidocope_ivs_styles');
    
}

/*
 * Clear the data in database after plugin uninstall
*/

// Database clear
function kaleidoscope_fn_uninstall() {
    delete_option( 'kaleidoscope_api_key');
    delete_option( 'kaleidoscope_playlist_width');
    delete_option( 'kaleidoscope_playlist_height');
    delete_option( 'kaleidoscope_playlist_background_color');
    delete_option( 'kaleidoscope_playlist_background_transparency');
    delete_option( 'kaleidoscope_playlist_border');
    delete_option( 'kaleidoscope_playlist_border_color');
    delete_option( 'kaleidoscope_playlist_animation');
    delete_option( 'kaleidoscope_playlist_autoplay');
    delete_option( 'kaleidoscope_playlist_interval');
    delete_option( 'kaleidoscope_playlist_caption');
    delete_option( 'kaleidoscope_playlist_image_fit');
    delete_option( 'kaleidoscope_playlist_navigation');
}

/*
 * Configure the Kaleidoscope playlist Slideshow
 */

// configure the slideshow 
function kaleidoscope_slideshow_function() {
    // calling the function 'get_response_via_rest' to get json response from kaleidoscope server
    $objects = kaleidoscope_get_response_via_rest();

    // if error return early
    if($objects->error || !$objects) {
        return;
    } else {

        $result = '<ul class="kaleidoscope-slider">';

        // loop the response 
        foreach($objects as $obj) {
            $result.="<li data-type=\"".$obj->content_type."\" data-url=\"".$obj->preview."\" data-url-small=\"".$obj->image."\" data-url-large=\"".$obj->large."\" data-link=\"".$obj->webLink."\" data-caption=\"".$obj->caption."\"></li>";
        
        };

        $result.=  '</ul>';

        return $result;
    }
    
}

/*
 * Ajax Function callback
 */

 // Callback function for ajax request
function kaleidoscope_fetch_callback() {
    $autoplay = '';

    if(isset($_POST['getData'])) {

        if(get_option('kaleidoscope_playlist_autoplay')== 'true') {
            $autoplay = true;
        } elseif (get_option('kaleidoscope_playlist_autoplay')=='false') {
            $autoplay = false;
        }

        // Requesting data from database
        $data = [
            'animation' => get_option('kaleidoscope_playlist_animation'),
            'autoplay' => $autoplay,
            'interval' => get_option('kaleidoscope_playlist_interval') * 1000,
            'bg_color' => get_option('kaleidoscope_playlist_background_color'),
            'bg_transparent' => get_option('kaleidoscope_playlist_background_transparency'),
            'border' => get_option('kaleidoscope_playlist_border'),
            'border_color' => get_option('kaleidoscope_playlist_border_color'),
            'image_fit' => get_option('kaleidoscope_playlist_image_fit'),
        ];

        echo json_encode($data);
    }
    wp_die();
}

// callback function for ajax request
function kaleidoscope_ivs_fetch_callback() {

    if(isset($_POST['getData'])) {

        // Requesting data from database
        $ivs_data = [
            'height' => get_option('kaleidoscope_playlist_height'),
            'width' => get_option('kaleidoscope_playlist_width'),
            'caption' =>get_option('kaleidoscope_playlist_caption'),
            'navigation' =>get_option('kaleidoscope_playlist_navigation')
        ];

        echo json_encode($ivs_data);
    }
    wp_die();
}

// defining endpoint for cache clear
function kaleidoscope_cache_clear_route() {
    register_rest_route( 'kaleidoscope', 'cache-clear', array(
        'methods' => 'GET',
        'callback' => 'kaleidoscope_cache_clear',
    )
);
}

// cache clear 
function kaleidoscope_cache_clear() {
    // Defining Response Header
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header('Content-Type: application/json');
    header('Cache-Control: No-Store');
    // header('User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.3');

    
    // API KEY
    if(get_option('kaleidoscope_api_key')){
        $token_key = get_option('kaleidoscope_api_key');
    } else {
        $token_key = '';
    }

    // Checking for Key
    if(isset($_GET['api-key'])) {
        $api_key = $_GET['api-key'];
    } 
    
    // Checking for Authentication
    if($api_key) {
        if($api_key == $token_key) {

            $data="No Supported Caching Plugin Found on your Website";

            // Clear cache for wp-fastest-cache.
            if ( function_exists( 'wpfc_clear_all_cache' ) ) {
                wpfc_clear_all_cache();

                $data = "Cache cleared for WP Fastest cache";
            }

            // Clear cache for wp-rocket
            if ( function_exists( 'rocket_clean_domain' ) ) {
                rocket_clean_domain();

                $data = "Cache cleared for WP Rocket";
            }

            // Clear cache for wp-optimize.
            if ( function_exists('WP_Optimize') ) {
                WP_Optimize()->get_page_cache()->purge();

                $data = "Cache cleared for WP Optimize";
            }

            // Clear cache for w3-total-cache
            if ( function_exists('w3tc_flush_all') ){
                w3tc_flush_all();

                $data = "Cache cleared for W3 Total Cache";
            }

            // Clear cache for wp-super-cache
            if ( function_exists( 'wp_cache_clean_cache' ) ) {
                wp_cache_clean_cache(true);

                $data = "Cache cleared for WP Super Cache";
            }

            // Sending Response
            echo json_encode( $data );
            die();

        } else {
            // Sending Response
            $data = "Authentication Failed";
            echo json_encode( $data );
            die();
        }
    } else {
        // Sending Response
        $data = "Access Denied";
        echo json_encode( $data );
        die();
    }
}