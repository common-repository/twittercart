<?php
defined('ABSPATH') or die('Access denied!');
$page = "<div style=\"width: 600px;\">";
$page .= "<h3>".__('TwitterCart', 'twittercart')."</h3>";
if (isset($_SESSION['tc_binded']) && $_SESSION['tc_binded'] ) {
    $_SESSION['tc_binded'] = FALSE;
    $page .= "
        <collector id=\"collector\" style=\"display: none;\" preloader_src=\"" . TC_IMG_URL . "712.GIF\" site_url=\"" . BASE_SITE_URL . "\"></collector>
        <br />
    ";
	wp_nonce_field( 'nonce_tc_link_auth_nonce_field', 'tc_link_auth_nonce_field' );
    $page .= "
        <b id=\"tcuseraccount\">@$user_twitter</b>&nbsp;<button type=\"button\" id=\"tclinkbutton\" onclick=\"tcLinkOauth();\">".__('Change account', 'twittercart')."</button>&nbsp;&nbsp;&nbsp;<button type=\"button\" id=\"tcdeactivatebutton\" onclick=\"tcDeactivateOauth();\">".__('Deactivate my account', 'twittercart')."</button>
        <script>alertify.alert(\"Your Twitter account was successfully enabled to TwitterCart!\");</script>
    ";
} else {
    $page .= "
        <collector id=\"collector\" style=\"display: none;\" preloader_src=\"" . TC_IMG_URL . "712.GIF\" site_url=\"" . BASE_SITE_URL . "\"></collector>
        <br />
    ";
    if (empty($user_twitter)) {
		wp_nonce_field( 'nonce_tc_link_auth_nonce_field', 'tc_link_auth_nonce_field' );
        $page .= "
        <button type=\"button\" id=\"tclinkbutton\" onclick=\"tcLinkOauth();\">".__('Link my twitter account', 'twittercart')."</button>";
    } else {
		wp_nonce_field( 'nonce_tc_link_auth_nonce_field', 'tc_link_auth_nonce_field' );
        $page .= "
        <b id=\"tcuseraccount\">@$user_twitter</b>&nbsp;<button type=\"button\" id=\"tclinkbutton\" onclick=\"tcLinkOauth();\">".__('Change account', 'twittercart')."</button>&nbsp;&nbsp;&nbsp;<button type=\"button\" id=\"tcdeactivatebutton\" onclick=\"tcDeactivateOauth();\">".__('Deactivate my account', 'twittercart')."</button>
    ";
    }
}
$page .= "</div>";
if (!empty($user_twitter)) {
    //Twitter Account functions
    $page .= "
    
    <script>
    if(window.opener != null){
";
    if (isset($myflag) && $myflag == 'binded'){
        $page .= "
            window.opener.successoauth = 'yes';
            window.opener.focus();
            window.close();
        ";
    }else{
        $page .= "
            window.opener.successoauth = 'no'; 
            window.opener.focus();
            window.close();
        ";
    }
$page .= "        
    }
    </script>
";
}
return $page;
