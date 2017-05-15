app.constant("COURT_RESERVATIONS_ENDPOINT", "php/api/user/");
app.service("UserService", function($http, COURT_RESERVATIONS_ENDPOINT) {

	function getUrl() {
		return(COURT_RESERVATIONS_ENDPOINT);
	}

	function getUrlForId(reservationId) {
		return(getUrl() + reservationId);
	}

	this.fetchReservationById = function(reservationId) {
		return($http.get(getUrlForId(reservationIdId)));
	};

	this.fetchreservationByDate = function(resDateTime) {
		return($http.get(getUrl()+ "?resDateTime=" + resDateTime));
	};

	this.fetchReservationByTeamname = function(teamName) {
		return($http.get(getUrl()+ "?teamName=" + teamName));
	};

	this.fetchAllReservations = function() {
		return($http.get(getUrl()));
	};

	this.update = function(userId, user) {
		return($http.put(getUrlForUserId(userId, user)));
	};

	this.destroy = function(userId) {
		return($http.delete(getUrlForId(userId)));
	}
});