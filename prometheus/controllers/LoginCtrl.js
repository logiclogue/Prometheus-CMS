app.controller('LoginCtrl', function ($scope, $http, $location, util)
{
	var data = {};


	function checkLoggedIn(response) {
		if (JSON.parse(response)) {
			$location.path('/posts');
		}
	}


	$scope.submit = function () {
		data = {
			username: $scope.username,
			password: $scope.password
		}

		util.fetch('models/Login.php', data, function (response) {
			checkLoggedIn(response.data);
		});
	};

	util.status(function (response) {
		checkLoggedIn(response.logged_in);
	});
});