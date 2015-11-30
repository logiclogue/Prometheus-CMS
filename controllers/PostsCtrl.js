app.controller('PostsCtrl', function ($scope, $http, $location, status)
{
	var data = {
		title: null
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
		$scope.posts = response.data;
		console.log($scope.posts);
	});
});