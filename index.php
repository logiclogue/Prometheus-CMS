<!DOCTYPE html>
<html>
<head>
	<title>Prometheus CMS</title>

	<script src="lib/angular.min.js"></script>
	<script src="lib/angular-route.min.js"></script>
	<script src="js/app.js"></script>
	<script src="controllers/status.js"></script>
	<script src="controllers/LoginCtrl.js"></script>
	<script src="controllers/ContentCtrl.js"></script>
	<script src="controllers/PostsCtrl.js"></script>
	<script src="controllers/EditCtrl.js"></script>
</head>
<body ng-app="promethius-cms">

	<div ng-view></div>

</body>
</html>