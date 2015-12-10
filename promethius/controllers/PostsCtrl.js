app.controller('PostsCtrl', function ($scope, $http, $location, $route, status)
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

	$scope.delete = function (id) {
		$http({
			url: 'models/DeletePost.php',
			method: 'POST',
			data: 'JSON=' + JSON.stringify({ id: id }),
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		})
		.then(function (response) {
			console.log(response);
		});

		$route.reload();
	};


	$http({
		url: 'models/GetPost.php',
		method: 'POST',
		data: 'JSON=' + JSON.stringify(data),
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
	})
	.then(function (response) {
		$scope.posts = response.data;
	});
});