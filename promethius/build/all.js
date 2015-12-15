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

		util.fetch('models/CreatePost.php', data, function (response) {
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
app.controller('LoginCtrl', function ($scope, $http, $location, util)
{
	var data = {};


	function checkLoggedIn(response) {
		if (JSON.parse(response)) {
			$location.path('/posts');
		}
	}


	$scope.submit = function () {
		data = {
			username: $scope.username,
			password: $scope.password
		}

		util.fetch('models/Login.php', data, function (response) {
			checkLoggedIn(response.data);
		});
	};

	util.status(function (response) {
		checkLoggedIn(response.logged_in);
	});
});
app.controller('PostsCtrl', function ($scope, $http, $location, $route, util)
{
	var data = {
		title: null
	};

	util.status(function (response) {
		if (!response.logged_in) {
			$location.path('/login');
		}
	});


	$scope.createPost = function () {
		$location.path('/posts/new');
	};

	$scope.delete = function (id) {
		util.fetch('models/DeletePost.php', { id: id }, function (response) {
			console.log(response);
		});

		$route.reload();
	};

	$scope.logout = function () {
		util.fetch('models/Logout.php', '', function () {
			$route.reload();
		});
	};


	util.fetch('models/GetPost.php', data, function (response) {
		$scope.posts = response.data;
	});
});
app.factory('util', function ($http)
{
	return {
		status: function (callback) {
			$http({
				url: 'models/Status.php',
				method: 'GET'
			})
			.then(function (response) {
				callback(response.data);
			});
		},
		
		fetch: function (url, data, callback) {
			$http({
				url: url,
				method: 'POST',
				data: 'JSON=' + JSON.stringify(data),
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			})
			.then(callback);
		}
	};
});