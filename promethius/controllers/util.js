app.factory('util', function ($http) {
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