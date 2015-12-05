app.controller('EditCtrl', function ($scope, $http, $location, $routeParams, status)
{
	var data = {
		id: parseInt($routeParams.param)
	};

	status.get(function (response) {
		if (!response.logged_in) {
			$location.path('/login');
		}
	});

	$http({
		url: 'models/GetPost.php',
		method: 'POST',
		data: 'JSON=' + JSON.stringify(data),
		headers:{ 'Content-Type': 'application/x-www-form-urlencoded' }
	})
	.then(function (response) {
		$scope.title = response.data[0].title;
		$scope.content = response.data[0].content;
	});
});