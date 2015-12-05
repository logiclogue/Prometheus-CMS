app.controller('ContentCtrl', function ($scope, $sce, $http, status)
{
	var data = {
		title: 'Test Title',
		format: 'HTML'
	};

	$scope.isLoggedIn = false;

	$http({
		url: 'models/GetPost.php',
		method: 'POST',
		data: 'JSON=' + JSON.stringify(data),
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
	})
	.then(function (response) {
		response.data = response.data[0];
		
		$scope.title = response.data.title;
		$scope.content = $sce.trustAsHtml(response.data.content);
		$scope.date = response.data.date;
	});

	status.get(function (response) {
		$scope.isLoggedIn = JSON.parse(response.logged_in);
	});


	$scope.logout = function () {
		var data = {
			command: 'logout'
		}

		$http({
			url: 'models/Login.php',
			method: 'POST',
			data: 'JSON=' + JSON.stringify(data),
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		});
	};
});