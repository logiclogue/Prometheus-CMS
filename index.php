<?php require_once('models/GetPost.php'); session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Prometheus CMS</title>

	<script src="lib/angular.min.js"></script>
	<script src="js/Main.js"></script>
</head>
<body ng-app="promethius-cms">

	<div ng-view></div>

</body>
</html>