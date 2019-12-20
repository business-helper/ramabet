/**
Core script to handle the Anima core functions
**/
var usertoken='none';
var userID=0;
(function( Anima, $, undefined ) {
	
	var contextroot;
	var skin;

	var rtime;
	var timeout = false;
	var delta = 200;
	
	$(window).resize(function() {
	    rtime = new Date();
	    if (timeout === false) {
	        timeout = true;
	        setTimeout(resizeend, delta);
	    }
	});

	function resizeend() {
	    if (new Date() - rtime < delta) {
	        setTimeout(resizeend, delta);
	    } else {
	        timeout = false;
	    	Anima.setHeight();
	    }               
	}
    /* Usermenu Integration */
	Anima.handleTokenResponse = function(e) {
		if (e.origin == e.origin) {

			var json = e.data;

			console.log('testing',json);

			if (json == null)
				return;
			
			if (typeof json !== 'string' || !json instanceof String)
				return;
			
			if (json.indexOf(":") < 0)
				return;


			var action = json.split(':')[0];
			if (action == "setToken") {
				var params = json.split(':')[1].split('=')[1];
				if (params != "" && params.split('|').length == 3 && params.split('|')[2] == "oddsexchange") {
					var tokenOE = params.split('|')[0];
					var uname = params.split('|')[1];
					
					var jsonUser = {username: uname, token: tokenOE};
                    // ADD YOUR CODE TO SEND THE TOKEN TO THE SERVER (IF IT IS NEEDED)
					console.log('join_user',jsonUser);
                    usertoken=jsonUser;
                    Event.$emit('userLogin',usertoken);

				}
			}
			else if (action == "setUser") {
				var user = JSON.parse(json.substring(json.indexOf(':') + 1));
				var jsonUser = {username: user.username, token: ""};
				// ADD YOUR CODE TO SEND THE TOKEN TO THE SERVER (IF IT IS NEEDED)
                usertoken=jsonUser;
                Event.$emit('userLogin',usertoken);
			}
			else if (action == "setLogout") {
				var jsonUser = {username: "", token: ""};
				// ADD YOUR CODE TO REMOVE THE TOKEN FROM THE SERVER (IF IT IS NEEDED)
                usertoken=jsonUser;
			}
			else if (action == "setDimension") {
				var params = json.replace('setDimension:','');
				if (params != "") {
					var obj = JSON.parse(params);
					var w = obj.w;
					var h = obj.h;
					changeWindowSize(w, h);
				}
			}
		}
		else {
			console.log(e);
		}
	}
	
	Anima.setHeight = function() {
        var height = Math.max($(".home_page").height() + 150, 800);
		window.parent.postMessage('getHeight:' + height, '*');
		window.parent.postMessage('jumpToTop', '*');
	}
	
	Anima.openLogin = function() {
		window.parent.postMessage('openLogin', '*');
	}
	
	Anima.setCDN = function(cdnurl) {
		cdn = cdnurl;
	}

	Anima.setContextRoot = function(root) {
		contextroot = root;
	}

	Anima.setSkin = function(currentSkin) {
		skin = currentSkin;
		console.debug(" - skin = " + skin);
	}

	Anima.notifyMessage = function(message, type, duration) {
		if (duration == null)
			duration = "5000";
		toastr.options = {
				"closeButton": true,
				"debug": false,
				"positionClass": "toast-top-left",
				"onclick": null,
				"showDuration": "1000",
				"hideDuration": "1000",
				"timeOut": duration,
				"progressBar": true,
				"preventDuplicates": true,
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
				}
	
		if (type=="success")
			toastr.success(message);
		else if (type=="info")
			toastr.info(message);
		else if (type=="warning")
			toastr.warning(message);
		else
			toastr.error(message);

		var bc = $(".toast-container");
		if (bc.length > 0) {
			$('html,body').animate({scrollTop: bc.offset().top}, 100);
		}
	};

	Anima.notifyMessage = function(message, type, duration, autoclose, position) {
		if (duration == null) duration = "5000";

		if (autoclose == null) 
			autoclose = true;
		else if (autoclose == false) {
			duration = 0;
		}
		
		if (position == null) position = "toast-top-left";
		
		toastr.options = {
				"closeButton": true,
				"debug": false,
				"positionClass": position,
				"onclick": null,
				"showDuration": "1000",
				"hideDuration": "1000",
				"timeOut": duration,
				"progressBar": true,
				"preventDuplicates": true,
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
				}
	
		if (type=="success")
			toastr.success(message);
		else if (type=="info")
			toastr.info(message);
		else if (type=="warning")
			toastr.warning(message);
		else
			toastr.error(message);

		var bc = $(".toast-container");
		if (bc.length > 0) {
			$('html,body').animate({scrollTop: bc.offset().top}, 100);
		}
	};

}( window.Anima = window.Anima || {}, jQuery ));