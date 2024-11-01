<?php
defined('ABSPATH') or die('Access denied');
function generate_twitter_timeline(){
	require_once TC_PLUGIN_PATH . 'includes/twitter.php';
	require_once TC_PLUGIN_PATH . 'includes/products.php';
	
	$user_data = get_user_data_twitter();
    $pfp = FALSE;
    if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
		
        $pfp = get_pfp($_REQUEST['id']);
		
		
    }
    echo require_once TC_TEMPLATES_PATH . 'ajax/timeline_result.php';
}
function generate_tc_account_page(){
	//Get AJAX URL
	
    $site_dir = get_option('tc_site_dir');
    if (empty($site_dir)) {
        $site_url = BASE_SITE_URL;
    } else {
        $site_url = BASE_SITE_URL . "/" . $site_dir;
    }
    require_once TC_PLUGIN_PATH . 'includes/twitter.php';
    $hashtag = get_option('tc_twitter_hashtag');
    $user_data = get_user_data_twitter();
    $products_url = get_admin_url() . 'admin.php?page=tc_products';
    echo require_once TC_TEMPLATES_PATH . 'account_page.php';
	generate_twitter_timeline();
}