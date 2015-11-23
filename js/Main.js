var app = angular.module('promethius-cms', []);


app.controller('login', function ($scope, $http)
{
	
});


app.controller('content', function ($scope, $sce, $http)
{
	var data = {
		title: 'Test Title'
	};

	$http({
		url: 'models/GetPost.php',
		method: 'POST',
		data: 'JSON=' + JSON.stringify(data),
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
	}).then(function (response) {
		$scope.title = response.data.title;
		$scope.content = $sce.trustAsHtml(response.data.content);
		$scope.date = response.data.date;
	});
});