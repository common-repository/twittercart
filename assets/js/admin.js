var fileSelected = false;
var updateffFollowers_runing=false;
var following_status=false;
var ajax_status="Followers";
var dv_licount=0;
var ff_user_ids =[];
var NFB_dv_licount=0;
var NFB_ff_user_ids =[];
var NFB_updateffFollowers_runing=false;
var tcGetfollowing_all_ff=false;
var followingajaxidle = true;
var followersajaxidle = true;
function updateAdminOptions() {
    var apiKey = jQuery("#twt_api_key").val();
    var apiSecret = jQuery("#twt_api_sec").val();
    var accessToken = jQuery("#acc_tok").val();
    var accessTokenSecret = jQuery("#acc_tok_sec").val();
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
function tcGetTimeline(productid) {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    window.followingCursor = 0;
    window.followersCursor = 0;
    window.timelineMinCursor = 0;
    jQuery(".active").removeClass('active');
    jQuery(".tchometimeline").addClass('active');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_timeline"
        , type: 'post'
        , dataType: 'json'
        , data: {porduct: productid}
        , beforeSend: function() {
            jQuery('.tc_main_container').html("<div class=\"tcspinner\"><div class=\"rect1\"></div><div class=\"rect2\"></div><div class=\"rect3\"></div><div class=\"rect4\"></div><div class=\"rect5\"></div></div>");
        },
        success: function(res) {
            jQuery('.tc_main_container').html(res.html);
            jQuery('.tc_main_container').removeClass('following_container');
            window.timelineMinCursor = res.min;
        }
    });
}

function tcGetRetweets() {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    window.followingCursor = 0;
    window.followersCursor = 0;
    jQuery(".active").removeClass('active');
    jQuery(".tcgenerret").addClass('active');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_retweets"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            jQuery('.tc_main_container').html("<div class=\"tcspinner\"><div class=\"rect1\"></div><div class=\"rect2\"></div><div class=\"rect3\"></div><div class=\"rect4\"></div><div class=\"rect5\"></div></div>");
        },
        success: function(res) {
            jQuery('.tc_main_container').html(res);
            jQuery('.tc_main_container').removeClass('following_container');
        }
    });
}
function tcGetFollowers() {
	if(!followersajaxidle){
		return false;
	}
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery(".active").removeClass('active');
    jQuery(".tcgenerflwrs").addClass('active');
    window.followingCursor = 0;
    var data = '';
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_followers"
        , type: 'post'
        , dataType: 'json'
        , data: data
        , beforeSend: function() {
            jQuery('.tc_main_container').html("<div class=\"tcspinner\"><div class=\"rect1\"></div><div class=\"rect2\"></div><div class=\"rect3\"></div><div class=\"rect4\"></div><div class=\"rect5\"></div></div>");
			followersajaxidle = false;
        },
        success: function(res) {
            jQuery('.tc_main_container').addClass('following_container')
            jQuery('.tc_main_container').html(res.html);
			followersajaxidle = true;
            window.followersCursor = res.cursor;
        }
    });
}

function tcnewlockscroll(screen_name,ele,count)
{	
	first=jQuery("#tc_user_follow_button"+count).offset().top;
	if(jQuery("#tc_user_follow_button"+(parseInt(count)+1)).length>0)
	{
		second=jQuery("#tc_user_follow_button"+(parseInt(count)+1)).offset().top;
		third=second-first;
		jQuery('html,body').animate({scrollTop: (jQuery(window).scrollTop()+third)+"px"}, 1000);
	}
}
function lockuser(screen_name, lock)
{
	first=jQuery("#tc_user_locked_main"+lock).offset().top;
	if(jQuery("#tc_user_locked_main"+(parseInt(lock)+1)).length>0)
	{
		second=jQuery("#tc_user_locked_main"+(parseInt(lock)+1)).offset().top;
		third=second-first;
		jQuery('html,body').animate({scrollTop: (jQuery(window).scrollTop()+third)+"px"}, 1000);
	}
	
	jQuery("#user_loader"+lock).css("display","inline");
	var link_to_site = jQuery("collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_new_twitter_lock"
        , type: 'post'
        , dataType: 'json'
        ,  data:{name:screen_name},
        
        success: function(res) {
			jQuery("#user_loader"+lock).css("display","none");
			jQuery("#user_unlock"+lock).css("display","inline-block");
			jQuery("#user_lock"+lock).css("display","none");
			jQuery("#tc_user_follow_button"+lock).attr("onclick","tcnewlockscroll('"+screen_name+"', this,'"+lock+"')");
			
        }
    });
}

function tcopen_desc_popup(tcpost_desc)
{
	jQuery("#tcdescfadeout").css("display","block");
	jQuery("#tcshow_tcpost_desc").css("display","block");
	if(tcpost_desc!="")
	{
		jQuery("#tcshow_tcpost_desc").html('<div id="customer_order_popup_close" class="customer_order_popup_close" onclick="tcopen_desc_popup_close();" ><p>X</p></div><h1>Description</h1><p>'+tcpost_desc+'</p>');
	}
	else
	{
		jQuery("#tcshow_tcpost_desc").html('<div id="customer_order_popup_close" class="customer_order_popup_close" onclick="tcopen_desc_popup_close();" ><p>X</p></div><h1>Description</h1><p>No description found</p>');
	}
	
}
function tcopen_desc_popup_close()
{
	jQuery("#tcdescfadeout").css("display","none");
	jQuery("#tcshow_tcpost_desc").css("display","none");
	jQuery("#tcshow_tcpost_desc").html('');
	
}
function tcGetFollowing() {
	if(!followingajaxidle){
		return false;
	}
	
	
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery(".active").removeClass('active');
    jQuery(".tcgenerflwng").addClass('active');
    window.followersCursor = 0;
    //window.followingCursor = 0;
    var data = '';
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_following"
        , type: 'post'
        , dataType: 'json'
        , data: data
        , beforeSend: function() {
            jQuery('.tc_main_container').html("<div class=\"tcspinner\"><div class=\"rect1\"></div><div class=\"rect2\"></div><div class=\"rect3\"></div><div class=\"rect4\"></div><div class=\"rect5\"></div></div>");
			followingajaxidle = false;
        },
        success: function(res) {
            jQuery('.tc_main_container').addClass('following_container');
            jQuery('.tc_main_container').html(res.html);
            window.followingCursor = res.cursor;
			followingajaxidle = true;
        }
    });
}
function tcGetFavorite() {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery(".active").removeClass('active');
    jQuery(".tcgenerfvrt").addClass('active');
    window.followersCursor = 0;
    window.followingCursor = 0;
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_favorite"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            jQuery('.tc_main_container').html("<div class=\"tcspinner\"><div class=\"rect1\"></div><div class=\"rect2\"></div><div class=\"rect3\"></div><div class=\"rect4\"></div><div class=\"rect5\"></div></div>");
        },
        success: function(res) {
            jQuery('.tc_main_container').html(res.html);
            jQuery('.tc_main_container').removeClass('following_container');
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
                jQuery("#tc_retweet_" + id).css("background", "url('https://si0.twimg.com/images/dev/cms/intents/icons/retweet_on.png') 0 1px no-repeat");
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
    var link_to_img = jQuery("#collector").attr('image_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_admin_retweet_destroy"
        , type: 'post'
        , dataType: 'json'
        , data: {status_id: id}
        , beforeSend: function() {
        },
        success: function(res) {
            jQuery("#tc_retweet_" + status_id).css("background", "url('" + link_to_img + "opt02.png') 0 1px no-repeat");
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
            jQuery("#tc_favorite_" + id).css("background", "url('https://si0.twimg.com/images/dev/cms/intents/icons/favorite_on.png') 0 1px no-repeat");
            jQuery("#tc_favorite_" + id).attr("onclick", "tcAdminFavoriteDestroy('" + id + "');");
        }
    });
}
function tcAdminFavoriteDestroy(id) {
    var link_to_site = jQuery("#collector").attr('site_url');
    var link_to_img = jQuery("#collector").attr('image_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_admin_favorite_destroy"
        , type: 'post'
        , dataType: 'json'
        , data: {status_id: id}
        , beforeSend: function() {
        },
        success: function(res) {
            jQuery("#tc_favorite_" + id).css("background", "url('" + link_to_img + "opt03.png') 0 1px no-repeat");
            jQuery("#tc_favorite_" + id).attr("onclick", "tcAdminFavorite('" + id + "');");
        }
    });
}

function tcGetReplies() {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    window.followingCursor = 0;
    window.followersCursor = 0;
    jQuery(".active").removeClass('active');
    jQuery(".tcgenerrep").addClass('active');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_replies"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            jQuery('.tc_main_container').html("<div class=\"tcspinner\"><div class=\"rect1\"></div><div class=\"rect2\"></div><div class=\"rect3\"></div><div class=\"rect4\"></div><div class=\"rect5\"></div></div>");
        },
        success: function(res) {
            jQuery('.tc_main_container').html(res.html);
            jQuery('.tc_main_container').removeClass('following_container');
        }
    });
}
function tcGetMostReplied() {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery('.active').removeClass('active');
    jQuery('.mrpld').addClass('active');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_most_replied"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            //jQuery('#content').html("<p class='loader' style=\"height: 400px; margin-top: 0px;\"><img style=\"margin-top: 200px;\" src='" + preloader_src + "'></p>");
            jQuery('#content').css('background', 'transparent');
            jQuery('#content').html("<div class=\"tcspinner\"><div class=\"rect1\"></div><div class=\"rect2\"></div><div class=\"rect3\"></div><div class=\"rect4\"></div><div class=\"rect5\"></div></div>");
        },
        success: function(res) {
            jQuery('#content').css('background', 'white');
            jQuery('#content').html(res.content);
            jQuery('#gistogramma').html('');
            jQuery('forscript').html(res.chart);
        }
    });
}
function tcGetMostRetweeted() {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery('.active').removeClass('active');
    jQuery('.mrtwtd').addClass('active');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_twitter_most_retweeted"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            //jQuery('#content').html("<p class='loader' style=\"height: 400px; margin-top: 0px;\"><img style=\"margin-top: 200px;\" src='" + preloader_src + "'></p>");
            //jQuery('#content').css('background', 'transparent');
            jQuery('#content').css('background', 'transparent');
            jQuery('#content').html("<div class=\"tcspinner\"><div class=\"rect1\"></div><div class=\"rect2\"></div><div class=\"rect3\"></div><div class=\"rect4\"></div><div class=\"rect5\"></div></div>");
        },
        success: function(res) {
            jQuery('#content').css('background', 'white');
            jQuery('#content').html(res.main);
            jQuery('#gistogramma').html('');
            jQuery('forscript').html(res.chart);
        }
    });
}
function tcGetAuthorized() {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery('.active').removeClass('active');
    jQuery('.autusrs').addClass('active');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_authorized"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            jQuery('#content').css('background', 'transparent');
            jQuery('#content').html("<div class=\"tcspinner\"><div class=\"rect1\"></div><div class=\"rect2\"></div><div class=\"rect3\"></div><div class=\"rect4\"></div><div class=\"rect5\"></div></div>");
        },
        success: function(res) {
            jQuery('#content').css('background', 'white');
            jQuery('#content').html(res.main);
            jQuery('#gistogramma').html('');
            jQuery('forscript').html(res.chart);
        }
    });
}
function tcGetAuthorizedCustomers() {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery('.active').removeClass('active');
    jQuery('.autcst').addClass('active');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_authorized_customers"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            //jQuery('#content').html("<p class='loader' style=\"height: 400px; margin-top: 0px;\"><img style=\"margin-top: 200px;\" src='" + preloader_src + "'></p>");
            //jQuery('#content').css('background', 'transparent');
            jQuery('#content').css('background', 'transparent');
            jQuery('#content').html("<div class=\"tcspinner\"><div class=\"rect1\"></div><div class=\"rect2\"></div><div class=\"rect3\"></div><div class=\"rect4\"></div><div class=\"rect5\"></div></div>");
        },
        success: function(res) {
            jQuery('#content').css('background', 'white');
            jQuery('#content').html(res.main);
            jQuery('#gistogramma').html('');
            jQuery('forscript').html(res.chart);
			if(res==0)
			{
				jQuery('#content').html('<div class="retweets_head"><a href="javascript:;" onclick="tcGetAuthorized();"><img alt="" src="'+main_js_obj.tct_pluginurl+'/assets/images/f5.png"></a><p>Authorized User 0</p>          </div><div class="twt_container customers"><ul></ul></div>');
			}
        },
    });
}
function tcGetAuthorizedVendors() {
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery('.active').removeClass('active');
    jQuery('.autvnd').addClass('active');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_authorized_vendors"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
            //jQuery('#content').html("<p class='loader' style=\"height: 400px; margin-top: 0px;\"><img style=\"margin-top: 200px;\" src='" + preloader_src + "'></p>");
            //jQuery('#content').css('background', 'transparent');
            jQuery('#content').css('background', 'transparent');
            jQuery('#content').html("<div class=\"tcspinner\"><div class=\"rect1\"></div><div class=\"rect2\"></div><div class=\"rect3\"></div><div class=\"rect4\"></div><div class=\"rect5\"></div></div>");
        },
        success: function(res) {
            jQuery('#content').css('background', 'white');
            jQuery('#content').html(res.main);
            jQuery('#gistogramma').html('');
            jQuery('forscript').html(res.chart);
        }
    });
}
function tcDeactivateOauth() {
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery("#tclinkbutton").html("Link my twitter account");
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_deactivate_account"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
        },
        success: function(res) {
            alert("Your Twitter account was successfully deactivated!");
        }
    });
}
/**
 * Vendor functions
 */
function tcLinkOauthVendor() {
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_link_oauth_vendor"
        , type: 'post'
        , dataType: 'json'
        , data: ''
        , beforeSend: function() {
        },
        success: function(res) {
            newWin = window.open(res,
                    "Twitter OAuth",
                    "width=700,height=800,resizable=yes,scrollbars=yes,status=yes"
                    );
            newWin.focus();
            setTimeout(function() {
                if (newWin.closed) {
                    location.reload();
                } else {
                    setTimeout(arguments.callee, 10);
                }
            }, 10);
            //document.location = res;
        }
    });
}
function setSort(element, selector) {
    if (jQuery(element).hasClass('sorting_desc')) {
        jQuery('.sortable_img').css('display', 'none');
        jQuery('.sortable_img.both').css('display', 'inline');
        jQuery('img.' + selector + '.both').css('display', 'none');
        jQuery('img.' + selector + '.asc').css('display', 'inline');
        jQuery('img.' + selector + '.asc').css('position', 'absolute');
    } else if (jQuery(element).hasClass('sorting_asc')) {
        jQuery('.sortable_img').css('display', 'none');
        jQuery('.sortable_img.both').css('display', 'inline');
        jQuery('img.' + selector + '.both').css('display', 'none');
        jQuery('img.' + selector + '.desc').css('display', 'inline');
        jQuery('img.' + selector + '.desc').css('position', 'absolute');
    } else {
        jQuery('.sortable_img').css('display', 'none');
        jQuery('.sortable_img.both').css('display', 'inline');
        jQuery('img.' + selector + '.both').css('display', 'none');
        jQuery('img.' + selector + '.asc').css('display', 'inline');
        jQuery('img.' + selector + '.asc').css('position', 'absolute');
    }
    jQuery('.both').css('position', 'absolute');
}

function textareaChanged(textarea) {
    var contain = jQuery(textarea).val();
    var count = contain.length;
    if (fileSelected) {
        var left = 123 - count;
    } else {
        var left = 140 - count;
    }
    jQuery('.symbols').html(left);
    console.log(count);
}

function tweetSubmit(form) {
    var link_to_site = jQuery("collector").attr('site_url');
    var msg = jQuery('#whatsNew').val();
    var inreply = jQuery('#inreply').val();
    
    var form_data = new FormData();
    
    form_data.append('msg', msg);
    var hiddenid = jQuery("#hiddenid").val();
   if (hiddenid > 0) {
        postNewSend();
    }
    jQuery('#whatsNew').val(' ');
}
function postNew(title, price, link, element, id) {
    jQuery("#sendedres").css('display', 'none');
    jQuery(".hideforres").css('display', 'block');
    var prepost = title + " - " + price + "  \r\n\ " + link + "\r\n#" + main_js_obj.tccarthashtag;
    jQuery("#whatsNew").html(prepost);
    jQuery("#whatsNew").val(prepost);
    jQuery("#hiddenid").val(id);
    jQuery("#productAttachCheck").css('display', 'inline');
    jQuery("#productAttach").css('checked', 'true');
	
	jQuery("#tc_hashtag_attach").css('display', 'inline');
    jQuery("#tc_hashtag_attach_check").prop('checked', true);
	
	jQuery("#tc_wlhashtag_attach").css('display', 'inline');
    jQuery("#tc_wlhashtag_attach_check").css('checked', 'true');
    jQuery("#whatsNew").focus();
}
function postNewSend() {
    var link_to_site = jQuery("collector").attr('site_url');
    var preloader_src = jQuery("#collector").attr('preloader_src');
    var status_text = jQuery("#whatsNew").val();
    var product_id = jQuery("#hiddenid").val();
    /*var attach_image = jQuery("#productAttach").val();*/
	var attach_image;
	attach_image = 'off';
	if( jQuery("#productAttach").prop('checked') ){
		attach_image = 'on';
	}
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_post_product_account"
        , type: 'post'
        , dataType: 'json'
        , data: {message: status_text, product: product_id, attach: attach_image,tc_secure_field: jQuery("#tc_product_post_nonce_field").val()}
        , beforeSend: function() {
        },
        success: function(res) {
            alertify.alert(res);
            jQuery("#productAttachCheck").css('display', 'none');
            jQuery("#whatsNew").html('');
            jQuery("#hiddenid").val('0');
			jQuery("#tc_hashtag_attach").hide();
			jQuery("#tc_wlhashtag_attach").hide();
			jQuery("#tc_wlhashtag_attach").hide();
			jQuery("#tc_wlhashtag_attach_check").prop("checked", false);
        }
    });
}

function reloc(location) {
    window.location = location;
}

function showTrashAct(fid) {
    var ident = '#mid' + fid + ' .trashpan';
    jQuery(ident).css('display', 'block');
}
function cleanDisplayShow() {
    jQuery('.trashpan').css('display', 'none');
}
function delThisMessage(fid) {
    var ident = '#mid' + fid;
    jQuery(ident).remove();
    var link_to_site = jQuery("collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_dm_delete"
        , type: 'post'
        , dataType: 'json'
        , data: {id: fid}
        , beforeSend: function() {
        },
        success: function(res) {
        }
    });
}

function setBothSort(element, classname) {
    if (!(jQuery(element).hasClass('sorting_desc') || jQuery(element).hasClass('sorting_asc'))) {
        var selector = 'img.' + classname;
        jQuery(selector).css('display', 'none');
        var currentselector = 'th.' + classname + ' .allhover';
        jQuery(currentselector).css('display', 'inline');
        console.log(currentselector);
    }
}
function setReturnedSort(element, classname) {
    if (!(jQuery(element).hasClass('sorting_desc') || jQuery(element).hasClass('sorting_asc'))) {
        var selector = 'th.' + classname + ' img';
        jQuery(selector).css('display', 'none');
        var currentselector = 'th.' + classname + ' .both';
        jQuery(currentselector).css('display', 'inline');
        console.log(currentselector);
    }
}

function updateffFollowers() {
	
	if(!updateffFollowers_runing)
	{
		
		updateffFollowers_runing=true;
		if (window.followersCursor > 0 && ajax_status=="Followers") {
			jQuery(".tc_loader_spin").css("display","block");
			var link_to_site = jQuery("#collector").attr('site_url');
			data = {cursor: window.followersCursor,count:dv_licount,tcff_user_ids:ff_user_ids};
			jQuery.ajax({
				url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_new_twitter_ff"
				, type: 'post'
				, dataType: 'json'
				, data: data
				, beforeSend: function() {
				},
				success: function(res) {
					if(res.cursor==null && res.html=="")
					{ 
						updateffFollowers_runing=false;
						jQuery(".tc_loader_spin").css("display","none");
						jQuery(".tc_limit_exceeded").css("display","block");
					}
					else
					{
						jQuery('.flwrscnt_new_followers').append(res.html);
						window.followersCursor = res.cursor;
						dv_licount=res.dv_licount;
						updateffFollowers_runing=false;
						jQuery(".tc_loader_spin").css("display","none");
						ff_user_ids=(res.ff_user_ids);
						jQuery(".tc_limit_exceeded").css("display","none");
					}
				}
			});
		}
		else
		{
			ajax_status="following";
			if ((window.followersCursor == 0 && !following_status) || window.followersCursor > 0) {
				jQuery(".tc_loader_spin").css("display","block");
				data ={count:dv_licount,tcff_user_ids:ff_user_ids};
				if(window.followersCursor>0)
				{
					data = {cursor: window.followersCursor,count:dv_licount,tcff_user_ids:ff_user_ids};
				}
				
				var link_to_site = jQuery("#collector").attr('site_url');
				
				jQuery.ajax({
					url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_get_new_twitter_ff_following"
					, type: 'post'
					, dataType: 'json'
					, data: data
					, beforeSend: function() {
					},
					success: function(res) {
						jQuery('.flwrscnt_new_followers').append(res.html);
						window.followersCursor = res.cursor;
						dv_licount=res.dv_licount;
						updateffFollowers_runing=false;
						following_status=true;
						jQuery(".tc_loader_spin").css("display","none");
					}
				});
			}
		}
	}
}
/*---New function end---*/
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
    jQuery("#tc-following").click(function() {
        tcGetFollowing();
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
    jQuery("#tc-authorized").click(function() {
        tcGetAuthorized();
    });
    jQuery("#tc-authorized-customers").click(function() {
        tcGetAuthorizedCustomers();
    });
    jQuery("#tc-authorized-vendors").click(function() {
        tcGetAuthorizedVendors();
    });
    function product_table() {
        if (jQuery(window).width() <= 768) {
            var tab_width = jQuery('#mytcdfui').width();
            jQuery('#products tbody > tr').css('width', tab_width)
        }
    }
    product_table();
    jQuery(window).resize(function() {
        product_table();
    })
    var tcStatusId = '0';
    var tcUserName = '0';
    var outboxInterval = 0;
    var followingCursor = 0;
    var followersCursor = 0;
    var timelineMinCursor = -1;
    var timelineUserCursor = -1;
    var menu_nav = jQuery('.nav_bar>nav>ul>li');
    var menu_head = jQuery('#header>ul>li');
    function colors(menu1, menu2, r_bord1, r_bord2) {
        menu1.children('a').hover(function() {
            var num = jQuery(this).parent().index();
            menu2.eq(num).children('a').css({'background-color': '#26b8ea', 'border-bottom-color': '#1da4d2', 'border-right-color': r_bord1})
        }, function() {
            var num = jQuery(this).parent().index();
            menu2.eq(num).children('a').css({'background-color': '#727b88', 'border-bottom-color': '#606874', 'border-right-color': r_bord2})
        })
    }
    colors(menu_nav, menu_head, '#527c92', '#606874');
    colors(menu_head, menu_nav);
    jQuery(".user_about").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "rounded"
    });
    jQuery("#products_filter>label").css('width', '80px');
    jQuery("#products_filter>label input").css('width', '120px');
    jQuery("#products_filter>label input").css('height', '35px');
    jQuery("#products_filter>label input").css('margin', '0');
    jQuery("#products_filter>label input").css('margin-left', '10px');
    jQuery("#products_filter>label input").after("<div class=\"searchboxtc\"></div>");
    jQuery('.nav_bar').scrollToFixed({marginTop: 40});
});
(function(a) {
    a.isScrollToFixed = function(b) {
        return !!a(b).data("ScrollToFixed")
    };
    a.ScrollToFixed = function(d, i) {
        var l = this;
        l.$el = a(d);
        l.el = d;
        l.$el.data("ScrollToFixed", l);
        var c = false;
        var G = l.$el;
        var H;
        var E;
        var e;
        var y;
        var D = 0;
        var q = 0;
        var j = -1;
        var f = -1;
        var t = null;
        var z;
        var g;
        function u() {
            G.trigger("preUnfixed.ScrollToFixed");
            k();
            G.trigger("unfixed.ScrollToFixed");
            f = -1;
            D = G.offset().top;
            q = G.offset().left;
            if (l.options.offsets) {
                q += (G.offset().left - G.position().left)
            }
            if (j == -1) {
                j = q
            }
            H = G.css("position");
            c = true;
            if (l.options.bottom != -1) {
                G.trigger("preFixed.ScrollToFixed");
                w();
                G.trigger("fixed.ScrollToFixed")
            }
        }
        function n() {
            var I = l.options.limit;
            if (!I) {
                return 0
            }
            if (typeof (I) === "function") {
                return I.apply(G)
            }
            return I
        }
        function p() {
            return H === "fixed"
        }
        function x() {
            return H === "absolute"
        }
        function h() {
            return !(p() || x())
        }
        function w() {
            if (!p()) {
                t.css({display: G.css("display"), width: G.outerWidth(true), height: G.outerHeight(true), "float": G.css("float")});
                cssOptions = {"z-index": l.options.zIndex, position: "fixed", top: l.options.bottom == -1 ? s() : "", bottom: l.options.bottom == -1 ? "" : l.options.bottom, "margin-left": "0px"};
                if (!l.options.dontSetWidth) {
                    cssOptions.width = G.width()
                }
                G.css(cssOptions);
                G.addClass(l.options.baseClassName);
                if (l.options.className) {
                    G.addClass(l.options.className)
                }
                H = "fixed"
            }
        }
        function b() {
            var J = n();
            var I = q;
            if (l.options.removeOffsets) {
                I = "";
                J = J - D
            }
            cssOptions = {position: "absolute", top: J, left: I, "margin-left": "0px", bottom: ""};
            if (!l.options.dontSetWidth) {
                cssOptions.width = G.width()
            }
            G.css(cssOptions);
            H = "absolute"
        }
        function k() {
            if (!h()) {
                f = -1;
                t.css("display", "none");
                G.css({"z-index": y, width: "", position: E, left: "", top: e, "margin-left": ""});
                G.removeClass("scroll-to-fixed-fixed");
                if (l.options.className) {
                    G.removeClass(l.options.className)
                }
                H = null
            }
        }
        function v(I) {
            if (I != f) {
                G.css("left", q - I);
                f = I
            }
        }
        function s() {
            var I = l.options.marginTop;
            if (!I) {
                return 0
            }
            if (typeof (I) === "function") {
                return I.apply(G)
            }
            return I
        }
        function A() {
            if (!a.isScrollToFixed(G)) {
                return
            }
            var K = c;
            if (!c) {
                u()
            } else {
                if (h()) {
                    D = G.offset().top;
                    q = G.offset().left
                }
            }
            var I = a(window).scrollLeft();
            var L = a(window).scrollTop();
            var J = n();
            if (l.options.minWidth && a(window).width() < l.options.minWidth) {
                if (!h() || !K) {
                    o();
                    G.trigger("preUnfixed.ScrollToFixed");
                    k();
                    G.trigger("unfixed.ScrollToFixed")
                }
            } else {
                if (l.options.maxWidth && a(window).width() > l.options.maxWidth) {
                    if (!h() || !K) {
                        o();
                        G.trigger("preUnfixed.ScrollToFixed");
                        k();
                        G.trigger("unfixed.ScrollToFixed")
                    }
                } else {
                    if (l.options.bottom == -1) {
                        if (J > 0 && L >= J - s()) {
                            if (!x() || !K) {
                                o();
                                G.trigger("preAbsolute.ScrollToFixed");
                                b();
                                G.trigger("unfixed.ScrollToFixed")
                            }
                        } else {
                            if (L >= D - s()) {
                                if (!p() || !K) {
                                    o();
                                    G.trigger("preFixed.ScrollToFixed");
                                    w();
                                    f = -1;
                                    G.trigger("fixed.ScrollToFixed")
                                }
                                v(I)
                            } else {
                                if (!h() || !K) {
                                    o();
                                    G.trigger("preUnfixed.ScrollToFixed");
                                    k();
                                    G.trigger("unfixed.ScrollToFixed")
                                }
                            }
                        }
                    } else {
                        if (J > 0) {
                            if (L + a(window).height() - G.outerHeight(true) >= J - (s() || -m())) {
                                if (p()) {
                                    o();
                                    G.trigger("preUnfixed.ScrollToFixed");
                                    if (E === "absolute") {
                                        b()
                                    } else {
                                        k()
                                    }
                                    G.trigger("unfixed.ScrollToFixed")
                                }
                            } else {
                                if (!p()) {
                                    o();
                                    G.trigger("preFixed.ScrollToFixed");
                                    w()
                                }
                                v(I);
                                G.trigger("fixed.ScrollToFixed")
                            }
                        } else {
                            v(I)
                        }
                    }
                }
            }
        }
        function m() {
            if (!l.options.bottom) {
                return 0
            }
            return l.options.bottom
        }
        function o() {
            var I = G.css("position");
            if (I == "absolute") {
                G.trigger("postAbsolute.ScrollToFixed")
            } else {
                if (I == "fixed") {
                    G.trigger("postFixed.ScrollToFixed")
                } else {
                    G.trigger("postUnfixed.ScrollToFixed")
                }
            }
        }
        var C = function(I) {
            if (G.is(":visible")) {
                c = false;
                A()
            }
        };
        var F = function(I) {
            (!!window.requestAnimationFrame) ? requestAnimationFrame(A) : A()
        };
        var B = function() {
            var J = document.body;
            if (document.createElement && J && J.appendChild && J.removeChild) {
                var L = document.createElement("div");
                if (!L.getBoundingClientRect) {
                    return null
                }
                L.innerHTML = "x";
                L.style.cssText = "position:fixed;top:100px;";
                J.appendChild(L);
                var M = J.style.height, N = J.scrollTop;
                J.style.height = "3000px";
                J.scrollTop = 500;
                var I = L.getBoundingClientRect().top;
                J.style.height = M;
                var K = (I === 100);
                J.removeChild(L);
                J.scrollTop = N;
                return K
            }
            return null
        };
        var r = function(I) {
            I = I || window.event;
            if (I.preventDefault) {
                I.preventDefault()
            }
            I.returnValue = false
        };
        l.init = function() {
            l.options = a.extend({}, a.ScrollToFixed.defaultOptions, i);
            y = G.css("z-index");
            l.$el.css("z-index", l.options.zIndex);
            t = a("<div />");
            H = G.css("position");
            E = G.css("position");
            e = G.css("top");
            if (h()) {
                l.$el.after(t)
            }
            a(window).bind("resize.ScrollToFixed", C);
            a(window).bind("scroll.ScrollToFixed", F);
            if ("ontouchmove" in window) {
                a(window).bind("touchmove.ScrollToFixed", A)
            }
            if (l.options.preFixed) {
                G.bind("preFixed.ScrollToFixed", l.options.preFixed)
            }
            if (l.options.postFixed) {
                G.bind("postFixed.ScrollToFixed", l.options.postFixed)
            }
            if (l.options.preUnfixed) {
                G.bind("preUnfixed.ScrollToFixed", l.options.preUnfixed)
            }
            if (l.options.postUnfixed) {
                G.bind("postUnfixed.ScrollToFixed", l.options.postUnfixed)
            }
            if (l.options.preAbsolute) {
                G.bind("preAbsolute.ScrollToFixed", l.options.preAbsolute)
            }
            if (l.options.postAbsolute) {
                G.bind("postAbsolute.ScrollToFixed", l.options.postAbsolute)
            }
            if (l.options.fixed) {
                G.bind("fixed.ScrollToFixed", l.options.fixed)
            }
            if (l.options.unfixed) {
                G.bind("unfixed.ScrollToFixed", l.options.unfixed)
            }
            if (l.options.spacerClass) {
                t.addClass(l.options.spacerClass)
            }
            G.bind("resize.ScrollToFixed", function() {
                t.height(G.height())
            });
            G.bind("scroll.ScrollToFixed", function() {
                G.trigger("preUnfixed.ScrollToFixed");
                k();
                G.trigger("unfixed.ScrollToFixed");
                A()
            });
            G.bind("detach.ScrollToFixed", function(I) {
                r(I);
                G.trigger("preUnfixed.ScrollToFixed");
                k();
                G.trigger("unfixed.ScrollToFixed");
                a(window).unbind("resize.ScrollToFixed", C);
                a(window).unbind("scroll.ScrollToFixed", F);
                G.unbind(".ScrollToFixed");
                t.remove();
                l.$el.removeData("ScrollToFixed")
            });
            C()
        };
        l.init()
    };
    a.ScrollToFixed.defaultOptions = {marginTop: 0, limit: 0, bottom: -1, zIndex: 1000, baseClassName: "scroll-to-fixed-fixed"};
    a.fn.scrollToFixed = function(b) {
        return this.each(function() {
            (new a.ScrollToFixed(this, b))
        })
    }
})(jQuery);
jQuery(document).ready(function($){
	
	var ori_li_color = "";
	
	$(document).on("click","#tc_hashtag_attach_check", function(){
		var tweet_str = $("#whatsNew").val();
		var tc_carthashtag = "#"+main_js_obj.tccarthashtag;
		var regex = new RegExp(tc_carthashtag, 'gi');
		
		if( $(this).prop("checked") ){
			
			tweet_str = $.trim(tweet_str) + '\r\n' + tc_carthashtag + " ";
			$("#whatsNew").val(tweet_str);
			
		} else {
			
			tweet_str = tweet_str.replace(regex, '');
			$("#whatsNew").val(tweet_str);
			
		}
	});
	
	
	
	$(document).on("click","#tc_wlhashtag_attach_check", function(){
		var tweet_str = $("#whatsNew").val();
		var tc_wlhashtag = "#"+main_js_obj.tcwlhashtag;
		var regex = new RegExp(tc_wlhashtag, 'gi');
		
		if( $(this).prop("checked") ){
			
			tweet_str = $.trim(tweet_str) + '\r\n' + tc_wlhashtag + " ";
			$("#whatsNew").val(tweet_str);
			
		} else {
			
			tweet_str = tweet_str.replace(regex, '');
			$("#whatsNew").val(tweet_str);
			
		}
	});
	
	
	/* twitter profile link, tweet link, start */
	$(document).on("mouseover", ".tctw_tweets_avtimg", function(){ tc_do_link($(this)); });
	$(document).on("mouseout", ".tctw_tweets_avtimg", function(){ tc_do_unlink($(this)); });
	$(document).on("mouseover", ".tctw_tweets_user_name", function(){ tc_do_link($(this)); });
	$(document).on("mouseout", ".tctw_tweets_user_name", function(){ tc_do_unlink($(this)); });
	$(document).on("mouseover", ".tctw_tweets_user_twtname", function(){ tc_do_link($(this)); });
	$(document).on("mouseout", ".tctw_tweets_user_twtname", function(){ tc_do_unlink($(this)); });
	
	
	$(document).on("click", ".tctw_tweets_avtimg", function(event){ event.stopPropagation(); tc_trigger_click($(this)); });
	$(document).on("click", ".tctw_tweets_user_name", function(event){ event.stopPropagation(); tc_trigger_click($(this)); });
	$(document).on("click", ".tctw_tweets_user_twtname", function(event){ event.stopPropagation(); tc_trigger_click($(this)); });
	$(document).on("click", ".tct_curi", function(event){ event.stopPropagation(); });
	
	$(document).on('mouseover', '.tctw_tweets_li', function(){ tc_do_tweetbacground_color($(this)); });
	$(document).on('mouseout', '.tctw_tweets_li', function(){ tc_do_tweetbacground_restorecolor($(this)); });
	$(document).on('click', '.tctw_tweets_li', function(event){ event.stopPropagation(); tc_trigger_click_list_tweet($(this)); });
	
	function tc_do_link(e){
		var user_tweeter_profile_user_name = e.parents('li').find(".tctw_tweets_user_name");
		user_tweeter_profile_user_name.css('text-decoration','underline');
		e.css('cursor','pointer');
	}
	
	function tc_do_unlink(e){
		var user_tweeter_profile_user_name = e.parents('li').find(".tctw_tweets_user_name");
		user_tweeter_profile_user_name.css('text-decoration','none');
	}
	
	function tc_trigger_click(e){
		var user_tweeter_profile = e.attr("data-user-tweeter-profile");
		e.css('cursor','pointer');
		window.open(user_tweeter_profile, "_blank");
	}
	
	function tc_do_tweetbacground_color(e){
		ori_li_color = e.css('background-color');
		e.css('background-color','#e6ecf0');
		e.css('cursor','pointer');
	}
	
	function tc_do_tweetbacground_restorecolor(e){
		e.css('background-color',ori_li_color);
	}
	
	function tc_trigger_click_list_tweet(e){
		
		var tweet_status_url = e.attr("data-tweet-status-url");
		window.open(tweet_status_url, "_blank");
	}
	/* twitter profile link, tweet link, end */
	
});