var app = angular.module('promethius-cms', ['ngRoute']);


app.config(['$routeProvider', function ($routeProvider)
{
	$routeProvider
	.when('/', {
		templateUrl: 'views/content.html',
		controller: 'ContentCtrl'
	})
	.when('/login', {
		templateUrl: 'views/login.html',
		controller: 'LoginCtrl'
	})
	.otherwise({
		redirectTo: '/login'
	});
}]);


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


app.controller('LoginCtrl', function ($scope, $http, $location, status)
{
	var data = {};


	function checkLoggedIn(response) {
		if (JSON.parse(response)) {
			$location.path('/');
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


app.controller('ContentCtrl', function ($scope, $sce, $http, status)
{
	var data = {
		title: 'Test Title'
	};

	$scope.isLoggedIn = false;

	$http({
		url: 'models/GetPost.php',
		method: 'POST',
		data: 'JSON=' + JSON.stringify(data),
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
	})
	.then(function (response) {
		$scope.title = response.data.title;
		$scope.content = $sce.trustAsHtml(response.data.content);
		$scope.date = response.data.date;
	});

	status.get(function (response) {
		$scope.isLoggedIn = JSON.parse(response.logged_in);
	});


	$scope.logout = function () {
		var data = {
			command: 'logout'
		}

		$http({
			url: 'models/Login.php',
			method: 'POST',
			data: 'JSON=' + JSON.stringify(data),
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		});
	};
});