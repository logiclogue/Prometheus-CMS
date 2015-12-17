<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<title>Prometheus CMS</title>

	<script src="lib/angular.min.js"></script>
	<script src="lib/angular-route.min.js"></script>

	<!-- inject:js -->
	<script src="app/app.js"></script>
	<script src="app/util.js"></script>
	<script src="controllers/ContentCtrl.js"></script>
	<script src="controllers/EditCtrl.js"></script>
	<script src="controllers/LoginCtrl.js"></script>
	<script src="controllers/PostsCtrl.js"></script>
	<!-- endinject -->

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="lib/normalize.css">
	<link rel="stylesheet" href="lib/skeleton.css">

</head>
<body ng-app="promethius-cms">

	<div ng-view></div>

</body>
</html>