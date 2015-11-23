var app = angular.module('promethius-cms', []);


app.factory('status', function () {
	return true;
});


app.controller('login', function ($scope, $http, status)
{
	$scope.submit = function () {
		var data = {
			command: 'login',
			username: $scope.username,
			password: $scope.password
		}

		$http({
			url: 'models/Login.php',
			method: 'POST',
			data: 'JSON=' + JSON.stringify(data),
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		}).then(function (response) {
			console.log(response.data);
		});
	};
});


app.controller('content', function ($scope, $sce, $http)
{
	var data = {
		title: 'Test Title'
	};

	$http({
		url: 'models/GetPost.php',
		method: 'POST',
		data: 'JSON=' + JSON.stringify(data),
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
	}).then(function (response) {
		$scope.title = response.data.title;
		$scope.content = $sce.trustAsHtml(response.data.content);
		$scope.date = response.data.date;
	});

	$http({
		url: 'models/Status.php',
		method: 'GET'
	}).then(function (response) {
		console.log(response.data);
	});
});