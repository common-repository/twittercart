function tcLinkOauth() {
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_link_oauth"
        , type: 'post'
        , dataType: 'json'
        , data: {'tc_secure_field': jQuery("#tc_link_auth_nonce_field").val()}
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
        }
    });
}

function tcDeactivateOauth()
{	
    var link_to_site = jQuery("#collector").attr('site_url');
    jQuery("#tclinkbutton").html("Link my twitter account");
    jQuery("#tcdeactivatebutton").css('display', 'none');
    jQuery("#tcuseraccount").css('display', 'none');
    jQuery.ajax({
        url: link_to_site + "/wp-admin/admin-ajax.php?action=tc_deactivate_account"
        , type: 'post'
        , dataType: 'json'
        , data: {'tc_secure_field': jQuery("#tc_link_auth_nonce_field").val()}
        , beforeSend: function() {
        },
        success: function(res) {
            alert("Your Twitter account was successfully deactivated!");
        }
    });
}