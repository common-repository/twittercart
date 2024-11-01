<?php
/**
 * Plugin Name: TwitterCart
 * Plugin URI: https://twittercart.com
 * Description: Promote and sell your Woocommerce Products on Twitter using TwitterCart. #Hashtag add-to-cart Wordpress Plugin. Free version
 * Version: 2.2
 * Author: Browserweb Inc.
 * Author URI: https://twittercart.com
 * Requires at least: 3.0.1
 * Tested up to: 4.9.5
 * Text Domain: twittercart
 * Domain Path: /languages
 */

defined('ABSPATH') or die('Access denied!');
define('TC_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('TC_TEMPLATES_PATH', TC_PLUGIN_PATH . 'includes/templates/');
define('TC_PLUGIN_URL', plugin_dir_url(__FILE__)); 
define('TC_LIBS_PATH', TC_PLUGIN_PATH . 'libs/');
define('TC_IMG_URL', TC_PLUGIN_URL . 'assets/images/');
define('BASE_SITE_URL', get_site_url());
define('TC_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define('TC_MULTIVENDOR', TRUE);
$upload = wp_upload_dir();
define('BASE_UPLOAD_URL', $upload['baseurl']);

/* Internationalization start */
add_action('plugins_loaded', 'twittercart_load_language_translation_func');
function twittercart_load_language_translation_func() 
{
	$plugin_rel_path = dirname( plugin_basename( __FILE__ ) ) .'/languages';
	load_plugin_textdomain('twittercart', false, $plugin_rel_path );	
}
/* Internationalization end */

require_once TC_PLUGIN_PATH . 'includes/functions.php';
require_once TC_PLUGIN_PATH . 'includes/actions.php';