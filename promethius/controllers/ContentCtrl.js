app.controller('ContentCtrl', function ($scope, $sce, $http, util)
{
	var data = {
		title: 'Test Title',
		format: 'HTML'
	};

	$scope.isLoggedIn = false;


	util.status(function (response) {
		$scope.isLoggedIn = JSON.parse(response.logged_in);
	});

	util.fetch('models/GetPost.php', data, function (response) {
		response.data = response.data[0];
		
		$scope.title = response.data.title;
		$scope.content = $sce.trustAsHtml(response.data.content);
		$scope.date = response.data.date;
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