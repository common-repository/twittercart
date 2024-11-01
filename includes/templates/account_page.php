<?php
defined('ABSPATH') or die('Access denied!');
ob_start();?>
<div id="tc_wrapper">
	<header id="header">
		<h1><?php _e( "Post product to Twitter", 'twittercart' ); ?></h1>
	</header>
	
	<div id="main">
		<div class="nav_bar">
			<div class="user">
				<div class="user_bg"><?php
				if($user_data['profile_background'] == '/600x200'){ ?>
					<div class="ext_nopic" height="87px"/></div><?php
				}else{ ?>
					<img src="<?php echo $user_data['profile_background']; ?>" alt="user_bg" height="87px" /> <?php
				} ?>
			</div>
			
			<div class="user_info">
				<img class="ava" width="68" height="68" src="<?php echo $user_data['profile_image']; ?>" alt="<?php echo $user_data['screen_name']; ?>" />
				
				<p class="u_name"><?php echo $user_data['name']; ?></p>
				<p class="tw_name"><?php echo '&#64;'.$user_data['screen_name']; ?></p>
				<div class="tw_statist">
					<div class="tweets">
						<p><?php _e( "tweets", 'twittercart' ); ?></p>
						<span><?php echo $user_data['tweets']; ?></span>
					</div>
					<div class="following">
						<p><?php _e( "following", 'twittercart' ); ?></p>
						<span><?php echo $user_data['following']; ?></span>
					</div>
					<div class="followers">
						<p><?php _e( "followers", 'twittercart' ); ?></p>
						<span><?php echo $user_data['followers']; ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tc_main_container"></div>
</div>
<collector id="collector" style="display: none;" preloader_src="<?php echo TC_IMG_URL . 'mydots.gif'; ?>" site_url="<?php echo $site_url ; ?>" image_url="<?php echo TC_IMG_URL; ?>"></collector>
<?php
return ob_get_clean();