<?php
defined('ABSPATH') or die('Access denied!');
	/* api code, start*/
	if ( !empty( $_POST['optionsform'] ) ) {
		$api_key = trim( $_POST['twt_api_key'] );
		$api_secret = trim( $_POST['twt_api_sec'] );
		$access_token = trim( $_POST['acc_tok'] );
		$access_token_secret = trim( $_POST['acc_tok_sec'] );
		update_option( 'tc_twitter_api_key', $api_key );
		update_option( 'tc_twitter_api_secret', $api_secret );
		update_option( 'tc_twitter_access_token', $access_token );
		update_option( 'tc_twitter_access_token_secret', $access_token_secret );
		//update_option('tc_site_dir', $site_dir);
		global $wpdb;	
		$tables = array(	
			'tc_products',
			'tc_accounts',
			'tc_twitter_orders',
			'tc_twitter_wishlist',
			'tc_user_tokens',
			'tc_user_hashtags',
			'tc_user_showed',
			'tc_checked'
			);
		foreach( $tables as $table ){	
			$wpdb->query("TRUNCATE TABLE {$wpdb->prefix}$table;");	
		}
		my_message( __('Options was successfully saved!', 'twittercart') );
	}
	if ( !empty( $_POST['hashtagoptionsform'] ) ) {
		$hashtag = trim( $_POST['add_to_cart'] );
		$wishlist_hashtag = trim( $_POST['add_to_wish'] );
		$add_to_site_cart_page = trim( $_POST['add_to_site_cart_page'] );
		update_option( 'tc_twitter_hashtag', $hashtag );
		update_option( 'tc_wishlist_hashtag', $wishlist_hashtag );
		//update_option('tc_site_dir', $site_dir);
		global $wpdb;	
		$tables = array(	
			'tc_products',
			'tc_twitter_orders',
			'tc_twitter_wishlist',
			'tc_user_hashtags',
			'tc_user_showed',
			'tc_checked'
			);
		foreach( $tables as $table ){	
			$wpdb->query("TRUNCATE TABLE {$wpdb->prefix}$table;");	
		}
		my_message( __('HashTags was successfully saved!', 'twittercart') );
	}
	$hashtag = get_option( 'tc_twitter_hashtag' );
	$wishlist_hashtag = get_option( 'tc_wishlist_hashtag' );
	$api_key = get_option( 'tc_twitter_api_key' );
    $api_secret = get_option( 'tc_twitter_api_secret' );
    $access_token = get_option( 'tc_twitter_access_token' );
    $access_token_secret = get_option( 'tc_twitter_access_token_secret' );
	/* api code, end*/
	ob_start(); ?>
<tcollector site_url=<?php echo BASE_SITE_URL ?>></tcollector>
<div class="wrap">
<div id="wrapper" class="upd" style="width: 95%; margin: 0 auto;">
		<header id="header">
			<h1 id="headertitle"><?php _e( "TwitterCart Settings", 'twittercart' ); ?></h1>
		</header>
	<!-- support, start -->
	<div class="tct-wrapper">
		<div class="tct-info-header">
			<div class="tct-arr-icon">
				<a href="javascript:;" class="tct-acco-arr">
					<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_clos.png'; ?>" class="tct-arrow down tct-right" />
				</a>
			</div>
			<div class="tct-label-icon">
				<img src="<?php echo TC_PLUGIN_URL .'assets/images/support-icon.png'; ?>" class="tct-icon-label" />
			</div>
			<div class="tct-label">
				<?php _e( "Support", 'twittercart' ); ?>
			</div>
			<div class="tct-arr-icon end-arrow" style="display:none;">
				<a href="javascript:;">
					<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_opn.png'; ?>" class="tct-arrow down open" />
				</a>
			</div>
		</div>
		<div class="tct-info-content" style="display: none; padding: 0;">
			<div class="tct-form-fds">
				<div class="update_history">
					<div class="update_change1">
						<p>
							<?php _e( "For support, please go to Wordpress and submit a support request (link to follow once we finalize the plugin registration).", 'twittercart' ); ?>
							<?php _e( "For WordPress users on the GPL (Free) version of TwitterCart, please go to WordPress and", 'twittercart' ); ?> <a href="https://wordpress.org/support/plugin/twittercart"><?php _e( "Submit a Support Request.", 'twittercart' ); ?></a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- support, stop -->
	<!-- twitter api, start -->
	<div class="tct-wrapper">
		<div class="tct-info-header">
			<div class="tct-arr-icon">
				<a href="javascript:;" class="tct-acco-arr">
					<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_clos.png'; ?>" class="tct-arrow down tct-right" />
				</a>
			</div>
			<div class="tct-label-icon">
				<img src="<?php echo TC_PLUGIN_URL .'assets/images/opt_ico01.png'; ?>" class="tct-icon-label" />
			</div>
			<div class="tct-label">
				<?php _e( "Twitter API", 'twittercart' ); ?>
			</div>
			<div class="tct-arr-icon end-arrow" style="display:none;">
				<a href="javascript:;">
					<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_opn.png'; ?>" class="tct-arrow down open" />
				</a>
			</div>
		</div>
		<div class="tct-info-content" style="display: block; padding: 0;">
			<div class="tct-submit-button">
			<div class="opt_settings" style="margin-right: 0;">
				<form name="optionsform" id="optionsform" method="POST" action="">
						<input type="hidden" name="optionsform" value="yes" />
                        <label for="twt_api_key"><?php _e( "Twitter API key", 'twittercart' ); ?></label><input style="margin: 0;" id="twt_api_key" name="twt_api_key" type="text" placeholder="<?php _e( "Twitter API key", 'twittercart' ); ?>" value="<?php echo $api_key; ?>" />
                        <label for="twt_api_sec"><?php _e( "Twitter API secret", 'twittercart' ); ?></label><input style="margin: 0;" id="twt_api_sec" name="twt_api_sec" type="text" placeholder="<?php _e( "Twitter API secret", 'twittercart' ); ?>"  value="<?php echo $api_secret; ?>" />
                        <label for="acc_tok"><?php _e( "Access token", 'twittercart' ); ?></label><input style="margin: 0;" id="acc_tok" name="acc_tok" type="text" placeholder="<?php _e( "Access token", 'twittercart' ); ?>" value="<?php echo $access_token; ?>" />
                        <label for="acc_tok_sec"><?php _e( "Access token secret", 'twittercart' ); ?></label><input style="margin: 0;" id="acc_tok_sec" name="acc_tok_sec" type="text" placeholder="<?php _e( "Access token secret", 'twittercart' ); ?>" value="<?php echo $access_token_secret; ?>"/>
                        <input type="button" onclick="updateAdminOptions();" style="cursor: pointer;" value="<?php _e( "Save", 'twittercart' ); ?>" />
                    </form>
					</div>
			</div>
		</div>
	</div>
	<!-- twitter api, stop -->
	<!-- twitter hastags, start -->
	<div class="tct-wrapper">
		<div class="tct-info-header">
			<div class="tct-arr-icon">
				<a href="javascript:;" class="tct-acco-arr">
					<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_clos.png'; ?>" class="tct-arrow down tct-right" />
				</a>
			</div>
			<div class="tct-label-icon">
				<img src="<?php echo TC_PLUGIN_URL .'assets/images/hashtag-icon-02.png'; ?>" class="tct-icon-label" />
			</div>
			<div class="tct-label">
				<?php _e( "TwitterCart #HashTags", 'twittercart' ); ?>
			</div>
			<div class="tct-arr-icon end-arrow" style="display:none;">
				<a href="javascript:;">
					<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_opn.png'; ?>" class="tct-arrow down open" />
				</a>
			</div>
		</div>
		<div class="tct-info-content" style="display: none; padding: 0;">
			<div class="tct-submit-button">
			<div class="opt_settings" style="margin-right: 0;">
				<form name="optionsform" id="optionsform" method="POST" action="">
						<input type="hidden" name="hashtagoptionsform" value="yes" />
                        <label for="add_to_cart"><?php _e( "#AddToCart hashtag", 'twittercart' ); ?></label><input style="margin: 0;" id="add_to_cart" name="add_to_cart" type="text" placeholder="<?php _e( "#AddToCart hashtag", 'twittercart' ); ?>" value="<?php echo $hashtag; ?>"/>
                        <label for="add_to_wish"><?php _e( "#AddToWishlist hashtag", 'twittercart' ); ?></label><input style="margin: 0;" id="add_to_wish" name="add_to_wish" type="text" placeholder="<?php _e( "#AddToWishlist hashtag", 'twittercart' ); ?>" value="<?php echo $wishlist_hashtag; ?>"/>
                        <input type="submit" style="cursor: pointer;" value="<?php _e( "Save", 'twittercart' ); ?>" />
                    </form>
					</div>
			</div>
		</div>
	</div>
	<!-- twitter hashtags, stop -->
	<!-- twitter app instruction, start -->
	<div class="tct-wrapper">
		<div class="tct-info-header">
			<div class="tct-arr-icon">
				<a href="javascript:;" class="tct-acco-arr">
					<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_clos.png'; ?>" class="tct-arrow down tct-right" />
				</a>
			</div>
			<div class="tct-label-icon">
				<img src="<?php echo TC_PLUGIN_URL .'assets/images/opt_ico02.png'; ?>" class="tct-icon-label" />
			</div>
			<div class="tct-label">
				<?php _e( "How I obtain Twitter App API details?", 'twittercart' ); ?>
			</div>
			<div class="tct-arr-icon end-arrow" style="display:none;">
				<a href="javascript:;">
					<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_opn.png'; ?>" class="tct-arrow down open" />
				</a>
			</div>
		</div>
		<div class="tct-info-content" style="display: none; padding: 0;">
			<div class="tct-form-fields">
				<div class="howdo_contain">
					<ul>
						<li><?php _e( '<span>1</span>Go to the <a href="https://apps.twitter.com/">Apps page</a> on Twitter and click &quot;Create New App&quot;.', 'twittercart' ); ?></li>
						<li><?php _e( "<span>2</span>Set required info about your application and save.", 'twittercart' ); ?></li>
						<li><?php _e( "<span>3</span>Go to &quot;Keys and Access Tokens&quot; tab and copy API key and API secret.", 'twittercart' ); ?></li>
						<li><?php _e( "<span>4</span>Click &quot;Create my access token&quot; and copy genearted token and token secret.", 'twittercart' ); ?></li>
					</ul>
					<p class="faw_quest"><?php _e( "What can I include in hashtags fields?", 'twittercart' ); ?></p>
					<p><?php _e( "The Hashtag can contain any characters and/ or numerical digits, but max length must not exceed 140 characters.", 'twittercart' ); ?></p>
				</div>
			</div>
		</div>
	</div>
	<!-- twitter app instruction, stop -->
	</div>
</div>
	<script type="application/javascript">
		jQuery(document).ready(function($){
			$(".tct-info-header").click(function(){
				var arrow = $(this).find(".tct-acco-arr");
				var arrowImg = $(this).find('.tct-arrow ');
				var content = arrow.parents(".tct-wrapper").find(".tct-info-content");
				if(content.is(":visible")){
					content.slideUp({
						duration: 500,
						start: function(){
							if(arrowImg.hasClass("tct-down")){
								arrowImg.removeClass("tct-down");
								arrowImg.addClass("tct-right");
							} else {
								arrowImg.addClass("tct-right");
							}
						}
					});
				} else {
					content.slideDown({
						duration: 500,
						start: function(){
							if(arrowImg.hasClass("tct-right")){
								arrowImg.removeClass("tct-right");
								arrowImg.addClass("tct-down");
							} else {
								arrowImg.addClass("tct-down");
							}
						}
					});
				}
			});
		});
	</script> <?php
	$ret_string = ob_get_clean();
return $ret_string;