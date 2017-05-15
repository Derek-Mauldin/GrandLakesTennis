app.constant("SIGNOUT_ENDPOINT", "php/api/signout/");
app.service("SignoutService", function($http, SIGNOUT_ENDPOINT) {
	function getUrl() {
		return(SIGNOUT_ENDPOINT);
	}

	this.signout = function() {
		return ($http.get(getUrl()));
	}
});
