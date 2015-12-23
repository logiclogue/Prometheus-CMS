var app = angular.module('promethius-cms', ['ngRoute']);


app.config(['$routeProvider', function ($routeProvider)
{
	$routeProvider
	.when('/', {
		templateUrl: 'views/login.html',
		controller: 'LoginCtrl'
	})
	.when('/login', {
		templateUrl: 'views/login.html',
		controller: 'LoginCtrl'
	})
	.when('/content', {
		templateUrl: 'views/content.html',
		controller: 'ContentCtrl'
	})
	.when('/posts', {
		templateUrl: 'views/posts.html',
		controller: 'PostsCtrl'
	})
	.when('/posts/:param', {
		templateUrl: 'views/edit.html',
		controller: 'EditCtrl'
	})
	.otherwise({
		redirectTo: '/login'
	});
}]);