var login_params=
{
	showTermsLink: 'false'
	,height: 44
	,width: 580
	,containerID: 'componentDiv'
	,UIConfig: '<config><body><controls><snbuttons buttonsize="40" /></controls></body></config>'
	,buttonsStyle: 'fullLogo'
	// Remove hardcode
	,enabledProviders: "facebook, twitter, yahoo, google, wordpress, linkedIn, messenger, myspace, foursquare, aol, blogger, typepad, livejournal, verisign, openid"
	,autoDetectUserProviders: ''
	,facepilePosition: 'none'
	,connectWithoutLoginBehavior: 'alwaysLogin'
}

function onLoginHandler(eventObj) {
	renderLoggedInBlock(eventObj.user.firstName, eventObj.user.thumbnailURL);
	                //   3.1 call linkAccounts method:
			if (eventObj.user.isSiteUID === false) {
					gigya.services.socialize.notifyRegistration(conf, login_params);
			}
}

function afterNotification(response) {
}

gigya.services.socialize.addEventHandlers(conf, {
	onLogin:onLoginHandler,
	onLogout:onLogoutHandler//,
   }
);


// onLogout Event handler
function onLogoutHandler(eventObj) {
	jQuery('.login_wrapper').removeClass('logged_in');
}

// Logout from Gigya platform. This method is activated when "Logout" button is clicked
function logoutFromGS() {
	gigya.services.socialize.logout(conf, {}); // logout from Gigya platform
}

function getUser(response) {
	if ( response.errorCode == 0 ) {
		var user = response['user'];
		if (user['UID'] != "" && parseInt(user['UID']) != 'NaN') {
			conf.scope = 'internal';
			conf.privacy = 'public';
			renderLoggedInBlock(user.firstName, user.thumbnailURL);
			
		}
	}
	else {
		// if we're recieving bad response, log it it console if available
		if (typeof console == "object") {
		console.log ( 'Error :' + response.errorMessage );
		console.log ( response );
		}
	}
}

function renderLoggedInBlock(nickname, thumbnailURL) {
    var html = '<div class="inner clearfix">' +
				'<img width="20" src="' + thumbnailURL +'" />' +
				'<h6>' + nickname +'</h6>' +
				'<a href="javascript:logoutFromGS()" class="sign_out">Sign Out</a>' +
				'</div>';
	jQuery('.login.clearfix').slideUp('fast', function() {
		jQuery('.dropdown-login_link_closed').html(html);
		jQuery('.login_wrapper').addClass('logged_in');
	});
}

window.onload = function() {
gigya.services.socialize.getUserInfo({},{callback:getUser});
}