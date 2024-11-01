jQuery(document).ready(function (jQuery) {
    // Display form from link inside a popup
	/*jQuery('#pop_login, #pop_signup').live('click', function (e) {
        formToFadeOut = jQuery('form#register');
        formtoFadeIn = jQuery('form#login');
        if (jQuery(this).attr('id') == 'pop_signup') {
            formToFadeOut = jQuery('form#login');
            formtoFadeIn = jQuery('form#register');
        }
        formToFadeOut.fadeOut(500, function () {
            formtoFadeIn.fadeIn();
        })
        return false;
    });
	// Close popup
    jQuery(document).on('click', '.login_overlay, .close', function () {
		jQuery('form#login, form#register').fadeOut(500, function () {
            jQuery('.login_overlay').remove();
        });
        return false;
    });*/

    // Show the login/signup popup on click
    jQuery('#show_login, #show_signup').on('click', function (e) {
        jQuery('body').prepend('<div class="login_overlay"></div>');
		console.log(jQuery(this).attr('id'));
        if (jQuery(this).attr('id') == 'show_login')
		{ 
			jQuery('form#simple_popup').fadeIn(500);
		}
        e.preventDefault();
		
    });

	// Perform AJAX login/register on form submit
	/*jQuery('form#login, form#register').on('submit', function (e) {
        if (!jQuery(this).valid()) return false;
        jQuery('p.status', this).show().text(ajax_auth_object.loadingmessage);
		action = 'ajaxlogin';
		username = 	jQuery('form#login #username').val();
		password = jQuery('form#login #password').val();
		email = '';
		security = jQuery('form#login #security').val();
		if (jQuery(this).attr('id') == 'register') {
			action = 'ajaxregister';
			username = jQuery('#signonname').val();
			password = jQuery('#signonpassword').val();
        	email = jQuery('#email').val();
        	security = jQuery('#signonsecurity').val();	
		}  
		ctrl = jQuery(this);
		jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_auth_object.ajaxurl,
            data: {
                'action': action,
                'username': username,
                'password': password,
				'email': email,
                'security': security
            },
            success: function (data) {
				jQuery('p.status', ctrl).text(data.message);
				if (data.loggedin == true) {
                    document.location.href = ajax_auth_object.redirecturl;
                }
            }
        });
        e.preventDefault();
    });
	
	// Client side form validation
    if (jQuery("#register").length) 
		jQuery("#register").validate(
		{ 
			rules:{
			password2:{ equalTo:'#signonpassword' 
			}	
		}}
		);
    else if (jQuery("#login").length) 
		jQuery("#login").validate();*/
});