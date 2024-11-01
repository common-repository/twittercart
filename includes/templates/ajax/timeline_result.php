<?php
defined('ABSPATH') or die('Access denied!');
$tc_hashtag = get_option( 'tc_twitter_hashtag' );
$tc_wishlist_hashtag = get_option( 'tc_wishlist_hashtag' );
$tc_hashtag = trim($tc_hashtag);
$tc_wishlist_hashtag = trim($tc_wishlist_hashtag);
if( !empty($tc_hashtag) ){
	$tc_hashtag = '#'.$tc_hashtag;
} else {
	$tc_hashtag = '';
}
if( !empty($tc_wishlist_hashtag) ){
	$tc_wishlist_hashtag = '#'.$tc_wishlist_hashtag;
} else {
	$tc_wishlist_hashtag = '';
}
ob_start(); ?>
<div class="side_bar" id="testscroll">
	<div class="support-box" style="background: white;">
		<span><?php _e( "Tweet Tips", 'twittercart' ); ?></span>
		<p style="padding: 0px 10px 5px 10px;">
			<?php _e( "Edit your tweet... you have 140 characters including the image so make it good and you should reference the #hashtag you use in your tweet that you wish customers or visitor to reply with to gain new business.", 'twittercart' ); ?></p>
        <p style="padding: 0px 10px 5px 10px;">
        <?php _e( "So for example if your hashtag is #mytwittercart then edit the product tweet before posting to include your hashtag ie. reply with #mytwittercart to add this item to your cart!", 'twittercart' ); ?>
		</p>
	</div>
	<a href="https://twittercart.com/" target="_blank">
		<img src="<?php echo TC_IMG_URL . 'twt_cart.jpg'; ?>" width="268" height="120" alt="TwitterCart" />
	</a>
	
</div>
<div id="content">
	<form onsubmit="javascript:void(0);" class="my_news">
		<img src="<?php echo $user_data['profile_image']; ?>" width="32" height="32" alt="" />
		<div class="add_new"><?php
			if ($pfp) { ?>
			<textarea name="whatsNew" id="whatsNew" oninput="textareaChanged(this);" maxlength="140" placeholder="<?php _e( "What's New?", 'twittercart' ); ?>"><?php
			echo $pfp['default_status_text']."\r\n".$tc_hashtag; ?></textarea>
			<input type="hidden" name="inreply" id="inreply" value="false">
			<div class="twt_send">
				<span id="productAttachCheck" style="display: block; margin-top: 8px;">
					<label for="productAttach">
					<img src="<?php echo TC_IMG_URL.'add_twt.png'; ?>" />
                    <?php
					$image = wp_get_attachment_image_src(get_post_thumbnail_id($pfp['product']['id']),'full');
					if( $image[0] == "" || empty( $image[0] ) )
					{
						?> <input type="checkbox" name="productAttach" id="productAttach" >&nbsp; <?php
					}
					else
					{
						?> <input type="checkbox" name="productAttach" id="productAttach" checked="true">&nbsp; <?php
                    }
					?>
					<?php _e( "Product image", 'twittercart' ); ?></label>
				</span>
				<span id="tc_hashtag_attach" style="display: block;" class="show_hide_hashtags">
					<input type="checkbox" name="tc_hashtag_attach_check" id="tc_hashtag_attach_check" checked="true">&nbsp;
					<label for="tc_hashtag_attach_check"><?php echo $tc_hashtag; ?></label>
				</span>
				<span id="tc_wlhashtag_attach" style="display: block;" class="show_hide_hashtags">
					<input type="checkbox" name="tc_wlhashtag_attach_check" id="tc_wlhashtag_attach_check">&nbsp;
					<label for="tc_wlhashtag_attach_check"><?php echo $tc_wishlist_hashtag; ?></label>
				</span>
				<span class="symbols">140</span>
				<input type="button" style="cursor: pointer;" onclick="tweetSubmit();" value="<?php _e( "Tweet", 'twittercart' ); ?>" />
				<input type="hidden" id="hiddenid" value="<?php echo $pfp['product']['id']; ?>" /><?php
				wp_nonce_field( 'nonce_tc_product_post_nonce_field', 'tc_product_post_nonce_field' );
				
			} else { ?>
			<h1><?php _e( "No product found", 'twittercart' ); ?></h1><?php
			} ?>
			</div>
		</div>
	</form>
</div>
<?php
return ob_get_clean();