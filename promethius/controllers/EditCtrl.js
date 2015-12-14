app.controller('EditCtrl', function ($scope, $http, $location, $routeParams, util)
{
	var data = {
		id: parseInt($routeParams.param)
	};


	util.status(function (response) {
		if (!response.logged_in) {
			$location.path('/login');
		}
	});

	function getPost() {
		util.fetch('models/GetPost.php', data, function (response) {
			// redirect if post doesn't exist
			if (response.data.length === 0) {
				$location.path('/posts');
				alert("Post doesn't exit");

				return;
			}

			$scope.title = response.data[0].title;
			$scope.content = response.data[0].content;
		});
	};


	$scope.update = function () {
		data.id = null;
		data.title = $scope.title;
		data.content = $scope.content;
		data.date = '0000-00-00';

		$http({
			url: 'models/CreatePost.php',
			method: 'POST',
			data: 'JSON=' + JSON.stringify(data),
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		})
		.then(function (response) {
			if (response.data) {
				$location.path('/posts');
			}
		});
	};


	(function () {
		if ($routeParams.param === 'new') {
			
		}
		else {
			getPost();
		}
	}());
});