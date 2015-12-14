app.controller('EditCtrl', function ($scope, $http, $location, $routeParams, util)
{
	var data = {
		id: parseInt($routeParams.param)
	};


	util.notLoggedIn(function () {
		$location.path('/login');
	});


	function getPost() {
		util.fetch('models/GetPost.php', data, function (response) {
			// redirect if post doesn't exist
			if (response.data.length === 0) {
				alert("Post doesn't exit");
				$location.path('/posts');

				return;
			}

			// else populate the fields
			$scope.title = response.data[0].title;
			$scope.content = response.data[0].content;
		});
	};


	$scope.create = function () {
		data.id = null;
		data.title = $scope.title;
		data.content = $scope.content;
		data.date = '0000-00-00';

		util.fetch('models/CreatePost.php', data, function (response) {
			if (response.data) {
				$location.path('/posts');
			}
		});
	};

	$scope.update = function () {
		data.title = $scope.title;
		data.content = $scope.content;

		util.fetch('models/UpdatePost.php', data, function (response) {
			if (response.data) {
				alert('Update successfully');
			}
			else {
				alert('Failed to update');
			}
		});
	};


	(function () {
		if ($routeParams.param === 'new') {
			$scope.isCreate = true;
		}
		else {
			$scope.isCreate = false;

			// load the post
			getPost();
		}
	}());
});