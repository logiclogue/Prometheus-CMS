<?php require_once('models/GetPost.php'); require_once('lib/Parsedown.php'); session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Prometheus CMS</title>
</head>
<body>
	<?php

	$parsedown = new Parsedown();

	echo $parsedown->text(GetPost::call(array('title' => 'Test Post'))['content']);

	?>
</body>
</html>