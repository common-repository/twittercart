<?php
defined('ABSPATH') or die('Access denied!');
/*
 * File with main plugin functions
 */
//Activate plugin
function twitter_cart_activate()
{
	/*require_once TC_PLUGIN_PATH . 'includes/setup.php';
    set_plugin_options();
    set_plugin_tables();
    set_plugin_cron();
    //set_plugin_capabilities();*/	
	/* changed on 20-Oct-2015 DV*/
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
	{
    	require_once TC_PLUGIN_PATH . 'includes/setup.php';
		set_plugin_options();
		set_plugin_tables();
		//set_plugin_cron();
	}
	else
	{
		deactivate_plugins( plugin_basename( TC_PLUGIN_BASENAME ) );
		wp_die( "Please install/activate woocommerce plugin first.<a href='".admin_url()."plugins.php'>".__('Go to plugins', 'twittercart')."</a>" );
	}
}

//Uninstall plugin
function twitter_cart_uninstall()
{
    require_once TC_PLUGIN_PATH . 'includes/setup.php';
    unset_plugin_options();
    unset_plugin_tables();
    //unset_plugin_cron();
}
function tc_init_run()
{
    //Disable default time limit
    set_time_limit(100000);
    //Enable session
    if (!session_id()) {
        session_start();
    }
    //Fix headers conflict (bufferization)
    ob_start();
    //Update TwitterCart & Wishlist
    if (is_user_logged_in()) {
        tc_get_added_products();
        tc_get_wishlist_products();
    }
    //
    if (isset($_GET['fromfrontend'])) {
        require_once TC_PLUGIN_PATH . 'includes/twitter.php';
        $_SESSION['tc_binded'] = TRUE;
        //tc_get_access_token_front();
    }
    //Get access tokens on redirect
    if (isset($_GET['oauth_verifier'])) {
        require_once TC_PLUGIN_PATH . 'includes/twitter.php';
        $_SESSION['tc_binded'] = TRUE;
        tc_get_access_token();
    }
	if ( tc_not_setup() ) {
        add_action( 'admin_notices', 'tc_options_notice' );
    }
	if ( tc_prduct_not_setup() ) {
        add_action( 'admin_notices', 'tc_product_setup_notice' );
    }
}
function tc_plugin_row_meta($links, $file)
{
    if ($file == TC_PLUGIN_BASENAME) {
		$settings_url = admin_url('admin.php?page=tct_settings');
		$pro_version_url = 'https://twittercart.com';
		$vendor_version_url = 'https://twittercart.com/twittercart-vendors/';
		$row_meta = array(
            'pro_version' => '<a href="'.$pro_version_url.'" target="_blank" title="Pro version">'.__('Upgrade to Pro', 'twittercart').'</a>',
            'vendor_version' => '<a href="'.$vendor_version_url.'" target="_blank" title="Vendor version">'.__('Upgrade to Vendor', 'twittercart').'</a>',
        );
        return array_merge($links, $row_meta);
    }
    return (array) $links;
}
function tc_options_notice()
{
	$flag = false;
	if( isset($_REQUEST['page']) ){
		$req_page = trim($_REQUEST['page']);
		$req_page = strtolower($req_page);
		if( 'tct_settings' == $req_page ){
			$flag = true;
		}
	}
	if(!$flag){
		my_message_styled(__("Fantastic!  You've successfully installed #TwitterCart and all you need to do now is go to ", 'twittercart') .' '. get_options_url(__('Settings', 'twittercart')) .' '. __(" and setup your Twitter Account to work with #TwitterCart.", 'twittercart'));
	}
}
function tc_product_setup_notice()
{
    my_message_styled( __("Fantastic!  You've successfully installed #TwitterCart and all you need to do  setup your Products.",'twiitercart') );
}
function tc_not_setup()
{
    $api = get_option('tc_twitter_api_key');
    $asecret = get_option('tc_twitter_api_secret');
    $token = get_option('tc_twitter_access_token');
    $tsecret = get_option('tc_twitter_access_token_secret');
    if (tc_is_admin()) {
        if (empty($api) || empty($asecret) || empty($token) || empty($tsecret)) {
            return TRUE;
        }
        return FALSE;
    }
	else
	{
        require_once TC_PLUGIN_PATH . 'includes/user.php';
        $acc = tc_get_user_twitter_account(get_current_user_id());
        if (empty($acc))
		{
            return TRUE;
        }
        return FALSE;
    }
}
function tc_prduct_not_setup()
{
    if (!class_exists('WC_Product'))
	{
		return TRUE;
	}
}
function tc_is_admin()
{
    $userNow = get_user_by('id', get_current_user_id());
    if (!empty($userNow) && $userNow->caps['administrator'])
	{
        return TRUE;
    }
	else
	{
        return FALSE;
    }
}
//Inluding custom plugin styles and scripts for admin panel
function tc_admin_prepare_assets($hook)
{
    //wp_enqueue_script('tc_jquery', TC_PLUGIN_URL . 'assets/js/jquery.js');
    //wp_enqueue_script('tc_admin', TC_PLUGIN_URL . 'assets/js/admin.js');
	wp_register_script( 'tc_admin', TC_PLUGIN_URL.'assets/js/admin.js', array('jquery','jquery-ui-core', 'jquery-ui-accordion') , false, true );
	$hashtag = get_option( 'tc_twitter_hashtag' );
    $wishlist_hashtag = get_option( 'tc_wishlist_hashtag' );
	$tct_plugin_url = TC_PLUGIN_URL;
	$tct_site_url = BASE_SITE_URL;
	$main_js_obj_props = array(
							'admin_ajax_url' => admin_url('admin-ajax.php'),
							'tccarthashtag'		=>	$hashtag,
							'tcwlhashtag'		=>	$wishlist_hashtag,
							'tct_pluginurl'		=>	$tct_plugin_url,
							'tct_siteurl'		=>	$tct_site_url,
						);
	wp_localize_script( 'tc_admin', 'main_js_obj', $main_js_obj_props);
    wp_enqueue_script( 'tc_admin');
    wp_register_style('tc_admin_style', TC_PLUGIN_URL . 'assets/css/admin.css', array(), '20120208', 'all');
    wp_enqueue_style('tc_admin_style');
    //morris plugin
    wp_register_style('tc_morris_style', TC_PLUGIN_URL . 'assets/css/moriss.css', array(), '20120208', 'all');
    wp_enqueue_style('tc_morris_style');
    wp_enqueue_script( 'tc_raphael', TC_PLUGIN_URL . 'assets/js/raph-min.js' );
    wp_enqueue_script( 'tc_morris', TC_PLUGIN_URL . 'assets/js/mor-min.js' );
    //wp_register_style('tc_admin_ui_style', TC_PLUGIN_URL . 'assets/css/ui.css', array(), '20120208', 'all');
    //wp_enqueue_style('tc_admin_ui_style');
    wp_register_style('tc_account_style', TC_PLUGIN_URL . 'assets/css/tc_account_style.css', array(), '20120208', 'all');
    wp_enqueue_style('tc_account_style');
    wp_enqueue_script('tc_admin_tbs', TC_PLUGIN_URL . 'assets/js/jquery.idTabs.min.js');
    wp_register_style('tc_admin_modal', TC_PLUGIN_URL . 'assets/css/colorbox.css', array(), '20120208', 'all');
    wp_enqueue_style('tc_admin_modal');
    wp_enqueue_script('tc_admin_modal_js', TC_PLUGIN_URL . 'assets/js/jquery.colorbox-min.js');
    wp_enqueue_script('tc_admin_scrl', TC_PLUGIN_URL . 'assets/js/jquery.mCustomScrollbar.concat.min.js');
    wp_register_style('tc_admin_scrl_st', TC_PLUGIN_URL . 'assets/css/jquery.mCustomScrollbar.css', array(), '20120208', 'all');
    wp_enqueue_style('tc_admin_scrl_st');
    if (need_datatables()) {
        wp_register_style('tc_dt_style', TC_PLUGIN_URL . 'assets/css/jquery.dataTables.min.css', array(), '20120208', 'all');
        wp_enqueue_style('tc_dt_style');
        wp_enqueue_script('tc_dt_js', TC_PLUGIN_URL . 'assets/js/jquery.dataTables.min.js');
    }
    wp_register_style('tc_user_alert_base', TC_PLUGIN_URL . 'assets/css/alertify.css', array(), '20120208', 'all');
    wp_enqueue_style('tc_user_alert_base');
    wp_register_style('tc_user_alert', TC_PLUGIN_URL . 'assets/css/alertify.default.css', array(), '20120208', 'all');
    wp_enqueue_style('tc_user_alert');
    wp_register_style('tc_media', TC_PLUGIN_URL . 'assets/css/alertify.default.css', array(), '20120208', 'all');
    wp_enqueue_style('tc_media');
    wp_enqueue_script('tc_user_alert_js', TC_PLUGIN_URL . 'assets/js/alertify.js');
    //tc_admin_menu_group();
	wp_register_script( 'tc_vendor', TC_PLUGIN_URL.'assets/js/vendor.js', array('jquery') , false, false );
	wp_enqueue_script( 'tc_vendor'); 
}
//Inluding custom plugin styles and scripts
function tc_user_prepare_assets($hook)
{
    wp_register_style('tc_user_style', TC_PLUGIN_URL . 'assets/css/user.css', array(), '20120208', 'all');
    wp_enqueue_style('tc_user_style');
    wp_enqueue_script('tc_user_js', TC_PLUGIN_URL . 'assets/js/user.js');
    wp_register_style('tc_user_alert_base', TC_PLUGIN_URL . 'assets/css/alertify.css', array(), '20120208', 'all');
    wp_enqueue_style('tc_user_alert_base');
    wp_register_style('tc_user_alert', TC_PLUGIN_URL . 'assets/css/alertify.default.css', array(), '20120208', 'all');
    wp_enqueue_style('tc_user_alert');
    wp_enqueue_script('tc_user_alert_js', TC_PLUGIN_URL . 'assets/js/alertify.js');
}
function tc_my_account_assets()
{
    wp_enqueue_script('tc_user_tabs_js', TC_PLUGIN_URL . 'assets/js/ui-tabs.js');
    
    wp_register_style('tc_user_modal', TC_PLUGIN_URL . 'assets/css/colorbox.css', array(), '20120208', 'all');
    wp_enqueue_style('tc_user_modal');
    wp_enqueue_script('tc_user_modal_js', TC_PLUGIN_URL . 'assets/js/jquery.colorbox-min.js');
}
//Add admin menu group
function tc_admin_menu_group()
{
	add_menu_page(__('#TwitterCart' ,'twittercart'), __('#TwitterCart' ,'twittercart'), 'edit_products', 'tct_settings', 'tct_settings_page', 'dashicons-twitter', 55.4);
	add_submenu_page('tct_settings', __('TwitterCart | Settings', 'twittercart'), __('Settings', 'twittercart'), 'edit_products', 'tct_settings', 'tct_settings_page', 'dashicons-twitter', 55.4);
	add_submenu_page('tct_settings', __('TwitterCart | Products', 'twittercart'), __('Products', 'twittercart'), 'edit_products', 'tc_products', 'get_products_page');
	add_submenu_page(NULL, __('TwitterCart | Twitter Account', 'twittercart'), NULL, 'edit_products', 'tc_account_page', 'get_tc_account_page');
	add_submenu_page('tct_settings', __('TwitterCart | Support', 'twittercart'), __('Support', 'twittercart'), 'edit_products', 'tct_support', 'tct_support_page');
}

function tct_settings_page()
{
	echo require_once TC_TEMPLATES_PATH . 'settings_page.php';
}
function tct_support_page()
{
	echo require_once TC_TEMPLATES_PATH . 'support-page.php';
}
function get_tc_account_page()
{
	require_once TC_PLUGIN_PATH . 'includes/stats.php';
    generate_tc_account_page();
}

//OAuth sign in
function tc_link_oauth()
{
	if( wp_verify_nonce( $_POST['tc_secure_field'], 'nonce_tc_link_auth_nonce_field' ) )
	{
		require_once TC_PLUGIN_PATH . 'includes/twitter.php';
    	tc_get_tokens();
	}
}

//Woocommerce products page
function get_products_page()
{
    require_once TC_PLUGIN_PATH . 'includes/products.php';
    generate_products_page();
}
//Post product from account
function tc_post_product_account()
{
	if( wp_verify_nonce( $_POST['tc_secure_field'], 'nonce_tc_product_post_nonce_field' ) )
	{
    	require_once TC_PLUGIN_PATH . 'includes/products.php';
    	post_product_from_account($_POST);
	}
}
//User settings (my account)
function tc_user_settings()
{
    require_once TC_PLUGIN_PATH . 'includes/user.php';
    tc_my_account_assets();
    get_tc_frontend();
}
//Get added to #TwitterCart products
function tc_get_added_products()
{
    require_once TC_PLUGIN_PATH . 'includes/twitter.php';
    require_once TC_PLUGIN_PATH . 'includes/user.php';
    //if (!isset($_SESSION['tc_products_uploaded']) || !$_SESSION['tc_products_uploaded'])
	{
        tc_update_user_cart(load_new_twitter_cart_products());
    }
}
//Get added to wishlist products
function tc_get_wishlist_products()
{
    require_once TC_PLUGIN_PATH . 'includes/twitter.php';
    require_once TC_PLUGIN_PATH . 'includes/user.php';
    //if (!isset($_SESSION['tc_wishlist_uploaded']) || !$_SESSION['tc_wishlist_uploaded'])
	{
        tc_update_user_wishlist(load_new_wishlist_products());
    }
}
//Find removed TwitterCart prouct
function tc_check_twitter_product()
{
    require_once TC_PLUGIN_PATH . 'includes/products.php';
    tc_cart_update();
}
//After order completed remove all twitter orders
function tc_set_all_orders_as_removed()
{
    require_once TC_PLUGIN_PATH . 'includes/user.php';
    remove_users_twitter_orders(get_current_user_id());
}
//Deactivate user account
function tc_deactivate_account()
{
	if( wp_verify_nonce( $_POST['tc_secure_field'], 'nonce_tc_link_auth_nonce_field' ) )
	{
		require_once TC_PLUGIN_PATH . 'includes/user.php';
		deactivate_user_twitter_account(get_current_user_id());
	}
}
//Session destroy on logout
function tc_session_destroy()
{
    if (!session_id()) {
        session_start();
    }
    session_destroy();
}
function my_message($message, $errormsg = false)
{
    if ($errormsg) {
        echo '<div id="message" class="error">';
    } else {
        echo '<div id="message" class="updated fade">';
    }
    echo "<p><strong>$message</strong></p></div>";
}
function my_message_styled($message, $errormsg = false)
{
    $str = "";
    if ($errormsg) {
        $str .= '<div id="message" class="error mynotice" >';
    } else {
        $str .= '<div id="message" class="updated fade mynotice" style="width:95%; border-left: 4px solid #26b8ea !important;">';
    }
    $str .= "<p><strong>$message</strong></p><hidedt style=\"float: right; margin-top: -45px; cursor: pointer;\" onclick=\"jQuery('.mynotice').remove();\"><i class='notice-dismiss' style='position:initial;'></i></hidedt></div>";
    echo $str;
}
function get_options_url($text = 'OPTIONS')
{
	$link = get_admin_url() . 'admin.php?page=tct_settings';
	$html = "<a href=\"$link\">$text</a>";
	return $html;
}
function need_datatables()
{
    if (isset($_GET['page']) && ($_GET['page'] == 'tc_products' || $_GET['page'] == 'tc_products_vendor')) {
        return TRUE;
    }
    return FALSE;
}
function set_datatables()
{
    echo "<script>jQuery('.tc_datatable').dataTable({
    'oLanguage': {
      'sEmptyTable': '".__('No data available in table', 'twittercart')."',
      'sLengthMenu': '".__('Show _MENU_ entries', 'twittercart')."',
	  'sSearch': '".__('Search:', 'twittercart')."',
	  'sInfo': '".__('Showing _START_ to _END_ of _TOTAL_ entries', 'twittercart')."',
	  'sZeroRecords': '".__('No matching records found', 'twittercart')."',
	  'sLoadingRecords': '".__('Loading...', 'twittercart')."',
	  'sProcessing': '".__('Processing...', 'twittercart')."',
      'oPaginate': { 'sFirst': '".__('First', 'twittercart')."',
      'sLast': '".__('Last', 'twittercart')."',
      'sNext': '".__('Next', 'twittercart')."',
      'sPrevious': '".__('Previous', 'twittercart')."'}
    }
  });</script>";
}
function tct_activation_redirect( $plugin )
{
    if( $plugin == TC_PLUGIN_BASENAME ) {
        exit( wp_redirect( admin_url( 'admin.php?page=tct_settings' ) ) );
    }
}