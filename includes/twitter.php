<?php

defined('ABSPATH') or die('Access denied!');

//Return Twitter API object

function connect_twitter($token = FALSE, $secret = FALSE)

{

    require_once TC_LIBS_PATH . 'twitter-api/TwitterAPIExchange.php';

    require_once TC_PLUGIN_PATH . 'includes/user.php';

    if ($token) {

        $settings = array(

            'oauth_access_token' => $token,

            'oauth_access_token_secret' => $secret,

            'consumer_key' => get_option('tc_twitter_api_key'),

            'consumer_secret' => get_option('tc_twitter_api_secret')

        );

    } else {

        $token = get_user_token();

        $secret = get_user_secret();

        if (!empty($token) && $token) {

            $settings = array(

                'oauth_access_token' => $token, //get_option('tc_twitter_access_token'),

                'oauth_access_token_secret' => $secret, //get_option('tc_twitter_access_token_secret'),

                'consumer_key' => get_option('tc_twitter_api_key'),

                'consumer_secret' => get_option('tc_twitter_api_secret')

            );

        } else {

            $settings = array(

                'oauth_access_token' => get_option('tc_twitter_access_token'),

                'oauth_access_token_secret' => get_option('tc_twitter_access_token_secret'),

                'consumer_key' => get_option('tc_twitter_api_key'),

                'consumer_secret' => get_option('tc_twitter_api_secret')

            );

        }

    }

	$_SESSION["tc_auth"]= new TwitterAPIExchange($settings);

    return new TwitterAPIExchange($settings);

}

//Product post without attaches

function post_product_without_media($status_text, $product_id)

{

    $twitter = connect_twitter();

    $url = 'https://api.twitter.com/1.1/statuses/update.json';

    $requestMethod = 'POST';

    $postfields = array('status' => $status_text);

    $response = json_decode($twitter->buildOauth($url, $requestMethod)->setPostfields($postfields)->performRequest());

    save_twitter_response($response, $product_id);

}

//Product post with attaches

function post_product_with_media($status_text, $product_id, $image)

{

    $twitter = connect_twitter();

    $url = 'https://api.twitter.com/1.1/statuses/update_with_media.json';

    $requestMethod = 'POST';

    $postfields = array('media[]' => file_get_contents($image), 'status' => $status_text);

    $response = json_decode($twitter->buildOauth($url, $requestMethod)->setPostfields($postfields)->performRequest());

    save_twitter_response($response, $product_id);

}

function post_product_with_media_account($status_text, $product_id, $image)

{

    $twitter = connect_twitter();

    $url = 'https://api.twitter.com/1.1/statuses/update_with_media.json';

    $requestMethod = 'POST';

    $postfields = array('media[]' => file_get_contents($image), 'status' => $status_text);

    $response = json_decode($twitter->buildOauth($url, $requestMethod)->setPostfields($postfields)->performRequest());

    save_twitter_response($response, $product_id);

    if (!isset($response->errors) || empty($response->errors)) {

        return __("The product was successfully posted to Twitter!", 'twittercart');

    } else {

        return __("Some error. Try again later", 'twittercart');

    }

}

function post_product_without_media_account($status_text, $product_id)

{

    $twitter = connect_twitter();

    $url = 'https://api.twitter.com/1.1/statuses/update.json';

    $requestMethod = 'POST';

    $postfields = array('status' => $status_text);

    $response = json_decode($twitter->buildOauth($url, $requestMethod)->setPostfields($postfields)->performRequest());

    save_twitter_response($response, $product_id);

    if (!isset($response->errors) || empty($response->errors)) {

        return __("The product was successfully posted to Twitter!", 'twittercart');

    } else {

        return __("Some error. Try again later", 'twittercart');

    }

}

//Load new twitter orders (search by hashtag using Twitter API)

function load_new_twitter_cart_products()

{

    global $wpdb;

    $table_name = $wpdb->prefix . "tc_twitter_orders";

    $allHashtags = get_add_hashtags();

    //Get users twitter account

    require_once TC_PLUGIN_PATH . 'includes/user.php';

    $user_account = tc_get_user_twitter_account(get_current_user_id());

    $products = array();

    foreach ($allHashtags as $add_to_cart_hashtag) {

        //Search tweets by user and #hashtag

        $twitter = connect_twitter();

        $url = 'https://api.twitter.com/1.1/search/tweets.json';

        $requestMethod = 'GET';

        $getfield = "?q=" . urlencode("from:" . $user_account . "#" . $add_to_cart_hashtag);

        $response = json_decode($twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest());

        if (isset($response->statuses) && $response->statuses) {

            foreach ($response->statuses as $status) {

				$twitter_status_id = $status->id_str;

				$in_reply_to_status_id = $status->in_reply_to_status_id_str;

				$user = $status->user->screen_name;

				if( $twitter_status_id != "" && $in_reply_to_status_id != "" && $user != "" )

				{

					@$wpdb->query(

							$wpdb->prepare(

									"INSERT INTO $table_name (twitter_status_id, in_reply_to_status_id, user, status) VALUES (%s, %s, %s, %s) ON DUPLICATE KEY UPDATE twitter_status_id = twitter_status_id",

									array(

										$twitter_status_id,

										$in_reply_to_status_id,

										$user,

										'active'

									)

							)

					);

					$products[] = get_product_id_by_status($in_reply_to_status_id);

				}

            }

        }

    }

    return $products;

}

//Load new twitter wishlist (search by hashtag using Twitter API)

function load_new_wishlist_products()

{

    global $wpdb;

    $table_name = $wpdb->prefix . "tc_twitter_wishlist";

    $allHashtags = get_wl_hashtags();

    //Get users twitter account

    require_once TC_PLUGIN_PATH . 'includes/user.php';

    $user_account = tc_get_user_twitter_account(get_current_user_id());

    $products = array();

    foreach ($allHashtags as $wishlist_hashtag) {

        //Search tweets by user and #hashtag

        $twitter = connect_twitter();

        $url = 'https://api.twitter.com/1.1/search/tweets.json';

        $requestMethod = 'GET';

        $getfield = "?q=" . urlencode("from:" . $user_account . "#" . $wishlist_hashtag);

        $response = json_decode($twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest());

        if (isset($response->statuses) && $response->statuses) {

            foreach ($response->statuses as $status) {

                if (!tc_added_to_wishlist($status->id_str)) {

                    $twitter_status_id = $status->id_str;

                    $in_reply_to_status_id = $status->in_reply_to_status_id_str;

                    $user = $status->user->screen_name;

                    @$wpdb->query(

                            $wpdb->prepare(

                                    "INSERT INTO $table_name (twitter_status_id, in_reply_to_status_id, user, status) VALUES (%s, %s, %s, %s) ON DUPLICATE KEY UPDATE twitter_status_id = twitter_status_id",

                                    array(

                                        $twitter_status_id,

                                        $in_reply_to_status_id,

                                        $user,

                                        'active'

                                    )

                            )

                    );

                    $products[] = get_product_id_by_status($in_reply_to_status_id);

                }

            }

        }

    }

    return $products;

}

//Return Woocommerce product ID (Post ID)

function get_product_id_by_status($twitter_status_id)

{

    global $wpdb;

    $table_name = $wpdb->prefix . "tc_products";

    return $wpdb->get_var("SELECT product_id FROM $table_name WHERE twitter_status_id = '$twitter_status_id'");

}

//Save response data

function save_twitter_response($response, $product_id)

{

    global $wpdb;

    $twitter_status_id = $response->id_str;

    $twitter_status_text = $response->text;

    $twitter_status_link = "https://twitter.com/" . $response->user->screen_name . "/status/" . $twitter_status_id;

    $tablename = $wpdb->prefix . "tc_products";

    $wpdb->insert(

            $tablename, array(

        'product_id' => $product_id,

        'twitter_status_id' => $twitter_status_id,

        'twitter_status_link' => $twitter_status_link,

        'twitter_status_text' => $twitter_status_text

            ), array(

        '%d',

        '%s',

        '%s',

        '%s'

            )

    );

    return TRUE;

}



//Get Twitter screen name

function get_username_via_api($userId, $token = false, $secret = false)

{

    $twitter = connect_twitter($token, $secret);

    $url = 'https://api.twitter.com/1.1/account/settings.json';

    $requestMethod = 'GET';

    $response = json_decode($twitter->buildOauth($url, $requestMethod)->performRequest());

    return $response->screen_name;

}

//Get Twitter user data

function get_user_data_twitter()

{

	//$twitter = connect_twitter($token, $secret);

    $twitter = connect_twitter($token = false, $secret = false);

	

    $url = 'https://api.twitter.com/1.1/account/verify_credentials.json';

    $requestMethod = 'GET';

    $response = json_decode($twitter->buildOauth($url, $requestMethod)->performRequest());

    $data = array();

	//print_r($response);

    if ($response) {

        $data['id'] = $response->id_str;

        $data['name'] = $response->name;

        $data['screen_name'] = $response->screen_name;

        $data['following'] = $response->friends_count;

        $data['followers'] = $response->followers_count;

        $data['tweets'] = $response->statuses_count;

        $data['profile_background'] = $response->profile_banner_url . '/600x200';

        $data['bgcolor'] = $response->profile_link_color;

        $data['profile_image'] = $response->profile_image_url;

    }

    return $data;

}



//OAuth test

function tc_get_tokens()

{

    require_once TC_PLUGIN_PATH . 'libs/oauth/tmhOAuth.php';

    $tmhOAuth = new tmhOAuth(array(

        'consumer_key' => get_option('tc_twitter_api_key'),

        'consumer_secret' => get_option('tc_twitter_api_secret'),

    ));

    // send request for a request token

    $tmhOAuth->request("POST", $tmhOAuth->url("oauth/request_token", ""), array(

        // pass a variable to set the callback

        'oauth_callback' => add_query_arg(array('fromfrontend' => 'true'), get_permalink(get_option('woocommerce_myaccount_page_id')))

    ));

    //die(var_dump($tmhOAuth->response));

    if ($tmhOAuth->response["code"] == 200) {

        // get and store the request token

        $response = $tmhOAuth->extract_params($tmhOAuth->response["response"]);

        $_SESSION["authtoken"] = $response["oauth_token"];

        $_SESSION["authsecret"] = $response["oauth_token_secret"];

        // state is now 1

        $_SESSION["authstate"] = 1;

        // redirect the user to Twitter to authorize

        $url = $tmhOAuth->url("oauth/authorize", "") . '?oauth_token=' . $response["oauth_token"];

        die(json_encode($url));

        exit;

    }

    return false;

}

//Get Twitter API tokens

function tc_get_access_token()

{

    require_once TC_PLUGIN_PATH . 'libs/oauth/tmhOAuth.php';

    $tmhOAuth = new tmhOAuth(array(

        'consumer_key' => get_option('tc_twitter_api_key'),

        'consumer_secret' => get_option('tc_twitter_api_secret'),

    ));

    // set the request token and secret we have stored

    $tmhOAuth->config["user_token"] = $_SESSION["authtoken"];

    $tmhOAuth->config["user_secret"] = $_SESSION["authsecret"];

    // send request for an access token

    $tmhOAuth->request("POST", $tmhOAuth->url("oauth/access_token", ""), array(

        // pass the oauth_verifier received from Twitter

        'oauth_verifier' => $_GET["oauth_verifier"]

    ));

    if ($tmhOAuth->response["code"] == 200) {

        // get the access token and store it in a cookie

        $response = $tmhOAuth->extract_params($tmhOAuth->response["response"]);

        if (verify_access_token($response["oauth_token"], $response["oauth_token_secret"])) {

            require_once TC_PLUGIN_PATH . 'includes/user.php';

            save_user_tokens($response["oauth_token"], $response["oauth_token_secret"]);

            set_user_twitter_account(get_username_via_api(get_current_user_id(), $response["oauth_token"], $response["oauth_token_secret"]));

        }

        // redirect user to clear leftover GET variables

        header("Location: " . get_permalink(get_option('woocommerce_myaccount_page_id')));

        exit;

    }

    return false;

}

function verify_access_token($oauth_token, $oauth_token_secret)

{

    require_once TC_PLUGIN_PATH . 'libs/oauth/tmhOAuth.php';

    $tmhOAuth = new tmhOAuth(array(

        'consumer_key' => get_option('tc_twitter_api_key'),

        'consumer_secret' => get_option('tc_twitter_api_secret'),

    ));

    $tmhOAuth->config["user_token"] = $oauth_token;

    $tmhOAuth->config["user_secret"] = $oauth_token_secret;

    // send verification request to test access key

    $tmhOAuth->request("GET", $tmhOAuth->url("1.1/account/verify_credentials"));

    // HTTP 200 means we were successful

    return ($tmhOAuth->response["code"] == 200);

}

function tc_added_to_wishlist($status_id)

{

    global $wpdb;

    $tablename = $wpdb->prefix . "tc_twitter_wishlist";

    $sql = "SELECT status FROM $tablename WHERE twitter_status_id = '$status_id'";

    $result = $wpdb->get_var($sql);

    if ($result == 'active') {

        return TRUE;

    }

    return FALSE;

}

function get_add_hashtags()

{

    global $wpdb;

    $hashtags = array();

    //Get system hashtag

    $add_to_cart_hashtag = get_option('tc_twitter_hashtag');

    $tablename = $wpdb->prefix . "tc_user_hashtags";

    $sql = "SELECT hashtag FROM $tablename";

    $res = $wpdb->get_results($sql);

    foreach ($res as $single) {

        if ($single->hashtag != "") {

            $hashtags[] = $single->hashtag;

        }

    }

    $hashtags[] = $add_to_cart_hashtag;

    return $hashtags;

}

function get_wl_hashtags()

{

    global $wpdb;

    $hashtags = array();

    //Get system hashtag

    $wl_hashtag = get_option('tc_wishlist_hashtag');

    $tablename = $wpdb->prefix . "tc_user_hashtags";

    $sql = "SELECT wishlist_hashtag FROM $tablename";

    $res = $wpdb->get_results($sql);

    foreach ($res as $single) {

        if ($single->wishlist_hashtag != "") {

            $hashtags[] = $single->wishlist_hashtag;

        }

    }

    $hashtags[] = $wl_hashtag;

    return $hashtags;

}