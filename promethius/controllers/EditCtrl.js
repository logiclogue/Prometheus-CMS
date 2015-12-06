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

	function getPost() {
		$http({
			url: 'models/GetPost.php',
			method: 'POST',
			data: 'JSON=' + JSON.stringify(data),
			headers:{ 'Content-Type': 'application/x-www-form-urlencoded' }
		})
		.then(function (response) {
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

	};


	(function () {
		if ($routeParams.param === 'new') {
			console.log('you want new?');
		}
		else {
			getPost();
		}
	}());
});