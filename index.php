<?php require_once('models/GetPost.php'); session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Prometheus CMS</title>
</head>
<body>
	<?php

	$parsedown = new Parsedown();

	echo GetPost::call(array('title' => 'Test Title'))['content'];

	?>
</body>
</html>