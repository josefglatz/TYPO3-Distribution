/*
 * CE Youtube Video Cover
 *
 * Script initially copied from t3brightside/youtubevideo
 */

$( document ).ready(function() {
	$('.youtubeVideo').each(function() {
		if ($(this).width() < 600){
			$(this).addClass( 'small' );
		} else{
			$(this).removeClass('small')
		}
	});
});

$(window).resize(function(){
	$('.youtubeVideo').each(function() {
		if ($(this).width() < 600){
			$(this).addClass( 'small' );
		} else{
			$(this).removeClass('small')
		}
	});
});


function getFrameID(id) {
	var elem = document.getElementById(id);
	if (elem) {
		if (/^iframe$/i.test(elem.tagName)) return id; //Frame, OK
		// else: Look for frame
		var elems = elem.getElementsByTagName("iframe");
		if (!elems.length) return null; //No iframe found, FAILURE
		for (var i = 0; i < elems.length; i++) {
			if (/^https?:\/\/(?:www\.)?youtube(?:-nocookie)?\.com(\/|$)/i.test(elems[i].src)) break;
		}
		elem = elems[i]; //The only, or the best iFrame
		if (elem.id) return elem.id; //Existing ID, return it
		// else: Create a new ID
		do { //Keep postfixing `-frame` until the ID is unique
			id += "-frame";
		} while (document.getElementById(id));
		elem.id = id;
		return id;
	}
	// If no element, return null.
	return null;
}

// Define YT_ready function.
var YT_ready = (function() {
	var onReady_funcs = [],
		api_isReady = false;
	/* @param func function     Function to execute on ready
       * @param func Boolean      If true, all qeued functions are executed
       * @param b_before Boolean  If true, the func will added to the first
                                   position in the queue*/
	return function(func, b_before) {
		if (func === true) {
			api_isReady = true;
			for (var i = 0; i < onReady_funcs.length; i++) {
				// Removes the first func from the array, and execute func
				onReady_funcs.shift()();
			}
		}
		else if (typeof func == "function") {
			if (api_isReady) func();
			else onReady_funcs[b_before ? "unshift" : "push"](func);
		}
	}
})();
// This function will be called when the API is fully loaded

function onYouTubePlayerAPIReady() {
	YT_ready(true)
}

var players = {};
//Define a player storage object, to enable later function calls,
//  without having to create a new class instance again.
YT_ready(function() {
	$(".coverimage + iframe[id]").each(function() {
		var identifier = this.id;
		var frameID = getFrameID(identifier);
		if (frameID) { //If the frame exists
			players[frameID] = new YT.Player(frameID, {
				events: {
					"onReady": createYTEvent(frameID, identifier)
				}
			});
		}
	});
});


// Returns a function to enable multiple events
function createYTEvent(frameID, identifier) {
	return function (event) {
		var player = players[frameID]; // player object
		var the_div = $('#'+identifier).parent();
		the_div.children('.coverimage').click(function() {
			var $this = $(this);
			$this.fadeOut().next().addClass('play');
			if ($this.next().hasClass('play')) {
				player.playVideo();
			}
			setTimeout(doSomething, 700);
			function doSomething() {
				$('#'+frameID).show();
			};
		});
	}
}


// Load YouTube Frame API
(function(){ //Closure, to not leak to the scope
	var s = document.createElement("script");
	s.src = "https://www.youtube.com/player_api"; /* Load Player API*/
	var before = document.getElementsByTagName("script")[0];
	before.parentNode.insertBefore(s, before);
})();


