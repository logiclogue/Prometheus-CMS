app.controller('LoginCtrl', function ($scope, $http, $location, status)
{
	var data = {};


	function checkLoggedIn(response) {
		if (JSON.parse(response)) {
			$location.path('/posts');
		}
	}


	$scope.submit = function () {
		data = {
			command: 'login',
			username: $scope.username,
			password: $scope.password
		}

		$http({
			url: 'models/Login.php',
			method: 'POST',
			data: 'JSON=' + JSON.stringify(data),
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		})
		.then(function (response) {
			checkLoggedIn(response.data);
		});
	};

	status.get(function (response) {
		checkLoggedIn(response.logged_in);
	});
});