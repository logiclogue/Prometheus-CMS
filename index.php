<?php require_once('models/GetPost.php'); session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Prometheus CMS</title>

	<script src="lib/angular.min.js"></script>
	<script src="js/Main.js"></script>
</head>
<body ng-app="promethius-cms">
	<div id="page-nav">
		<ul>
			<li>Posts</li>
			<li>Login</li>
		</ul>
	</div>

	<div ng-controller="login" id="page-login">
		<table>
			<tr>
				<td>Username</td>
				<td><input id="input-username" type="text"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input id="input-password" type="password"></td>
			</tr>
		</table>

		<button>Login</button>
	</div>

	<div id="page-content" ng-controller="content">
		<h1 id="h1-title" ng-bind="title"></h1>
		<div id="div-content" ng-bind-html="content"></div>
		<small id="small-date" ng-bind="date"></small>
	</div>
</body>
</html>