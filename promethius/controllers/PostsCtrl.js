app.controller('PostsCtrl', function ($scope, $http, $location, $route, util)
{
	var data = {
		title: null
	};

	util.status(function (response) {
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

	$scope.logout = function () {
		$http({
			url: 'models/Logout.php',
			method: 'POST',
			data: 'JSON=',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		})
		.then(function (response) {
			$route.reload();
		});
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