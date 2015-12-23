app.controller('EditCtrl', function ($scope, $http, $location, $routeParams, util)
{
	var data = {
		id: $routeParams.param
	};

	$scope.isLoading = false;


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
			$scope.tags = JSON.stringify(response.data[0].tags).replace(/"|\[|\]/g, '');
			$scope.tags = $scope.tags.replace(/,/g, ', ');
		});
	};

	function getTags() {
		return ($scope.tags || '').match(/\w+/g);
	};

	function getCommon() {
		$scope.isLoading = true;

		data.title = $scope.title;
		data.content = ($scope.content || '');
		data.tags = getTags();
	};


	$scope.create = function () {
		getCommon();
		data.date = '0000-00-00';

		util.fetch('models/CreatePost.php', data, function (response) {
			if (response.data) {
				$location.path('/posts');
			}
		});
	};

	$scope.update = function () {
		getCommon();

		util.fetch('models/UpdatePost.php', data, function (response) {
			if (response.data) {
				alert('Update successfully');
			}
			else {
				alert('Failed to update');
			}

			$scope.isLoading = false;
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