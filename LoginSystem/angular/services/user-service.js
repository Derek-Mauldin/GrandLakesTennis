app.constant("USER_ENDPOINT", "php/api/user/");
app.service("UserService", function($http, USER_ENDPOINT) {

	function getUrl() {
		return(USER_ENDPOINT);
	}

	function getUrlForId(userId) {
		return(getUrl() + userId);
	}

	this.fetchUserById = function(userId) {
		return($http.get(getUrlForId(userId)));
	};

	this.fetchUserByEmail = function(userEmail) {
		return($http.get(getUrl()+ "?email=" + userEmail));
	};


	this.fetchUserByUsername = function(userName) {
		return($http.get(getUrl()+ "?userName=" + userName));
	};

	this.fetchAllUsers = function() {
		return($http.get(getUrl()));
	};

	this.update = function(userId, user) {
		return($http.put(getUrlForUserId(userId, user)));
	};

	this.destroy = function(userId) {
		return($http.delete(getUrlForId(userId)));
	}
});