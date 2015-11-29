app.controller('PostsCtrl', function ($scope, $http, $location, status)
{
	status.get(function (response) {
		if (!response.logged_in) {
			$location.path('/login');
		}
	});
});