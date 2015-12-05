app.factory('status', function ($http) {
	return {
		get: function (callback) {
			$http({
				url: 'models/Status.php',
				method: 'GET'
			})
			.then(function (response) {
				callback(response.data);
			});
		}
	};
});