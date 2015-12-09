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


	$scope.createPost = function () {
		$location.path('/posts/new');
	};

	$scope.delete = function () {
		console.log('DELETE?');
	};


	$http({
		url: 'models/GetPost.php',
		method: 'POST',
		data: 'JSON=' + JSON.stringify(data),
		headers:{ 'Content-Type': 'application/x-www-form-urlencoded' }
	})
	.then(function (response) {
		$scope.posts = response.data;
	});
});