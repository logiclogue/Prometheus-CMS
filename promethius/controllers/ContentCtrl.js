app.controller('ContentCtrl', function ($scope, $sce, $http, util)
{
	var data = {
		format: 'HTML'
	};

	util.fetch('models/GetPost.php', data, function (response) {
		$scope.posts = response.data;
		
		$scope.posts.forEach(function (i) {
			i.content = $sce.trustAsHtml(i.content);
		});
	});
});