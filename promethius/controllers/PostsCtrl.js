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
		util.fetch('models/DeletePost.php', { id: id }, function (response) {
			console.log(response);
		});

		$route.reload();
	};

	$scope.logout = function () {
		util.fetch('models/Logout.php', '', function () {
			$route.reload();
		});
	};


	util.fetch('models/GetPost.php', data, function (response) {
		$scope.posts = response.data;
	});
});