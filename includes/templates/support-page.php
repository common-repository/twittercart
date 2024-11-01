<?php
defined('ABSPATH') or die('Access denied!');
$output = "";
ob_start(); ?>
<div class="wrap">
	<div id="wrapper" class="upd" style="width: 95%; margin: 0 auto;">
		<header id="header">
			<h1 id="headertitle"><?php _e( "TwitterCart Support", 'twittercart' ); ?></h1>
		</header>
		
		<!-- latest updates, start -->
		<div class="tct-wrapper">
			<div class="tct-info-header">
				<div class="tct-arr-icon">
					<a href="javascript:;" class="tct-acco-arr">
						<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_clos.png'; ?>" class="tct-arrow down tct-down" />
					</a>
				</div>
				
				<div class="tct-label-icon">
					<img src="<?php echo TC_PLUGIN_URL .'assets/images/upd_ico02.png'; ?>" class="tct-icon-label" />
				</div>
				
				<div class="tct-label">
					<?php _e( "Latest Update", 'twittercart' ); ?>
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
						<div class="latest_update" style="display: block;">
							<p>v. 2.2</p>
							
                            <div class="update_change">
								<span class="added"><?php _e( "Added:", 'twittercart' ); ?></span>
								<span class="desc">
									<p><?php _e( 'TwitterCart is now translation ready for the following 5 languages; Arabic, French, Hindi, Spanish, and Russian. Go to Settings/General and choose from the dropdown under "Site Language" to switch language.', 'twittercart' ); ?></p>
								</span>
							</div>
                           
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- latest updates, stop -->
		
		<!-- update history, start -->
		<div class="tct-wrapper">
			<div class="tct-info-header">
				<div class="tct-arr-icon">
					<a href="javascript:;" class="tct-acco-arr">
						<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_clos.png'; ?>" class="tct-arrow down tct-right" />
					</a>
				</div>
				
				<div class="tct-label-icon">
					<img src="<?php echo TC_PLUGIN_URL .'assets/images/upd_ico01.png'; ?>" class="tct-icon-label" />
				</div>
				
				<div class="tct-label">
					<?php _e( "Update history", 'twittercart' ); ?>
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
						<div class="date_update">
							<p>v. 2.2</p>
							<div class="update_change">
								<span class="added"><?php _e( "Added:", 'twittercart' ); ?></span>
								<span class="desc">
									<p><?php _e( 'TwitterCart is now translation ready for the following 5 languages; Arabic, French, Hindi, Spanish, and Russian. Go to Settings/General and choose from the dropdown under "Site Language" to switch language.', 'twittercart' ); ?></p>
								</span>
							</div>
							<p>v. 2.1</p>
							<div class="update_change">
								<span class="added"><?php _e( "Added:", 'twittercart' ); ?></span>
								<span class="desc">
									<p><?php _e( "Added new security patches for ajax.", 'twittercart' ); ?></p>
								</span>
							</div>
                            <p>v. 2.0</p>
							<div class="update_change">
								<span class="added"><?php _e( "Added:", 'twittercart' ); ?></span>
								<span class="desc">
									<p><?php _e( "Added new security patches and updated twitter API.", 'twittercart' ); ?></p>
                                    <p><?php _e( "Introduced new wp-admin menu structure.", 'twittercart' ); ?></p>
                                    <p><?php _e( "Option and instruction menus are merged in single menu.", 'twittercart' ); ?></p>
                                    <p><?php _e( "Added new options to Post WooCommerce product to twitter.", 'twittercart' ); ?></p>
								</span>
							</div>
							
							<p>v. 1.3.7</p>
							<div class="update_change">
								<span class="added"><?php _e( "Added:", 'twittercart' ); ?></span>
								<span class="desc">
									<p><?php _e( "Updated Compatibility issue with WordPress.", 'twittercart' ); ?></p>
								</span>
							</div>
							
							<p>v. 1.3.6</p>
							<div class="update_change">
								<span class="fixed"><?php _e( "Added:", 'twittercart' ); ?></span>
								<span class="desc">
									<p><?php _e( "Resolved Compatibility issue with WordPress.", 'twittercart' ); ?></p>
								</span>
							</div>
							
							<p>v. 1.3.5</p>
							<div class="update_change">
								<span class="fixed"><?php _e( "Fixed:", 'twittercart' ); ?></span>
								<span class="desc">
									<p><?php _e( "Resolved Conflict issue with JetPack.", 'twittercart' ); ?></p>
								</span>
							</div>
                            <p>v. 1.3.4</p>
							<div class="update_change">
								<span class="added"><?php _e( "Fixed:", 'twittercart' ); ?></span>
								<span class="desc">
									<p><?php _e( "CSS Updates for WooCommerce.", 'twittercart' ); ?></p>
								</span>
							</div>
                            <p>v. 1.3.36</p>
							<div class="update_change">
								<span class="added"><?php _e( "Fixed:", 'twittercart' ); ?></span>
								<span class="desc">
									<p><?php _e( "Plugin release. Operate all the basic functions.", 'twittercart' ); ?></p>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- updae history, stop -->
		
				
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
		
			<div class="tct-info-content" style="padding: 0;">
				<div class="tct-form-fds">
					<div class="update_history">
						<div class="update_change1">
							<p><?php _e("For support, please go to Wordpress and submit a support request (link to follow once we finalize the plugin registration).", 'twittercart' ); ?> <?php _e("For WordPress users on the GPL (Free) version of TwitterCart, please go to WordPress and", 'twittercart' ); ?> <a href="https://wordpress.org/support/plugin/twittercart"><?php _e("Submit a Support Request.", 'twittercart' ); ?></a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- support, stop -->
		
		<!-- instruction for administrators, start -->
		<div class="tct-wrapper">
			<div class="tct-info-header">
				<div class="tct-arr-icon">
					<a href="javascript:;" class="tct-acco-arr">
						<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_clos.png'; ?>" class="tct-arrow down tct-right" />
					</a>
				</div>
				
				<div class="tct-label-icon">
					<img src="<?php echo TC_PLUGIN_URL .'assets/images/instr_ico01.png'; ?>" class="tct-icon-label" />
				</div>
				
				<div class="tct-label">
					<?php _e( "TwitterCart instructions for Administrators", 'twittercart' ); ?>
				</div>
				
				<div class="tct-arr-icon end-arrow" style="display:none;">
					<a href="javascript:;">
						<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_opn.png'; ?>" class="tct-arrow down open" />
					</a>
				</div>
			</div>
		
			<div class="tct-info-content" style="display: none; padding: 0;">
				<div class="instr_admin_contant" style="padding: 20px;">
					<strong><?php _e( "Activation", 'twittercart' ); ?></strong>
					<p><?php _e( "After activation of the TwitterCart plugin, you will need to setup API credentials to connect your Woocommerce store account.", 'twittercart' ); ?></p>
					
					<ul>
						<li><?php _e( "1. Twitter API key.", 'twittercart' ); ?></li>
						<li><?php _e( "2. Twitter API secret key.", 'twittercart' ); ?></li>
						<li><?php _e( "3. Twitter API access token.", 'twittercart' ); ?></li>
						<li><?php _e( "4. Twitter API secret token secret.", 'twittercart' ); ?></li>
					</ul>
					<p><?php _e( "With TwitterCart, you can create custom hashtags for promoting products on Twitter ( ie. Add to cart, Add to wishlist).", 'twittercart' ); ?></p>
					
					<strong><?php _e( "Posting products to Twitter", 'twittercart' ); ?></strong>
					<p>
						<?php _e( 'In order to post items to Twitter, you should to go to the product page and click on the "Post product to Twitter" for the selected product in the Actions column. Next, you can change default text of the tweet. After you have customized your tweet, with or without the product image checkmarked, click the "Tweet" button product and your product tweet with hashtag(s) will be posted on Twitter instantly.', 'twittercart' ); ?>
					</p>
					
					<strong><?php _e( "Twitter Account", 'twittercart' ); ?></strong>
					<p>
						<?php _e( "If you have the Pro or Vendor version of TwitterCart, you can manage your Twitter account within Wordpress admin panel. Go to the Twitter account page within the plugin. On this page you can see the available functionality, which is very much like Twitter's own layout, ie. Retweets, replies, direct messages, follow and unfollow etc.", 'twittercart' ); ?>
					</p>
					
					<strong><?php _e( "Plugin Statistics", 'twittercart' ); ?></strong>
					<p>
						<?php _e( "If you have the Pro or Vendor version of TwitterCart, Plugin statistics are available on Statistics page. You can see your most retweeted, most replied products etc. All statistics within all stores (if you have the Vendor plugin version) as well as all hashtags.", 'twittercart' ); ?>
					</p>
				</div>
			</div>
		</div>
		<!-- instruction for administrators, stop -->
		
		<!-- instruction for customers, start -->
		<div class="tct-wrapper">
			<div class="tct-info-header">
				<div class="tct-arr-icon">
					<a href="javascript:;" class="tct-acco-arr">
						<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_clos.png'; ?>" class="tct-arrow down tct-right" />
					</a>
				</div>
				
				<div class="tct-label-icon">
					<img src="<?php echo TC_PLUGIN_URL .'assets/images/instr_ico02.png'; ?>" class="tct-icon-label" />
				</div>
				
				<div class="tct-label">
					<?php _e( "TwitterCart instructions for Customers", 'twittercart' ); ?>
				</div>
				
				<div class="tct-arr-icon end-arrow" style="display:none;">
					<a href="javascript:;">
						<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_opn.png'; ?>" class="tct-arrow down open" />
					</a>
				</div>
			</div>
		
			<div class="tct-info-content" style="display: none; padding: 0;">
				<div class="instr_costumer_contant" style="padding: 20px">
					<strong><?php _e( "Twitter Account", 'twittercart' ); ?></strong>
					<p>
						<?php _e( 'Customers have the option to authorize TwitterCart in their "My Account" page. At the bottom of "My Account" page, customers should click "Link my Twitter account" button and agree with Twitter rules on next page.  This authorizes their account and they can use hashtags in replies on Twitter for adding products from the store to their shopping cart or wishlist for checkout the next time they login to their account on the vendor store.', 'twittercart' ); ?>
					</p>
				</div>
			</div>
		</div>
		<!-- instruction for customers, stop -->
		
		
		<!-- faqs, start -->
		<div class="tct-wrapper">
			<div class="tct-info-header">
				<div class="tct-arr-icon">
					<a href="javascript:;" class="tct-acco-arr">
						<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_clos.png'; ?>" class="tct-arrow down tct-right" />
					</a>
				</div>
				
				<div class="tct-label-icon">
					<img src="<?php echo TC_PLUGIN_URL .'assets/images/faq_ico01.png'; ?>" class="tct-icon-label" />
				</div>
				
				<div class="tct-label">
					<?php _e( "Frequently Asked Questions", 'twittercart' ); ?>
				</div>
				
				<div class="tct-arr-icon end-arrow" style="display:none;">
					<a href="javascript:;">
						<img src="<?php echo TC_PLUGIN_URL .'assets/images/activ_opn.png'; ?>" class="tct-arrow down open" />
					</a>
				</div>
			</div>
		
			<div class="tct-info-content" style="display: none; padding: 0;">
				<div class="questions">
					<ul>
						<li class="quest1">
							<span><?php _e( "Why do I need to connect my Twitter account?", 'twittercart' ); ?></span>
							<?php _e( "By connecting your Twitter with your ecommerce store account, you are notifying the store that #TwitterCart requests coming from your Twitter account should be added to your shopping cart. Without that link, the store owner would not know to which customer's cart to add the item. To edit your Twitter authorization preferences, visit your account page or opt out of having the store respond to your #TwitterCart requests here (your accounts must be connected in order to opt out).", 'twittercart' ); ?>
						</li>
						<li class="quest2">
							<span><?php _e( "Will #TwitterCart work if my Twitter account is protected?", 'twittercart' ); ?></span>
							<?php _e( "No, #TwitterCart only works for public Twitter accounts and tweets. If your Twitter account is protected, only your followers can see your tweets. This means that #TwitterCart won't be able to see your replies and add the item to your shopping cart.", 'twittercart' ); ?>
						</li>
						<li class="quest3">
							<span><?php _e( 'Am I buying the product when I reply with the store "#TwitterCart" hashtag?', 'twittercart' ); ?></span>
							<?php _e( 'No, replying with "#TwitterCart" hashtag will only save the item to your Cart. You can always review or edit your Cart at a later time. You will also receive a reply tweet from store Twitter account describing the status of your request (e.g., whether the item was successfully added to your Cart, if it was out of stock, or how you can finish checking out later).', 'twittercart' ); ?>
						</li>
						<li class="quest4">
							<span><?php _e( "Who can see what I've added to my Cart?", 'twittercart' ); ?></span>
							<?php _e( "Most content is public on Twitter, so your #TwitterCart replies will be visible to whomever you replied, to those viewing the conversation, and on your own Timeline (unless your Twitter account is set to private).", 'twittercart' ); ?>
						</li>
					</ul>
					<div class="tc_notes">
						<p>
							<?php _e( "To work correctly with the Twitter API, you must install the necessary permissions (Read, write, and direct messages) on", 'twittercart' ); ?> <a href="https://apps.twitter.com/"><?php _e( "Apps page", 'twittercart' ); ?></a>
						</p>
					</div>
				</div>
			</div>
		</div>
		<!-- faqs, stop -->
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
</script>
<?php
$output = ob_get_clean();
return $output;