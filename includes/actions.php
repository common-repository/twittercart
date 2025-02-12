<?php
defined('ABSPATH') or die('Access denied!');
//Activation/Deactivation
register_activation_hook(TC_PLUGIN_PATH . 'twitter-cart.php', 'twitter_cart_activate');
register_uninstall_hook(TC_PLUGIN_PATH . 'twitter-cart.php', 'twitter_cart_uninstall');
//Plugin meta boxes
add_filter('plugin_row_meta', 'tc_plugin_row_meta', 10, 2 );
//Styles/Scripts
add_action('admin_enqueue_scripts', 'tc_admin_prepare_assets');
add_action('wp_enqueue_scripts', 'tc_user_prepare_assets');
//Admin pages
add_action('admin_menu', 'tc_admin_menu_group');
//Functions
add_action('init', 'tc_init_run');
//Binding twitter account to user
add_action('woocommerce_after_my_account', 'tc_user_settings');
//Check remove product
add_action('woocommerce_cart_updated', 'tc_check_twitter_product');
//Session destroy on logout
add_action('wp_logout', 'tc_session_destroy');
//After order completed remove all twitter orders 
add_action('woocommerce_thankyou', 'tc_set_all_orders_as_removed');
/*
 * AJAX functions
*/

add_action('wp_ajax_tc_link_oauth', 'tc_link_oauth');
add_action('wp_ajax_nopriv_tc_link_oauth', 'tc_link_oauth');

//Deactivate user twitter account
add_action('wp_ajax_tc_deactivate_account', 'tc_deactivate_account');
add_action('wp_ajax_nopriv_tc_deactivate_account', 'tc_deactivate_account');
//Deactivate user twitter account
add_action('wp_ajax_tc_post_product_account', 'tc_post_product_account');
add_action('wp_ajax_nopriv_tc_post_product_account', 'tc_post_product_account');
add_action( 'activated_plugin', 'tct_activation_redirect' );