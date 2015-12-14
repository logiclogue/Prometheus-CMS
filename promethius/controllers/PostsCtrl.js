app.controller('PostsCtrl', function ($scope, $http, $location, $route, util)
{
	var data = {
		title: null
	};

	util.notLoggedIn(function () {
		$location.path('/login');
	});


	$scope.button_CreatePost = function () {
		$location.path('/posts/new');
	};

	$scope.button_Logout = function () {
		util.fetch('models/Logout.php', '', function () {
			$route.reload();
		});
	};

	$scope.button_Delete = function (id) {
		util.fetch('models/DeletePost.php', { id: id }, function (response) {
			$route.reload();
		});
	};


	util.fetch('models/GetPost.php', data, function (response) {
		$scope.posts = response.data;
	});
});