var Ajax = new (function ()
{
	var self = this;

	self.requestName = 'JSON';
	self.data = {};
	self.uri = 'models/GetPost.php';


	self.call = function (callback) {
		var xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = function () {
			if (xhttp.readyState === 4 && xhttp.status === 200) {
				callback(xhttp.responseText);
			}
		};

		xhttp.open('POST', self.uri, true);
		xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhttp.send(self.requestName + '=' + JSON.stringify(self.data));
	};
});


var Main = new (function ()
{
	window.addEventListener('load', function () {
		Ajax.data = {
			title: 'Test Title'
		};

		Ajax.call(function (data) {
			console.log(data);
		});
	});
});


var app = angular.module('promethius-cms', []);


app.controller('login', function ($scope, $http)
{
	
});


app.controller('content', function ($scope, $http)
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
		$scope.content = response.data.content;
		$scope.date = response.data.date;
	});
});