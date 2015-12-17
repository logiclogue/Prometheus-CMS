app.factory('util', function ($http, $location)
{
	return {
		status: function (callback) {
			$http({
				url: 'models/Status.php',
				method: 'GET'
			})
			.then(function (response) {
				callback(response.data);
			});
		},

		notLoggedIn: function (callback) {
			this.status(function (response) {
				if (!response.logged_in) {
					callback();
				}
			});
		},
		
		fetch: function (url, data, callback) {
			$http({
				url: url,
				method: 'POST',
				data: 'JSON=' + JSON.stringify(data),
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			})
			.then(callback);
		}
	};
});