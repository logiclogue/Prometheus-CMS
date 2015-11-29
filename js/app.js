var app = angular.module('promethius-cms', ['ngRoute']);


app.config(['$routeProvider', function ($routeProvider)
{
	$routeProvider
	.when('/', {
		templateUrl: 'views/content.html',
		controller: 'ContentCtrl'
	})
	.when('/login', {
		templateUrl: 'views/login.html',
		controller: 'LoginCtrl'
	})
	.when('/posts', {
		templateUrl: 'views/posts.html',
		controller: 'PostsCtrl'
	})
	.otherwise({
		redirectTo: '/login'
	});
}]);