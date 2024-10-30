<?php

    // Defining Response Header
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header('Content-Type: application/json');
    header('Cache-Control: No-Store');
    header('User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.3');

    // Load Wordpress
    // require( '../../../wp-load.php' );

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

        } else {
            // Sending Response
            $data = "Authentication Failed";
            echo json_encode( $data );
        }
    } else {
        // Sending Response
        $data = "Access Denied";
        echo json_encode( $data );
    }

?>