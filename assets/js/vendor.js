function updateAdminOptions() {
    var apiKey = jQuery("#api_key").val();
    var apiSecret = jQuery("#api_secret").val();
    var accessToken = jQuery("#access_token").val();
    var accessTokenSecret = jQuery("#access_token_secret").val();
    if (apiKey == '' || apiSecret == '' || accessToken == '' || accessTokenSecret == '') {
        alert('All fields is required!');
    } else {
        jQuery("#optionsform").submit();
    }
}
function saveVendorOptions() {
    var hashtag = jQuery("#hashtag").val();
    if (hashtag == '') {
        alert('All fields is required!');
    } else {
        jQuery("#optionsform").submit();
    }
}
function tcGetTimeline() {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_timeline"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            jQuery('#stats-rightcontent').html("<p class='loader'><img src='" + preloader_src + "'></p>");
        },
        success: function(res) {
            jQuery('#stats-rightcontent').html(res);
        }
    });
}
function tcGetRetweets() {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_retweets"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            jQuery('#stats-rightcontent').html("<p class='loader'><img src='" + preloader_src + "'></p>");
        },
        success: function(res) {
            jQuery('#stats-rightcontent').html(res);
        }
    });
}
function tcGetFollowers() {
	if(!followersajaxidle){
		return false;
	}
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_followers"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            jQuery('#stats-rightcontent').html("<p class='loader'><img src='" + preloader_src + "'></p>");
			followersajaxidle = false;
        },
        success: function(res) {
            jQuery('#stats-rightcontent').html(res);
			followersajaxidle = true;
        }
    });
}
function tcGetFavorite() {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_favorite"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            jQuery('#stats-rightcontent').html("<p class='loader'><img src='" + preloader_src + "'></p>");
        },
        success: function(res) {
            jQuery('#stats-rightcontent').html(res);
        }
    });
}
function tcAdminRetweet(id) {
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_admin_retweet"
        , type: 'post'
        , dataType: 'json'
        , data: {status_id: id}
        , beforeSend: function() {
        },
        success: function(res) {
            if (res) {
                jQuery("#tc_retweet_" + id).css("background", "url('https://si0.twimg.com/images/dev/cms/intents/icons/retweet_on.png') no-repeat center");
                jQuery("#tc_retweet_" + id).attr("retweet_id", res);
                jQuery("#tc_retweet_" + id).attr("onclick", "tcAdminRetweetDestroy('" + res + "', '" + id + "');");
            } else {
                alert("Some error! Try again later.");
            }
        }
    });
}
function tcAdminRetweetDestroy(id, status_id) {
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_admin_retweet_destroy"
        , type: 'post'
        , dataType: 'json'
        , data: {status_id: id}
        , beforeSend: function() {
        },
        success: function(res) {
            jQuery("#tc_retweet_" + status_id).css("background", "url('https://si0.twimg.com/images/dev/cms/intents/icons/retweet_hover.png') no-repeat center");
            jQuery("#tc_retweet_" + status_id).attr("onclick", "tcAdminRetweet('" + status_id + "');");
        }
    });
}
function tcAdminReply(status_id, user_name, user_id) {
    jQuery("#stats-rightreply").css('display', 'block');
    jQuery("replyuser").html(user_name);
    jQuery("#reply_msg").val('@' + user_name + ' ');
    jQuery("#reply_status").css('display', 'none');
    tcStatusId = status_id;
}
function tcAdminFavorite(id) {
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_admin_favorite"
        , type: 'post'
        , dataType: 'json'
        , data: {status_id: id}
        , beforeSend: function() {
        },
        success: function(res) {
            jQuery("#tc_favorite_" + id).css("background", "url('https://si0.twimg.com/images/dev/cms/intents/icons/favorite_on.png') no-repeat center");
            jQuery("#tc_favorite_" + id).attr("onclick", "tcAdminFavoriteDestroy('" + id + "');");
        }
    });
}
function tcAdminFavoriteDestroy(id) {
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_admin_favorite_destroy"
        , type: 'post'
        , dataType: 'json'
        , data: {status_id: id}
        , beforeSend: function() {
        },
        success: function(res) {
            jQuery("#tc_favorite_" + id).css("background", "url('https://si0.twimg.com/images/dev/cms/intents/icons/favorite_hover.png') no-repeat center");
            jQuery("#tc_favorite_" + id).attr("onclick", "tcAdminFavorite('" + id + "');");
        }
    });
}
function tcReply() {
    var link_to_site = jQuery("#collector").attr('site_url');
    var reply_msg = jQuery("#reply_msg").val();
    jQuery("#reply_status").css("color", "blue");
    jQuery("#reply_status").html("Sending reply...");
    jQuery("#reply_status").css('display', 'block');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_admin_reply"
        , type: 'post'
        , dataType: 'json'
        , data: {status_id: tcStatusId, reply_msg: reply_msg}
        , beforeSend: function() {
        },
        success: function(res) {
            if (res) {
                jQuery("#reply_status").css("color", "green");
                jQuery("#reply_status").html("Success!");
                setTimeout(function() {
                    jQuery("#stats-rightreply").fadeOut(600);
                }, 800);
            } else {
                jQuery("#reply_status").css("color", "red");
                jQuery("#reply_status").html("Some error! Try again later.");
                setTimeout(function() {
                    jQuery("#stats-rightreply").fadeOut(600);
                }, 5000);
            }
        }
    });
}
function tcDirectMessage(user_id, user_name) {
    jQuery("#stats-rightmessage").css('display', 'block');
    jQuery("directuser").html(user_name);
    jQuery("#direct_status").css('display', 'none');
    jQuery("#direct_msg").val(' ');
    tcUserName = user_name;
}
function tcDirect() {
    var link_to_site = jQuery("#collector").attr('site_url');
    var direct_msg = jQuery("#direct_msg").val();
    jQuery("#direct_status").css("color", "blue");
    jQuery("#direct_status").html("Sending message...");
    jQuery("#direct_status").css('display', 'block');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_admin_directmessage"
        , type: 'post'
        , dataType: 'json'
        , data: {user: tcUserName, direct_msg: direct_msg}
        , beforeSend: function() {
        },
        success: function(res) {
            if (res) {
                jQuery("#direct_status").css("color", "green");
                jQuery("#direct_status").html("Success!");
                setTimeout(function() {
                    jQuery("#stats-rightmessage").fadeOut(600);
                }, 800);
            } else {
                jQuery("#direct_status").css("color", "red");
                jQuery("#direct_status").html("Some error! Try again later.");
                setTimeout(function() {
                    jQuery("#stats-rightmessage").fadeOut(600);
                }, 5000);
            }
        }
    });
}
function tcGetReplies() {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_replies"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            jQuery('#stats-rightcontent').html("<p class='loader'><img src='" + preloader_src + "'></p>");
        },
        success: function(res) {
            jQuery('#stats-rightcontent').html(res);
        }
    });
}
function tcGetOutbox() {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_outbox"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            jQuery('#stats-rightcontent').html("<p class='loader'><img src='" + preloader_src + "'></p>");
        },
        success: function(res) {
            jQuery('#stats-rightcontent').html(res);
        }
    });
}
function tcGetMostReplied() {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_most_replied"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            jQuery('#stats-rightcontent').html("<p class='loader'><img src='" + preloader_src + "'></p>");
        },
        success: function(res) {
            jQuery('#stats-rightcontent').html(res.content);
        }
    });
}
function tcGetMostRetweeted() {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_most_retweeted"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            jQuery('#stats-rightcontent').html("<p class='loader'><img src='" + preloader_src + "'></p>");
        },
        success: function(res) {
            jQuery('#stats-rightcontent').html(res);
        }
    });
}
/**
 * Vendor functions
 */
function tcLinkOauthVendor() {
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_link_oauth"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
        },
        success: function(res) {
            document.location = res;
        }
    });
}
jQuery(document).ready(function() {
    jQuery("#tc-home-timeline").click(function() {
        tcGetTimeline();
    });
    jQuery("#tc-replies").click(function() {
        tcGetReplies();
    });
    jQuery("#tc-retweets").click(function() {
        tcGetRetweets();
    });
    jQuery("#tc-followers").click(function() {
        tcGetFollowers();
    });
   
    jQuery("#tc-outbox").click(function() {
        tcGetOutbox();
    });
    jQuery("#tc-favorite").click(function() {
        tcGetFavorite();
    });
    jQuery("#tc-most-replied").click(function() {
        tcGetMostReplied();
    });
    jQuery("#tc-most-retweeted").click(function() {
        tcGetMostRetweeted();
    });
    var tcStatusId = '0';
    var tcUserName = '0';
    //tcGetTimeline();
});