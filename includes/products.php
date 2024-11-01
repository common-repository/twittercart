<?php
defined('ABSPATH') or die('Access denied!');

/*
 * Product pages
*/

//Products section (admin panel)
function generate_products_page()
{
	global $post, $product, $woocommerce;
    //Product was posted, and now available for buying
    if (isset($_GET['posted'])) {
        my_message(__('Product was successfully posted to twitter!', 'twittercart'));
    }
    $products = get_all_products();
    $post_url = get_admin_url() . 'admin.php?page=tc_account_page&id=';
    echo require_once TC_TEMPLATES_PATH . 'products_page.php';
    set_datatables();
}

//Get Product For Posting
function get_pfp($product_id)
{
    $pfp['product'] = tc_get_product($product_id);
    $pfp['default_status_text'] = get_default_status_text($pfp['product']);
    return $pfp;
}

/*
 * Product fucntions
 */
//Get all products (post with type 'product')
function get_all_products()
{
	global $post, $product, $woocommerce;
    $products = array();
    if (tc_is_admin()) {
        $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'orderby' => 'date');
        $posts = get_posts($args);
        foreach ($posts as $product) {
            $productObj = new WC_Product($product->ID);
			$price = get_post_meta($product->ID, '_regular_price', true);
			$sale = get_post_meta($product->ID, '_price', true);
			if(!empty($sale)){
				$newprice = $sale;
			}else{
				$newprice = $price;
			}
            $products[$product->ID]['id'] = $product->ID;
            $products[$product->ID]['title'] = $product->post_title;
            $products[$product->ID]['permalink'] = get_permalink($product->ID);
            $products[$product->ID]['image'] = get_product_image($product->ID);
            //$products[$product->ID]['price'] = tc_format_woo_price($productObj->price);
			$products[$product->ID]['price'] = tc_format_woo_price($newprice);
            $products[$product->ID]['date'] = $product->post_date;
            $products[$product->ID]['category'] = get_category_str($product->ID);
            $products[$product->ID]['in_stock'] = get_stock_count($product->ID);
            $products[$product->ID]['twitter_status_id'] = get_twitter_status_id($product->ID);
            $products[$product->ID]['twitter_status_text'] = get_twitter_status_text($product->ID);
            $products[$product->ID]['twitter_status_link'] = get_twitter_status_link($product->ID);
        }
    } else {
		global $post, $product, $woocommerce;
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'author' => get_current_user_id()
        );
        $posts = get_posts($args);
        foreach ($posts as $product) {
            $productObj = new WC_Product($product->ID);
            $products[$product->ID]['id'] = $product->ID;
            $products[$product->ID]['title'] = $product->post_title;
            $products[$product->ID]['permalink'] = get_permalink($product->ID);
            $products[$product->ID]['image'] = get_product_image($product->ID);
            $products[$product->ID]['price'] = tc_format_woo_price($productObj->price);
            $products[$product->ID]['date'] = $product->post_date;
            $products[$product->ID]['in_stock'] = get_stock_count($product->ID);
            $products[$product->ID]['category'] = get_category_str($product->ID);
            $products[$product->ID]['twitter_status_id'] = get_twitter_status_id($product->ID);
            $products[$product->ID]['twitter_status_text'] = get_twitter_status_text($product->ID);
            $products[$product->ID]['twitter_status_link'] = get_twitter_status_link($product->ID);
        }
    }
    return $products;
}

function tc_format_woo_price($price)
{
	global $wpdb;
    $decimals = get_option('woocommerce_price_num_decimals');
    $currency = get_woocommerce_currency_symbol();
    $position = get_option('woocommerce_currency_pos');
	if(!empty($price)){ 
		$price = number_format($price, $decimals); 
	}else{
		$price = '0.00';
	}
    if ($position == 'left') {
        return $currency . $price;
    } elseif ($position == 'left_space') {
        return $currency . "&nbsp;" . $price;
    } elseif ($position == 'right') {
        return $price . $currency;
    } else {
        return $price . '&nbsp;' . $currency;
    }
}

//Get product data array
function tc_get_product($product_id)
{
	global $post, $product, $woocommerce;
    $post = get_post($product_id);
    $productObj = new WC_Product($post->ID);
    $return = array();
    $return['id'] = $post->ID;
    $return['title'] = $post->post_title;
    $return['permalink'] = get_permalink($post->ID);
    $return['image'] = get_product_image($post->ID);
    $return['img_url'] = get_product_image_url($post->ID);
    $return['price'] = $productObj->get_price();
    /*$return['price'] = strip_tags($productObj->get_price_html());*/
    $return['date'] = $post->post_date;
    $return['twitter_status_id'] = get_twitter_status_id($post->ID);
    $return['twitter_status_text'] = get_twitter_status_text($post->ID);
    return $return;
}

//Return post (product) image
function get_product_image($product_id, $width = 40, $height = 40)
{
    return get_the_post_thumbnail($product_id, array($width, $height));
}

//Return url of product image
function get_product_image_url($product_id)
{
    $image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id),'full');
    return $image[0];
}

//Return ID of twitter post to this product
function get_twitter_status_id($product_id)
{
    global $wpdb;
    $tablename = $wpdb->prefix . "tc_products";
    $sql = "SELECT twitter_status_id FROM $tablename WHERE product_id = $product_id";
    $result = $wpdb->get_var($sql);
    if (empty($result)) {
        $result = FALSE;
    }
    return $result;
}

//Check twitter order product

function tc_product_is_active($product_id)
{
    global $wpdb;	
    $status_id = get_twitter_status_id($product_id);
    $table_name = $wpdb->prefix . "tc_twitter_orders";
    $sql = "SELECT status FROM $table_name WHERE in_reply_to_status_id = $status_id";
    $result = $wpdb->get_var($sql);
    if ($result == 'active') {
        return TRUE;
    } else {
        return FALSE;
    }
}

//Check twitter order product
function tc_product_is_active_duplicate($product_id)
{
    global $wpdb;	
    $status_id = get_twitter_status_id($product_id);
    $table_name = $wpdb->prefix . "tc_twitter_orders";
    $sql = "SELECT status FROM $table_name WHERE in_reply_to_status_id = $status_id";
    //$result = $wpdb->get_var($sql);
	$results = $wpdb->get_results($sql);
	if ( $results )
	{
		for( $count_loop = 0; $count_loop < count($results); $count_loop++)
		{
			if ($results[$count_loop]->status == 'active') {
				return TRUE;
				exit;
			}
		}
		return FALSE;
	}
}

//Return text of twitter post to this product
function get_twitter_status_text($product_id)
{
    global $wpdb;
    $tablename = $wpdb->prefix . "tc_products";
    $sql = "SELECT twitter_status_text FROM $tablename WHERE product_id = $product_id";
    $result = $wpdb->get_var($sql);
    if (empty($result)) {
        $result = 'Not posted';
    }
    return $result;
}

//Return link to the twitter post to this product

function get_twitter_status_link($product_id)
{
    global $wpdb;
    $tablename = $wpdb->prefix . "tc_products";
    $sql = "SELECT twitter_status_link FROM $tablename WHERE product_id = $product_id";
    $result = $wpdb->get_var($sql);
    if (empty($result)) {
        $result = FALSE;
    }
    return $result;
}

//Return default text for twitter post
function get_default_status_text($product)
{
    $text = $product['title'];
    if( empty($product['price']) ){
		$product['price'] = '0.00';
	}
	$text .= " - " . get_woocommerce_currency_symbol() . $product['price'] . PHP_EOL;
    $text = substr($text, 0, 98);
    $text .= $product['permalink'];
    return $text;
}

function get_stock_count($product_id)
{
    global $wpdb;
    $tablename = $wpdb->prefix . "postmeta";
    $sql = "SELECT meta_value FROM $tablename WHERE meta_key = '_stock' AND post_id = $product_id";
    $result = $wpdb->get_var($sql);
    return $result;
}

//Check Twitter priduct remove
function tc_cart_update()
{
    if (!session_id()) {
        session_start();
    }
    global $woocommerce;
    $cart = $woocommerce->cart->get_cart();
	//print_r( $cart );
    if (isset($_SESSION['tc_products']) && !empty($_SESSION['tc_products'])){
        foreach ($_SESSION['tc_products'] as $tc_product) {
            if ($tc_product['status'] == 'added') {
                $found = FALSE;
                foreach ($cart as $wooItem) {
                    if ($wooItem['product_id'] == $tc_product['id']) {
                        $found = TRUE;
                    }
                }
                if (!$found) {
                    $_SESSION['tc_products'][$tc_product['id']]['status'] = 'removed';
                    tc_set_removed($tc_product['id']);
                }
            }
        }
    }
}

function tc_set_removed($product_id)
{
    global $wpdb;
    require_once TC_PLUGIN_PATH . "includes/user.php";
    $status_id = get_twitter_status_id($product_id);
    $user_account = get_user_twitter_account(get_current_user_id());
    $table_name = $wpdb->prefix . "tc_twitter_orders";
    @$wpdb->query(
            $wpdb->prepare(
                    "UPDATE $table_name SET status = 'removed' WHERE in_reply_to_status_id = %s AND user = %s",
                    array(
                        $status_id,
                        $user_account
                    )
            )
    );
}

//Get reply qty by products
function get_category_str($id)
{
    $return = "";
    $terms = get_the_terms($id, 'product_cat');
    if ($terms) {
        foreach ($terms as $term) {
            $return .= $term->name . ", ";
        }
        $return = substr($return, 0, -2);
    }
    return $return;
}

function post_product_from_account($data)
{
    require_once TC_PLUGIN_PATH . 'includes/twitter.php';
    if ($data['attach'] == 'on') {
        $result = post_product_with_media_account($data['message'], $data['product'], get_product_image_url($data['product']));
    } else {
        $result = post_product_without_media_account($data['message'], $data['product']);
    }
    die(json_encode($result));
}